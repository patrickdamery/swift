<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerSavingsTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_savings_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('savings_code', 10);
            $table->timestamp('transaction_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('type');
            $table->double('before');
            $table->double('amount');
            $table->double('after');
            $table->string('journal_entry_code', 15);

            $table->index('savings_code');
            $table->index('transaction_date');
            $table->foreign('savings_code')->references('code')->on('worker_savings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worker_savings_transactions');
    }
}
