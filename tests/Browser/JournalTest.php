<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

class JournalTest extends DuskTestCase
{
    /**
     * Login first before making further tests.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('username', 'test_user')
                    ->type('password', 'secret')
                    ->press('#login-button')
                    ->waitForLocation('/swift/system/main')
                    ->assertPathIs('/swift/system/main');
        });
    }

    /**
     * Navigate to journal page.
     *
     * @return void
     */
    public function testNavigateJournal()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/swift/system/main')
                    ->click('.sidebar-toggle')
                    ->click('#menu_accounting')
                    ->click('#journal')
                    ->waitForText('Ver Entradas')
                    ->assertSee('Ver Entradas');
        });
    }

    /**
     * Journal Test.
     *
     * @return void
     */
    public function testJournalPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->type('#journal-date-range', date('m/d/Y').' - '.date('m/d/Y', strtotime('+1 day')))
                    //->click('#journal-view-entries-tab')
                    ->keys('#journal-date-range', ['{enter}'])
                    ->click('#journal-search')
                    ->pause(1000)
                    //->assertSourceHas('<tr class="journal-entry-row"><td>102</td><td>Cuentas de Banco</td><td>0</td><td>50000</td><td>1000</td><td>49000</td></tr>')
                    ->assertSeeIn('.journal-entry-row:nth-child(1)', '49000')
                    ->select('#journal-group-entry', 'detail')
                    ->click('#journal-search')
                    ->waitForText('444.1.1')
                    ->assertSeeIn('#entry-1','50000')
                    ->driver->executeScript('window.scrollTo(0, 895);');

            $browser->click('#journal-create-entry')
                    ->waitForText('Crear Entrada')
                    ->click('#journal-create-add')
                    ->waitForText('Cuenta no se puede dejar en blanco!')
                    ->assertSee('Cuenta no se puede dejar en blanco!')
                    ->type('#create-entry-account', '102.1')
                    ->type('#create-entry-amount', '1000')
                    ->select('#create-entry-type', 'credit')
                    ->type('#create-entry-description', 'Pago a Deuda')
                    ->click('#journal-create-add')
                    ->type('#create-entry-account', '444.2.1')
                    ->select('#create-entry-type', 'debit')
                    ->click('#journal-create-add')
                    ->click('#journal-create-add')
                    ->click('#create-entry-create')
                    ->waitForText('Suma de entradas de credito y debito no es igual!')
                    ->assertSee('Suma de entradas de credito y debito no es igual!')
                    ->rightClick('#create-entry-2')
                    ->click('.context-menu-item:nth-child(1)')
                    ->click('#create-entry-create')
                    ->waitForText('Entradas creadas exitosamente!')
                    ->assertSee('Entradas creadas exitosamente!')
                    ->pause(7)
                    ->driver->executeScript('window.scrollTo(0, -275);');
        });
    }

    public function testReports() {
      $this->browse(function (Browser $browser) {
          $browser->click('#journal-reports-tab')
                  ->waitForText('Generar')
                  ->click('#journal-reports-create')
                  ->waitForText('Crear Reporte')
                  ->type('#journal-create-report-variable', 'activo')
                  ->type('#journal-create-report-content', 'calc(variacion({"tipo":"activos"}))')
                  ->click('#journal-create-report-add')
                  ->waitForText('No se pudo reconocer el siguiente tipo de cuenta: activos')
                  ->assertSee('No se pudo reconocer el siguiente tipo de cuenta: activos')
                  ->click('#journal-create-report-add')
                  ->type('#journal-create-report-content', 'calc(variacion({"tipo":\'activo\'}))')
                  ->click('#journal-create-report-add')
                  ->waitForText('Existe un error en el siguente objeto {"tipo":\'activo\'}')
                  ->assertSee('Existe un error en el siguente objeto {"tipo":\'activo\'}')
                  ->type('#journal-create-report-content', 'calc(variacion({"tipo":"activo"})-variacion({"tipo":"contra activo"}))')
                  ->click('#journal-create-report-add')
                  ->type('#journal-create-report-variable', 'pasivo')
                  ->type('#journal-create-report-content', 'calc(variacion({"tipo":"pasivo"}))')
                  ->click('#journal-create-report-add')
                  ->type('#journal-create-report-variable', 'patrimonio')
                  ->type('#journal-create-report-content', 'calc(variacion({"tipo":"patrimonio"}))')
                  ->click('#journal-create-report-add')
                  ->type('#journal-create-report-title', 'Hoja de Balance')
                  ->driver->executeScript('window.scrollTo(0, 600);');

          $browser->rightClick('#report-layout')
                  //->waitFor('.context-menu-visible')
                  ->click('.report-add-row')
                  ->waitForText('Crear Fila')
                  ->assertSee('Crear Fila')
                  ->type('#create-report-row-columns', '4')
                  ->click('#create-report-row-create')
                  ->type('#col-0-0', '<b>Activos</b>')
                  ->keys('#col-0-0', ['{enter}'])
                  ->pause(500)
                  ->type('#col-0-1', 'variable(activo)')
                  ->keys('#col-0-1', ['{enter}'])
                  ->pause(500)
                  ->type('#col-0-2', '<b>Pasivos</b>')
                  ->keys('#col-0-2', ['{enter}'])
                  ->pause(500)
                  ->type('#col-0-3', 'variable(pasivo)')
                  ->keys('#col-0-3', ['{enter}'])
                  ->pause(500)
                  ->rightClick('#report-layout')
                  ->click('.report-add-row')
                  ->waitForText('Crear Fila')
                  ->assertSee('Crear Fila')
                  ->type('#create-report-row-columns', '4')
                  ->click('#create-report-row-create')
                  ->type('#col-1-2', '<b>Patrimonio</b>')
                  ->keys('#col-1-2', ['{enter}'])
                  ->pause(500)
                  ->type('#col-1-3', 'variable(patrimonio)')
                  ->keys('#col-1-3', ['{enter}'])
                  ->pause(500)
                  ->click('#journal-create-report-create')
                  ->waitForText('Reporte creado exitosamente!')
                  ->assertSee('Reporte creado exitosamente!')
                  ->type('#journal-reports-date-range', date('m/d/Y').' - '.date('m/d/Y', strtotime('+1 day')))
                  ->keys('#journal-reports-date-range', ['{enter}'])
                  ->click('#journal-reports-generate')
                  ->waitForText('Activos')
                  ->assertSee('Activos')
                  ->pause(6000);
        });
    }

    public function testGraphs() {
      $this->browse(function (Browser $browser) {
          $browser->click('#journal-graphs-tab')
                  ->waitForText('Generar')
                  ->click('#journal-graphs-create')
                  ->waitForText('Crear Grafico')
                  ->type('#journal-create-graph-variable', 'activo')
                  ->type('#journal-create-graph-content', 'calc(variacion({"tipo":"activos"}))')
                  ->click('#journal-create-graph-add')
                  ->waitForText('No se pudo reconocer el siguiente tipo de cuenta: activos')
                  ->assertSee('No se pudo reconocer el siguiente tipo de cuenta: activos')
                  ->click('#journal-create-graph-add')
                  ->type('#journal-create-graph-content', 'calc(variacion({"tipo":\'activo\'}))')
                  ->click('#journal-create-graph-add')
                  ->waitForText('Existe un error en el siguente objeto {"tipo":\'activo\'}')
                  ->assertSee('Existe un error en el siguente objeto {"tipo":\'activo\'}')
                  ->type('#journal-create-graph-content', 'calc(variacion({"tipo":"activo"})-variacion({"tipo":"contra activo"}))')
                  ->click('#journal-create-graph-add')
                  ->type('#journal-create-graph-variable', 'pasivo')
                  ->type('#journal-create-graph-content', 'calc(variacion({"tipo":"pasivo"}))')
                  ->click('#journal-create-graph-add')
                  ->type('#journal-create-graph-variable', 'patrimonio')
                  ->type('#journal-create-graph-content', 'calc(variacion({"tipo":"patrimonio"}))')
                  ->click('#journal-create-graph-add')
                  ->type('#journal-create-graph-title', 'Grafico de Balance')
                  ->value('#variable-activo > div > input', '#ff0000')
                  ->value('#variable-pasivo > div > input', '#0aff00')
                  ->select('#journal-create-graph-graphed-variables', 'activo')
                  ->select('#journal-create-graph-graphed-variables', 'pasivo')
                  ->driver->executeScript('window.scrollTo(0, 600);');

          $browser->click('#journal-create-graph-create')
                  ->waitForText('Grafico creado exitosamente!')
                  ->assertSee('Grafico creado exitosamente!')
                  ->type('#journal-graphs-date-range', date('m/d/Y').' - '.date('m/d/Y', strtotime('+1 day')))
                  ->keys('#journal-graphs-date-range', ['{enter}'])
                  ->click('#journal-graphs-generate')
                  ->pause(1000)
                  ->assertVisible('#generated-graph')
                  ->pause(6000);

        });
    }


    public function testConfiguration() {
      $this->browse(function (Browser $browser) {
          $browser->click('#journal-configuration-tab')
                  ->waitForText('Tipo de Entidad')
                  ->driver->executeScript('window.scrollTo(0, 797);');

          $browser->click('#journal-configuration-save')
                  ->waitForText('Cuenta debe ser pasivo: 0')
                  ->assertSee('Cuenta debe ser pasivo: 0')
                  ->type('#journal-configuration-retained-vat', '465.2')
                  ->type('#journal-configuration-advanced-vat', '165.2')
                  ->type('#journal-configuration-retained-it', '465.1')
                  ->type('#journal-configuration-advanced-it', '165.1')
                  ->driver->executeScript('window.scrollTo(0, 740);');

          $browser->click('#journal-configuration-save')
                  ->waitForText('Configuracion actualizado exitosamente!')
                  ->assertSee('Configuracion actualizado exitosamente!');

        });
    }
}
