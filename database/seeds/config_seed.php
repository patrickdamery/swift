<?php

use Illuminate\Database\Seeder;

class config_seed extends Seeder
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

      DB::table('configuration')->insert([
          'name' => '',
          'ruc' => '',
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
          'modules' => '{}',
          'plugins' => '{}'
      ]);
    }
}
