<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountsTest extends DuskTestCase
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
     * Navigate to accounts page.
     *
     * @return void
     */
    public function testNavigateAccount()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/swift/system/main')
                    ->click('.sidebar-toggle')
                    ->click('#menu_accounting')
                    ->click('#accounts')
                    ->waitForText('Ver Cuentas')
                    ->assertSee('Ver Cuentas');
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
                    ->assertSee('Activo');
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
