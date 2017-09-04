<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {



        $this->browse(function (Browser $browser)
        {
            $browser->visit('http://swift.sys/login')
                    ->assertSee('Ferreteria Prueba');
        });


/*
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });





        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('user', 'somarribasaul@gmail.com')
                    ->type('password', 'secret')
                    ->press('Login')
                    ->assertPathIs('/home');
        });

        */
    }
}
