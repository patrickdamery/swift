<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

class LedgerTest extends DuskTestCase
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
                    ->type('password', 'secret')->press('#login-button')
                    ->waitForLocation('/swift/system/main')
                    ->assertPathIs('/swift/system/main');
        });
    }

    /**
     * Navigate to Ledger page.
     *
     * @return void
     */
    public function testNavigateJournal()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/swift/system/main')
                    ->click('.sidebar-toggle')
                    ->click('#menu_accounting')
                    ->click('#accounts')
                    ->waitForText('Ver Cuentas')
                    ->assertSee('Ver Cuentas')
                    ->click('#accounts-ledger-tab')
                    ->waitForText('Imprimir')
                    ->type('#account-ledger-code', '444.2.1')
                    ->type('#account-ledger-date-range', date('m/d/Y').' - '.date('m/d/Y', strtotime('+1 day')))
                    ->keys('#account-ledger-date-range', ['{enter}'])
                    ->click('#account-ledger-search')
                    ->waitForText('Abono deuda Proveedor 1')
                    ->assertSee('Abono deuda Proveedor 1');
        });
    }
}
