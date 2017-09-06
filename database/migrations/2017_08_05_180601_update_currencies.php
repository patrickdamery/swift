<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCurrencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('currencies', function (Blueprint $table) {
          $table->string('description', 20);
      });
      Schema::table('accounts', function (Blueprint $table) {
        $table->string('currency_code', 10);
        $table->foreign('currency_code')->references('code')->on('currencies');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('currencies', function (Blueprint $table) {
          $table->dropColumn('description');
      });
      Schema::table('accounts', function (Blueprint $table) {
          $table->dropForeign(['currency_code']);
      });
    }
}
