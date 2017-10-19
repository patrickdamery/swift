<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('client_accounts', function (Blueprint $table) {
          $table->increments('id');
          $table->string('code', 10)->unique();
          $table->string('client_code', 20);
          $table->string('owed_account', 20);
          $table->string('debt_account', 20);

          $table->foreign('client_code')->references('code')->on('clients');
          $table->foreign('owed_account')->references('code')->on('accounts');
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
        Schema::dropIfExists('client_accounts');
    }
}
