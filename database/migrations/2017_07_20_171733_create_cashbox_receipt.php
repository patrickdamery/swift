<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashboxReceipt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbox_receipt', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('cashbox_transaction_code', 15);
            $table->string('client_code', 10);
            $table->timestamp('receipt_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->double('amount');
            $table->text('reason');
            $table->string('journal_entry_code', 15);

            $table->foreign('cashbox_transaction_code')->references('code')->on('cashbox_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashbox_receipt');
    }
}
