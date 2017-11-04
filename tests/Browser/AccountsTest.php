<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

class AccountsTest extends DuskTestCase
{
    /**
     * Login first before making further tests.
     *
     * @return void
     */
    public function testLogin()
    {
        Artisan::call('migrate:refresh', [
            '--force' => true,
            '--seed' => true
        ]);
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
     * Create Account with Blank fields.
     *
     * @return void
     */
    public function testBlankCreateAccount()
    {
        $this->browse(function (Browser $browser) {
          $browser->visit('/swift/system/main')
                  ->click('.sidebar-toggle')
                  ->click('#menu_accounting')
                  ->click('#accounts')
                  ->waitForText('Ver Cuentas')
                  ->click('#create_account')
                  ->waitForText('Posee Sub Cuentas')
                  ->assertSee('Posee Sub Cuentas')
                  ->click('#create-account-create')
                  ->waitForText('Codigo de Cuenta no puede dejarse en blanco!')
                  ->assertSee('Codigo de Cuenta no puede dejarse en blanco!');
        });
    }

    /**
     * Create Account with Blank fields.
     *
     * @return void
     */
    public function testBadParentCreateAccount()
    {
        $this->browse(function (Browser $browser) {
          $browser->visit('/swift/system/main')
                  ->click('.sidebar-toggle')
                  ->click('#menu_accounting')
                  ->click('#accounts')
                  ->waitForText('Ver Cuentas')
                  ->click('#create_account')
                  ->waitForText('Posee Sub Cuentas')
                  ->assertSee('Posee Sub Cuentas')
                  ->type('#create-account-code', '111')
                  ->type('#create-account-name', 'Efectivo')
                  ->type('#create-account-amount', '100')
                  ->type('#create-account-parent', 'moo')
                  ->click('#create-account-create')
                  ->waitForText('No se pudo encontrar una cuenta valida con el codigo de cuenta padre indicado!')
                  ->assertSee('No se pudo encontrar una cuenta valida con el codigo de cuenta padre indicado!');
        });
    }

    /**
     * Create Account.
     *
     * @return void
     */
    public function testCreateAccount()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/swift/system/main')
                    ->click('.sidebar-toggle')
                    ->click('#menu_accounting')
                    ->click('#accounts')
                    ->waitForText('Ver Cuentas')
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->assertSee('Posee Sub Cuentas')
                    ->type('#create-account-code', '111')
                    ->type('#create-account-name', 'Efectivo')
                    ->type('#create-account-amount', '0')
                    ->select('#create-account-children', '1')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->assertSee('Activo')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '112')
                    ->type('#create-account-name', 'Caja Chica')
                    ->type('#create-account-amount', '0')
                    ->select('#create-account-children', '0')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->assertSee('Activo')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '102')
                    ->type('#create-account-name', 'Cuentas de Banco')
                    ->type('#create-account-amount', '0')
                    ->select('#create-account-children', '1')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '1')
                    ->type('#create-account-name', 'BAC 123456789')
                    ->type('#create-account-amount', '0')
                    ->select('#create-account-children', '0')
                    ->type('#create-account-parent', '102')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '2')
                    ->type('#create-account-name', 'BDF 987654321')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '102')
                    ->select('#create-account-children', '0')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '444')
                    ->type('#create-account-name', 'Cuentas Por Pagar')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '')
                    ->select('#create-account-children', '1')
                    ->select('#create-account-type', 'li')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '1')
                    ->type('#create-account-name', 'Prestamos de Banco')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '444')
                    ->select('#create-account-children', '1')
                    ->select('#create-account-type', 'li')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '1')
                    ->type('#create-account-name', 'Prestamo BAC')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '444.1')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 'li')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '2')
                    ->type('#create-account-name', 'Deudas Proveedores')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '444')
                    ->select('#create-account-children', '1')
                    ->select('#create-account-type', 'li')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '1')
                    ->type('#create-account-name', 'Deuda Proveedor 1')
                    ->type('#create-account-amount', '5000')
                    ->type('#create-account-parent', '444.2')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 'li')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '2')
                    ->type('#create-account-name', 'Deuda Proveedor 2')
                    ->type('#create-account-amount', '3500')
                    ->type('#create-account-parent', '444.2')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 'li')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '333')
                    ->type('#create-account-name', 'Costos')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '')
                    ->select('#create-account-children', '1')
                    ->select('#create-account-type', 'ex')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '1')
                    ->type('#create-account-name', 'Comisiones POS')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '333')
                    ->select('#create-account-children', '1')
                    ->select('#create-account-type', 'ex')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '1')
                    ->type('#create-account-name', 'Comisiones POS BAC 1')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '333.1')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 'ex')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '2')
                    ->type('#create-account-name', 'Gastos por Ventas')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '333')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 'ex')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '3')
                    ->type('#create-account-name', 'Gastos por Depreciacion')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '333')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 'ex')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '666')
                    ->type('#create-account-name', 'Ventas')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '')
                    ->select('#create-account-children', '1')
                    ->select('#create-account-type', 're')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '1')
                    ->type('#create-account-name', 'Ventas de Prueba')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '666')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 're')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '122')
                    ->type('#create-account-name', 'Activos Fijos')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '')
                    ->select('#create-account-children', '1')
                    ->select('#create-account-type', 'as')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '1')
                    ->type('#create-account-name', 'Vehiculos')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '122')
                    ->select('#create-account-children', '1')
                    ->select('#create-account-type', 'as')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '1')
                    ->type('#create-account-name', 'Toyota Corolla')
                    ->type('#create-account-amount', '100000')
                    ->type('#create-account-parent', '122.1')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 'as')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '133')
                    ->type('#create-account-name', 'Depreciacion Acumulada')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '')
                    ->select('#create-account-children', '1')
                    ->select('#create-account-type', 'ca')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '1')
                    ->type('#create-account-name', 'Depreciacion Acumulada Toyota')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '133')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 'ca')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '165')
                    ->type('#create-account-name', 'Impuestos Avanzados')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '')
                    ->select('#create-account-children', '1')
                    ->select('#create-account-type', 'as')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '1')
                    ->type('#create-account-name', 'IR Avanzado')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '165')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 'as')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '2')
                    ->type('#create-account-name', 'IVA Avanzado')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '165')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 'as')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '465')
                    ->type('#create-account-name', 'Impuestos Retenidos')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '')
                    ->select('#create-account-children', '1')
                    ->select('#create-account-type', 'li')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '1')
                    ->type('#create-account-name', 'IR Retenido')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '465')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 'li')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!')
                    ->pause(1000)
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->type('#create-account-code', '2')
                    ->type('#create-account-name', 'IVA Retenido')
                    ->type('#create-account-amount', '0')
                    ->type('#create-account-parent', '465')
                    ->select('#create-account-children', '0')
                    ->select('#create-account-type', 'li')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta ha sido creada exitosamente!');
        });
    }

    /**
     * Create Account with existing parent but wrong account type.
     *
     * @return void
     */
    public function testCreateWrongParentAccount()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/swift/system/main')
                    ->click('.sidebar-toggle')
                    ->click('#menu_accounting')
                    ->click('#accounts')
                    ->waitForText('Ver Cuentas')
                    ->click('#create_account')
                    ->waitForText('Posee Sub Cuentas')
                    ->assertSee('Posee Sub Cuentas')
                    ->type('#create-account-code', '222')
                    ->type('#create-account-name', 'Gastos')
                    ->type('#create-account-amount', '100')
                    ->type('#create-account-parent', '111')
                    ->select('#create-account-type', 'dr')
                    ->select('#create-account-children', '0')
                    ->click('#create-account-create')
                    ->waitForText('La cuenta padre es un tipo de cuenta diferente al de la cuenta que se desea crear!')
                    ->assertSee('La cuenta padre es un tipo de cuenta diferente al de la cuenta que se desea crear!');
        });
    }

    /**
     * Change account.
     *
     * @return void
     */
    public function testChangeAccount()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/swift/system/main')
                    ->click('.sidebar-toggle')
                    ->click('#menu_accounting')
                    ->click('#accounts')
                    ->waitForText('Ver Cuentas')
                    ->click('#account-111 > .account-name')
                    ->type('.change-account', 'Test Change')
                    ->click('#accounts-ledger-tab')
                    ->waitForText('Cuenta actualizada exitosamente!')
                    ->assertSee('Cuenta actualizada exitosamente!');
        });
    }

    /**
     * Search account type.
     *
     * @return void
     */
    public function testSearchAccountType()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/swift/system/main')
                    ->click('.sidebar-toggle')
                    ->click('#menu_accounting')
                    ->click('#accounts')
                    ->waitForText('Ver Cuentas')
                    ->select('#account-type', 're')
                    ->assertDontSee('Test Change')
                    ->select('#account-type', 'all')
                    ->assertSee('Activo');
        });
    }

    /**
     * Delete account.
     *
     * @return void
     */
    public function testDeleteAccount()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/swift/system/main')
                    ->click('.sidebar-toggle')
                    ->click('#menu_accounting')
                    ->click('#accounts')
                    ->waitForText('Ver Cuentas')
                    ->rightClick('#account-111')
                    ->click('.context-menu-item')
                    //->clickLink('Eliminar')
                    ->waitForText('Eliminar Cuenta')
                    ->assertSee('Eliminar Cuenta')
                    ->select('#delete-account-option', '1')
                    ->click('#delete-account-delete')
                    ->waitForText('Cuenta eliminada exitosamente!')
                    ->assertSee('Cuenta eliminada exitosamente!');
        });
    }
}
