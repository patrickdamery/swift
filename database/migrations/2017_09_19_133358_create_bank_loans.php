<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('bank_loans', function (Blueprint $table) {
        $table->increments('id');
        $table->string('code', 10)->unique();
        $table->string('bank_account_code', 10)->index();
        $table->string('account_code', 10)->index();
        $table->timestamp('start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->double('payment_rate');
        $table->double('interest_rate');
        $table->string('interval', 10);
        $table->timestamp('next_payment')->default(DB::raw('CURRENT_TIMESTAMP'))->index();
        $table->tinyInteger('state')->index();
        $table->string('journal_entry_code', 15);
        $table->string('branch_identifier', 3);

        $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
        $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
        $table->foreign('account_code')->references('code')->on('accounts');
        $table->foreign('bank_account_code')->references('code')->on('bank_accounts');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
         Schema::dropIfExists('bank_loans');
     }
}
