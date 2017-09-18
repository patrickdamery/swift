<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CurrencyTest extends DuskTestCase
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
  public function testNavigateCurrency()
  {
      $this->browse(function (Browser $browser) {
          $browser->visit('/swift/system/main')
                  ->click('.sidebar-toggle')
                  ->click('#menu_accounting')
                  ->click('#currency')
                  ->waitForText('Ver Monedas')
                  ->assertSee('Ver Monedas');
      });
  }

  /**
   * Currency Test.
   *
   * @return void
   */
  public function testCurrencyPage()
  {
      $this->browse(function (Browser $browser) {
          $browser->visit('/swift/system/main')
                  ->click('.sidebar-toggle')
                  ->click('#menu_accounting')
                  ->click('#currency')
                  ->waitForText('Ver Monedas')
                  ->assertSee('Ver Monedas')
                  ->click('#currency-create')
                  ->waitForText('Crear Moneda')
                  ->assertSee('Crear Moneda')
                  ->type('#create-currency-code','dollar')
                  ->type('#create-currency-description', 'Dollar')
                  ->type('#create-currency-exchange', '2')
                  ->type('#create-currency-buy-rate', '2')
                  ->click('#create-currency-create')
                  ->waitForText('La moneda fue creada exitosamente!')
                  ->assertSee('La moneda fue creada exitosamente!')
                  ->click('#currency-cord > .description-rate')
                  ->type('.change-currency-description', 'Test Cordoba')
                  ->click('#currency-view-currency-tab')
                  ->waitForText('Descripcion actualizada!')
                  ->assertSee('Descripcion actualizada!')
                  ->click('#currency-dollar > .exchange-rate')
                  ->type('.change-rate', '3')
                  ->click('#currency-view-currency-tab')
                  ->waitForText('Tasa cambiada exitosamente!')
                  ->assertSee('Tasa cambiada exitosamente!')
                  ->click('#currency-dollar > .buy-rate')
                  ->type('.change-rate', '3')
                  ->click('#currency-view-currency-tab')
                  ->waitForText('Tasa cambiada exitosamente!')
                  ->assertSee('Tasa cambiada exitosamente!')
                  ->select('#currency-main', 'dollar')
                  ->click('#currency-save-main')
                  ->waitForText('0.3333')
                  ->assertSee('0.3333');
      });
  }
}
