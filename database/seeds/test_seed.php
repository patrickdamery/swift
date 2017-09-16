<?php

use Illuminate\Database\Seeder;

class test_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Let's create a branch.
      $location = \App\Location::all()->last();
      $branch_location = null;
      if($location == null) {
        $branch_location = \App\Location::create(array(
          'code' => '1',
          'description' => 'provider location',
          'address' => 'provider address',
          'latitude' => '17',
          'longitude' => '54'
        ));
      } else {
        $branch_location = \App\Location::create(array(
          'code' => $location->code+1,
          'description' => 'provider location',
          'address' => 'Direccion Sucursal 1',
          'latitude' => '17',
          'longitude' => '54'
        ));
      }
      DB::table('branches')->insert([
          'code' => '1',
          'name' => 'Sucursal 1',
          'phone' => '1234-5464',
          'type' => 1,
          'location_code' => $branch_location->code
      ]);

      // Create some workers.
      $u = 1;
      for($i = 0; $i<5; $i++) {
        $worker = factory(App\Worker::class)->create([
          'code' => $i,
        ]);

        $settings = factory(App\WorkerSetting::class)->create([
          'worker_code' => $worker->code
        ]);

        $accounts = factory(App\WorkerAccount::class)->create([
          'worker_code' => $worker->code
        ]);
        // Randomly decide if we should create user for worker.
        if(rand(0, 1) == 1) {
          $user = factory(App\User::class)->create([
            'code' => $u,
            'worker_code' => $worker->code,
            'user_access_code' => 1,
          ]);
          $u++;
        }
      }

      // Now make static workers and users for unit tests.
      $worker = factory(App\Worker::class)->create([
        'code' => 6,
      ]);

      $settings = factory(App\WorkerSetting::class)->create([
        'worker_code' => $worker->code
      ]);

      $accounts = factory(App\WorkerAccount::class)->create([
        'worker_code' => $worker->code
      ]);

      $u++;
      $user = factory(App\User::class)->create([
        'code' => $u,
        'worker_code' => $worker->code,
        'user_access_code' => 1,
        'username' => 'test_user',
        'email' => 'test_user@example.com',
      ]);

      $worker = factory(App\Worker::class)->create([
        'code' => 7,
        'state' => 2,
        'deleted_at' => date('Y-m-d')
      ]);

      $settings = factory(App\WorkerSetting::class)->create([
        'worker_code' => $worker->code
      ]);

      $accounts = factory(App\WorkerAccount::class)->create([
        'worker_code' => $worker->code
      ]);

      $u++;
      $user = factory(App\User::class)->create([
        'code' => $u,
        'worker_code' => $worker->code,
        'user_access_code' => 1,
        'username' => 'fired_user',
        'email' => 'fired_user@example.com',
      ]);

      // Create a couple of providers.
      $location = \App\Location::all()->last();
      $provider_location = null;
      if($location == null) {
        $provider_location = \App\Location::create(array(
          'code' => '1',
          'description' => 'provider location',
          'address' => 'provider address',
          'latitude' => '17',
          'longitude' => '54'
        ));
      } else {
        $provider_location = \App\Location::create(array(
          'code' => $location->code+1,
          'description' => 'provider location',
          'address' => 'provider address',
          'latitude' => '17',
          'longitude' => '54'
        ));
      }
      DB::table('providers')->insert([
        'code' => '1',
        'name' => 'Proveedor 1',
        'phone' => '',
        'email' => '',
        'ruc' => '55588882221581',
        'website' => '',
        'taxes' => 1,
        'provider_type' => 1,
        'offers_credit' => 1,
        'credit_limit' => 30000,
        'credit_days' => 15,
        'ai_managed' => 0,
        'sample_range_days' => 30,
        'order_range_days' => 60,
        'location_code' => $provider_location->code,
        'delivers' => 1,
        'preferred_contact_method' => 'call',
      ]);
      DB::table('providers')->insert([
        'code' => '2',
        'name' => 'Proveedor 2',
        'phone' => '',
        'email' => '',
        'ruc' => '555888asdf21581',
        'website' => '',
        'taxes' => 1,
        'provider_type' => 1,
        'offers_credit' => 1,
        'credit_limit' => 20000,
        'credit_days' => 15,
        'ai_managed' => 0,
        'sample_range_days' => 30,
        'order_range_days' => 60,
        'location_code' => $provider_location->code,
        'delivers' => 1,
        'preferred_contact_method' => 'call',
      ]);
      DB::table('providers')->insert([
        'code' => '3',
        'name' => 'Proveedor 3',
        'phone' => '',
        'email' => '',
        'ruc' => '55588882227777',
        'website' => '',
        'taxes' => 1,
        'provider_type' => 1,
        'offers_credit' => 1,
        'credit_limit' => 18000,
        'credit_days' => 30,
        'ai_managed' => 0,
        'sample_range_days' => 30,
        'order_range_days' => 60,
        'location_code' => $provider_location->code,
        'delivers' => 1,
        'preferred_contact_method' => 'call',
      ]);

      // Now let's create a couple of products.
      $product = factory(App\Product::class, 10)->create([
        'provider_code' => '1',
      ]);

      $product = factory(App\Product::class, 8)->create([
        'provider_code' => '2',
      ]);

      $product = factory(App\Product::class, 7)->create([
        'provider_code' => '3',
      ]);

      $config = \App\Configuration::find(1);
      $config->name = 'Ferreteria Prueba';
      $config->shortname = 'Prueba';
      $modules = array(
        'crm' => 1,
        'staff' => 1,
        'factory' => 1,
        'vehicles' => 1,
        'accounting' => 1,
        'warehouses' => 1,
        'sales_stock' => 1,
      );
      $config->modules = json_encode($modules);
      $config->save();
    }
}
