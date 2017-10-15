<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountingAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('accounting_accounts', function (Blueprint $table) {
          $table->increments('id');
          $table->string('retained_VAT_account', 20);
          $table->string('advanced_VAT_account', 20);
          $table->double('VAT_percentage');
          $table->double('fixed_fee');
          $table->string('ISC_account', 20);
          $table->string('advanced_IT_account', 20);
          $table->string('retained_IT_account', 20);
          $table->double('IT_percentage');
          $table->json('IT_rules');
          $table->string('entity_type', 12);

          $table->foreign('retained_VAT_account')->references('code')->on('accounts');
          $table->foreign('advanced_VAT_account')->references('code')->on('accounts');
          $table->foreign('ISC_account')->references('code')->on('accounts');
          $table->foreign('advanced_IT_account')->references('code')->on('accounts');
          $table->foreign('retained_IT_account')->references('code')->on('accounts');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_accounts');
    }
}
