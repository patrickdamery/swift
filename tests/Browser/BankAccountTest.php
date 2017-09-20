<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BankAccountTest extends DuskTestCase
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
                  ->assertPathIs('/swift/system/main')
                  ->click('.sidebar-toggle')
                  ->click('#menu_accounting')
                  ->pause(500)
                  ->click('#bank_accounts')
                  ->waitForText('POS')
                  ->assertSee('POS')
                  ->click('[data-target="#create-bank-account"]')
                  ->waitForText('Crear Cuenta de Banco')
                  ->assertSee('Crear Cuenta de Banco')
                  ->click('#create-bank-account-create')
                  ->waitForText('Nombre de Banco no puede dejarse en blanco!')
                  ->assertSee('Nombre de Banco no puede dejarse en blanco!')
                  ->type('#create-bank-account-name', 'BAC')
                  ->click('#create-bank-account-create')
                  ->waitForText('Numero de Cuenta de Banco no puede dejarse en blanco y debe ser un valor numerico!')
                  ->assertSee('Numero de Cuenta de Banco no puede dejarse en blanco y debe ser un valor numerico!')
                  ->type('#create-bank-account-number', '123456789')
                  ->click('#create-bank-account-create')
                  ->waitForText('Cuenta Contable no puede dejarse en blanco!')
                  ->assertSee('Cuenta Contable no puede dejarse en blanco!')
                  ->type('#create-bank-account-account', '102.1')
                  ->click('#create-bank-account-create')
                  ->waitForText('La cuenta de banco ha sido creada exitosamente!')
                  ->assertSee('La cuenta de banco ha sido creada exitosamente!')
                  ->click('[data-target="#create-bank-account"]')
                  ->waitForText('Crear Cuenta de Banco')
                  ->assertSee('Crear Cuenta de Banco')
                  ->click('#create-bank-account-create')
                  ->type('#create-bank-account-name', 'BDF')
                  ->type('#create-bank-account-number', '987654321')
                  ->type('#create-bank-account-account', '102.2')
                  ->click('#create-bank-account-create')
                  ->waitForText('La cuenta de banco ha sido creada exitosamente!')
                  ->assertSee('La cuenta de banco ha sido creada exitosamente!')
                  ->click('[data-target="#create-bank-account"]')
                  ->waitForText('Crear Cuenta de Banco')
                  ->assertSee('Crear Cuenta de Banco')
                  ->type('#create-bank-account-name', 'BDF')
                  ->type('#create-bank-account-number', '987654321')
                  ->type('#create-bank-account-account', '102.2')
                  ->click('#create-bank-account-create')
                  ->waitForText('Una cuenta de banco con el codigo definido ya existe!')
                  ->assertSee('Una cuenta de banco con el codigo definido ya existe!');
      });
  }
}
