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
                    ->click('#accounts-view-accounts')
                    ->pause(500)
                    ->assertSee('Test Change');
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
                    ->waitForText('Eliminar Cuenta')
                    ->assertSee('Eliminar Cuenta')
                    ->select('#delete-account-option', '1')
                    ->click('#delete-account-delete')
                    ->waitForText('Cuenta eliminada exitosamente!')
                    ->assertSee('Cuenta eliminada exitosamente!');
        });
    }
}
