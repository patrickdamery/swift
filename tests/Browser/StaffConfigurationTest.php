<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StaffConfigurationTest extends DuskTestCase
{
    /**
     * Staff Configuration Test.
     *
     * @return void
     */
    public function testStaffConfigurationPage()
    {
      $this->browse(function (Browser $browser) {
          $browser->visit('/login')
                  ->type('username', 'test_user')
                  ->type('password', 'secret')
                  ->press('#login-button')
                  ->waitForLocation('/swift/system/main')
                  ->assertPathIs('/swift/system/main')
                  ->click('.sidebar-toggle')
                  ->click('#menu_staff')
                  ->pause(500)
                  ->click('#staff_configuration')
                  ->waitForText('Ver Configuracion')
                  ->assertSee('Ver Configuracion')
                  ->assertSee('Cuentas de Reembolso')
                  ->type('#staff-configuration-code', '1')
                  ->keys('#staff-configuration-code', ['{enter}'])
                  ->click('#staff-configuration-tab')
                  ->pause(500)
                  ->assertInputValue('#staff-configuration-hourly-rate', '0')
                  ->type('#staff-configuration-hourly-rate', '10')
                  ->driver->executeScript('window.scrollTo(0, 2000);');

          $browser->click('#staff-configuration-save')
                  ->waitForText('Configuracion guardada exitosamente!')
                  ->assertSee('Configuracion guardada exitosamente!')
                  ->type('#staff-configuration-reimbursement-code', '112')
                  ->keys('#staff-configuration-reimbursement-code', ['{enter}'])
                  ->waitForText('Caja Chica')
                  ->assertSelectHasOption('#staff-configuration-reimbursement', '112')
                  ->click('#staff-configuration-save')
                  ->waitForText('Configuracion guardada exitosamente!')
                  ->assertSee('Configuracion guardada exitosamente!');
      });
    }
}
