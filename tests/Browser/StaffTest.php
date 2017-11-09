<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StaffTest extends DuskTestCase
{
  // TODO: Still need to test login with created user, and still need to
  // test changes on user after creating it.

  /**
   * Staff Login.
   *
   * @return void
   */
  public function testStaffLogin()
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
   * Staff Navigation.
   *
   * @return void
   */
  public function testStaffNavigation()
  {
    $this->browse(function (Browser $browser) {
        $browser->click('.sidebar-toggle')
                ->click('#menu_staff')
                ->pause(500)
                ->click('#staff')
                ->waitForText('Ver Personal')
                ->assertSee('Ver Personal');
      });
  }

  /**
   * Staff Configuration Test.
   *
   * @return void
   */
  public function testStaffConfigurationPage()
  {
    $this->browse(function (Browser $browser) {
        $browser->mouseover('#view-staff-tab')
                ->click('[data-target="#create-worker"]')
                ->waitForText('Crear Trabajador')
                ->assertSee('Crear Trabajador')
                ->click('#create-worker-create')
                ->waitForText('Informacion de trabajador requerida!')
                ->assertSee('Informacion de trabajador requerida!')
                ->type('#create-worker-name', 'Moo')
                ->type('#create-worker-id', '12345')
                ->type('#create-worker-job-title', 'Job Title')
                ->type('#create-worker-phone', '88884444')
                ->type('#create-worker-address', 'asfdashdasfjda')
                ->type('#create-worker-inss', '888asfdas')
                ->click('#create-worker-create')
                ->waitForText('Trabajador creado exitosamente!')
                ->assertSee('Trabajador creado exitosamente!')
                ->type('#staff-view-code', 'Moo')
                ->pause(500)
                ->keys('#staff-view-code', ['{arrow_down}'])
                ->keys('#staff-view-code', ['{enter}'])
                ->click('#view-staff-tab')
                ->click('.staff-name-edit')
                ->waitFor('.staff-change-name')
                ->type('.staff-change-name', 'Changed Name')
                ->keys('.staff-change-name', ['{enter}'])
                ->click('#view-staff-tab')
                ->waitForText('Cambios guardados exitosamente!')
                ->assertSee('Cambios guardados exitosamente!')
                ->click('.staff-id-edit')
                ->type('.staff-change-id', 'New ID')
                ->keys('.staff-change-id', ['{enter}'])
                ->waitForText('Cambios guardados exitosamente!')
                ->assertSee('Cambios guardados exitosamente!')
                ->click('.staff-phone-edit')
                ->type('.staff-change-phone', '99994444')
                ->keys('.staff-change-phone', ['{enter}'])
                ->waitForText('Cambios guardados exitosamente!')
                ->assertSee('Cambios guardados exitosamente!')
                ->click('.staff-job-edit')
                ->type('.staff-change-job', 'New Job')
                ->keys('.staff-change-job', ['{enter}'])
                ->click('#view-staff-tab')
                ->waitForText('Cambios guardados exitosamente!')
                ->assertSee('Cambios guardados exitosamente!')
                ->click('[data-target="#worker-user"]')
                ->waitForText('Usuario')
                ->click('#worker-user-update')
                ->waitForText('La contraseña debe tener al menos 6 caracteres!')
                ->assertSee('La contraseña debe tener al menos 6 caracteres!')
                ->type('#worker-user-password', 'secret')
                ->click('#worker-user-update')
                ->waitForText('Informacion de trabajador requerida!')
                ->assertSee('Informacion de trabajador requerida!')
                ->type('#worker-user-username', 'new_user')
                ->type('#worker-user-email', 'email@email.com')
                ->click('#worker-user-update')
                ->waitForText('Usuario creado exitosamente!')
                ->assertSee('Usuario creado exitosamente!')
                ->pause(6000)
                ->click('.user-menu')
                ->click('.user-footer > .pull-right > a');
    });
  }

  /**
   * Staff Login with created User.
   *
   * @return void
   */
  public function testStaffNewLogin()
  {
    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
                ->type('username', 'new_user')
                ->type('password', 'secret')
                ->press('#login-button')
                ->waitForLocation('/swift/system/main')
                ->assertPathIs('/swift/system/main')
                ->visit('/logout')
                ->waitForLocation('/login')
                ->type('username', 'test_user')
                ->type('password', 'secret')
                ->press('#login-button')
                ->waitForLocation('/swift/system/main')
                ->assertPathIs('/swift/system/main')
                ->click('.sidebar-toggle')
                ->click('#menu_staff')
                ->pause(500)
                ->click('#staff')
                ->waitForText('Ver Personal')
                ->assertSee('Ver Personal')
                ->type('#staff-view-code', 'Changed Name')
                ->pause(500)
                ->keys('#staff-view-code', ['{arrow_down}'])
                ->keys('#staff-view-code', ['{enter}'])
                ->click('#view-staff-tab')
                ->click('.staff-state-edit')
                ->select('.staff-change-state', 2)
                ->click('#view-staff-tab')
                ->waitForText('Cambios guardados exitosamente!')
                ->assertSee('Cambios guardados exitosamente!')
                ->assertDontSee('New Job');
    });
  }
}
