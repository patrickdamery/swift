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
          $table->string('retained_VAT_account', 10);
          $table->string('advanced_VAT_account', 10);
          $table->string('ISC_account', 10);
          $table->string('advanced_IR_account', 10);
          $table->string('retained_IR_account', 10);
          $table->string('retained_mayorship_account', 10);
          $table->string('retained_card_IR_account', 10);
          $table->string('retained_card_VAT_account', 10);

          $table->foreign('retained_VAT_account')->references('code')->on('accounts');
          $table->foreign('advanced_VAT_account')->references('code')->on('accounts');
          $table->foreign('ISC_account')->references('code')->on('accounts');
          $table->foreign('advanced_IR_account')->references('code')->on('accounts');
          $table->foreign('retained_IR_account')->references('code')->on('accounts');
          $table->foreign('retained_mayorship_account')->references('code')->on('accounts');
          $table->foreign('retained_card_IR_account')->references('code')->on('accounts');
          $table->foreign('retained_card_VAT_account')->references('code')->on('accounts');
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
