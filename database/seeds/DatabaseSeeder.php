<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(init_seed::class);
        $this->call(test_seed::class);
        //$this->call(journal_seed::class);
    }
}
