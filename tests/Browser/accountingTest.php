<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class accountingTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogin()
    {

        $this->browse(function (Browser $browser) {
          $browser->visit('http://swift.sys/login')
                  ->assertSee('Ferreteria Prueba')
                  ->type('username', 'thiel.winifred')
                  ->type('password', 'secret')
                  ->press('#login_button');

                  //->assertPathIs('http://swift.sys/swift/system/main');
        });
      }
/*

        $this->browse(function (Browser $browser) {
          $browser->loginAs(User::find(1))
                  ->visit('http://swift.sys/swift/system/main');
        });

        */



      public function testCreateAccount()
      {
          $this->browse(function (Browser $browser) {

              $browser->visit('http://swift.sys/swift/system/main')
                      ->assertVisible('#menu_accounting');
                      /*->visit(
                       $browser->attribute('#menu_accounting', 'href')
                     )*/
                      //->click('a[href="accounts"]');
                      //->clickLink('#menu_accounting')
                      //->clickLink('#accounts');
              $browser->attribute('#menu_accounting', 'href');
              $browser->attribute('#accounts', 'href')
                      ->press('#create_account');
            });
        }


}
