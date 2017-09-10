<?php

use Illuminate\Database\Seeder;

class init_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('currencies')->insert([
          'code' => 'cord',
          'exchange_rate' => 1,
          'buy_rate' => 1,
          'description' => 'Cordoba'
      ]);

      DB::table('measurement_units')->insert([
          'code' => '0',
          'name' => 'No Asignado'
      ]);

      DB::table('category')->insert([
          'code' => '0',
          'description' => 'No Asignado',
          'parent_code' => '0'
      ]);

      DB::table('accounts')->insert([
          'code' => '0',
          'type' => 'NA',
          'name' => 'No Asignado',
          'parent_account' => '0',
          'has_children' => 0,
          'amount' => 0,
          'currency_code' => 'cord',
          'deleted_at' => null
      ]);

      DB::table('vehicles')->insert([
          'code' => '0',
          'make' => 'No Asignado',
          'model' => 'No Asignado',
          'efficiency' => 0,
          'under_repairs' => 0,
          'type' => 0,
          'initial_value' => 0,
          'current_value' => 0,
          'currency_code' => 'cord',
          'number_plate' => '',
          'latitude' => 0,
          'longitude' => 0,
          'asset_account' => 0,
          'depreciation_account' => 0,
      ]);

      $modules = array(
        'crm' => 0,
        'staff' => 0,
        'factory' => 0,
        'vehicles' => 0,
        'accounting' => 0,
        'warehouses' => 0,
        'sales_stock' => 0,
      );
      DB::table('configuration')->insert([
          'name' => '',
          'shortname' => '',
          'ruc' => '',
          'dgi_auth' => '',
          'local_currency_code' => 'cord',
          'quote_life' => 15,
          'reservation_life' => 15,
          'charge_tip' => 0,
          'points_enabled' => 0,
          'hourly_payment' => 1,
          'points_percentage' => 0,
          'current_version' => 0.8,
          'latest_version' => 0.8,
          'auth_key' => '',
          'key_change_counter' => 0,
          'base_url' => '',
          'modules' => json_encode($modules),
          'plugins' => '{}'
      ]);

      DB::table('user_level')->insert([
            'code' => '1',
            'name' => 'Admin',
            'permissions' => '{}',
            'view' => '{}'
      ]);

      DB::table('groups')->insert([
            'code' => '0',
            'name' => 'No Asignado',
            'type' => 0,
            'members' => '{}'
      ]);

      DB::table('locations')->insert([
        'code' => '0',
        'description' => 'No Asignado',
        'address' => 'No Asignado',
        'latitude' => 0,
        'longitude' => 0
      ]);

      DB::table('providers')->insert([
            'code' => '0',
            'name' => 'No Asignado',
            'phone' => '',
            'email' => '',
            'ruc' => '',
            'website' => '',
            'taxes' => 0,
            'provider_type' => 2,
            'offers_credit' => 0,
            'credit_limit' => 0,
            'credit_days' => 0,
            'ai_managed' => 0,
            'sample_range_days' => 0,
            'order_range_days' => 0,
            'location_code' => '0',
            'delivers' => 0,
            'preferred_contact_method' => '',
      ]);
    }
}
