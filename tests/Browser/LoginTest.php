<?php
namespace Tests\Browser;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
class LoginTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
      $this->browse(function (Browser $browser) {
        $browser->visit('http://swift.sys/login')
                ->type('username', 'thiel.winifred')
                ->type('password', 'secret')
                ->press('#qwerty');
                //-assertRouteIs('http://swift.sys/swift/system/main');

      });
    }
}
