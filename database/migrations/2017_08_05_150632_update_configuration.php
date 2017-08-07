<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('configuration', function (Blueprint $table) {
          $table->json('modules');
          $table->json('plugins');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('configuration', function (Blueprint $table) {
          $table->dropColumn('modules');
          $table->dropColumn('plugins');
      });
    }
}
