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
                  ->press('#qwerty')
                  ->visit('http://swift.sys/swift/system/main');
                  //->assertPathIs('http://swift.sys/swift/system/main');
        });
      }
        /*

        $$this->browse(function (Browser $browser) {
          $browser->loginAs(User::find(1))
                  ->visit('http://swift.sys/swift/system/main');
        });

        */


/*

      public function testCreateAccount()
      {
          $this->browse(function (Browser $browser) {

                      $browser

                              //->whenAvailable('#modal-support', function ($modal) use($user) {
                                //  $modal->assertInputValue('#support-from', $user->email);
                              //});
                  });
        }

    }*/
}
