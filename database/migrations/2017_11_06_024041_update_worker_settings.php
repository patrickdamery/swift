<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWorkerSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('worker_settings', function (Blueprint $table) {
          $table->foreign('accounting_code')->references('id')->on('worker_accounts');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('worker_settings', function (Blueprint $table) {
          $table->dropForeign(['accounting_code']);
      });
    }
}
