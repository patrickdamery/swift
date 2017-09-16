<?php
namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{

    /**
     * Login with bad username-password combination.
     *
     * @return void
     */
    public function testBadLogin()
    {
      $this->browse(function (Browser $browser) {
        $browser->visit('/login')
                ->type('username', 'woopsie')
                ->type('password', 'secret')
                ->press('#login-button')
                ->waitForLocation('/login')
                ->assertSee('Combinacion de Usuario y Contraseña incorrectos!');
      });
    }

    /**
     * Login with good username-password combination of fired user.
     *
     * @return void
     */
    public function testFiredLogin()
    {
      $this->browse(function (Browser $browser) {
        $browser->visit('/login')
                ->type('username', 'fired_user')
                ->type('password', 'secret')
                ->press('#login-button')
                ->waitForLocation('/login')
                ->assertSee('Combinacion de Usuario y Contraseña incorrectos!');
      });
    }

    /**
     * Login with good username-password combination.
     *
     * @return void
     */
    public function testGoodLogin()
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
}
