<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('provider_accounts', function (Blueprint $table) {
          $table->increments('id');
          $table->string('code', 10)->unique();
          $table->string('provider_code', 10);
          $table->string('owed_account', 10);
          $table->string('service_account', 10);
          $table->string('stock_account', 10);
          $table->string('intransit_account', 10);
          $table->string('debt_account', 10);

          $table->foreign('provider_code')->references('code')->on('providers');
          $table->foreign('owed_account')->references('code')->on('accounts');
          $table->foreign('service_account')->references('code')->on('accounts');
          $table->foreign('stock_account')->references('code')->on('accounts');
          $table->foreign('intransit_account')->references('code')->on('accounts');
          $table->foreign('debt_account')->references('code')->on('accounts');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_accounts');
    }
}
