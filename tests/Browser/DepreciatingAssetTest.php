<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

class DepreciatingAssetTest extends DuskTestCase
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
   * Navigate to depreciating assets page.
   *
   * @return void
   */
  public function testNavigateDepreciatingAssets()
  {
      $this->browse(function (Browser $browser) {
          $browser->visit('/swift/system/main')
                  ->click('.sidebar-toggle')
                  ->click('#menu_accounting')
                  ->click('#depreciating_assets')
                  ->waitForText('Ver Activos')
                  ->assertSee('Ver Activos');
      });
  }

  /**
   * Depreciating Assets Test.
   *
   * @return void
   */
  public function testDepreciatingAssetsPage()
  {
      $this->browse(function (Browser $browser) {
          $browser->click('#create-depreciating-asset-button')
                  ->waitForText('Crear Activo Depreciable')
                  ->type('#create-depreciating-asset-name','Depreciacion Toyota')
                  ->type('#create-depreciating-asset-depreciation', '1500')
                  ->type('#create-depreciating-asset-description', 'Depreciacion Toyota Prueba')
                  ->type('#create-depreciating-asset-account', '122.1.1')
                  ->type('#create-depreciating-expense-account', '333.3')
                  ->type('#create-depreciating-depreciation-account', '133.1')
                  ->click('#create-depreciating-asset-create')
                  ->pause(1000)
                  ->assertSee('Depreciacion Toyota')
                  ->click('#depreciating-assets-search')
                  ->type('#depreciating-assets-name', 'Toyota Cambio Prueba')
                  ->click('#depreciating-assets-save')
                  ->waitForText('Activo actualizado exitosamente!')
                  ->assertSee('Activo actualizado exitosamente!');
      });
      Artisan::call('command:depreciate_assets');
  }
}
