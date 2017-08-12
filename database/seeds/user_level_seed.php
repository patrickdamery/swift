<?php

use Illuminate\Database\Seeder;

class user_level_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      /*
      DB::table('user_level')->insert([
            'code' => '1',
            'name' => 'Admin',
            'permissions' => '{}',
            'view' => '{}'
      ]);

      DB::table('accounts')->insert([
            'code' => '0',
            'type' => 'NA',
            'name' => 'No Asignado',
            'parent_account' => '0',
            'has_children' => 0,
            'amount' => 0
      ]);

*/
      DB::table('groups')->insert([
            'code' => '0',
            'name' => 'No Asignado',
            'type' => 0,
            'members' => '{}'
      ]);
    }
}
