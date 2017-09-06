<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_account_code', 10);
            $table->timestamp('transaction_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('worker_code', 10);
            $table->string('reason', 100);
            $table->tinyInteger('type');
            $table->double('transaction_value');
            $table->double('before');
            $table->double('after');
            $table->string('journal_entry_code', 15);

            $table->index('bank_account_code');
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
        Schema::dropIfExists('bank_accounts_transactions');
    }
}
