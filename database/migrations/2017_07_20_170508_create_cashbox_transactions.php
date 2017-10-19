<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashboxTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbox_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cashbox_code', 10);
            $table->string('code', 15)->unique();
            $table->timestamp('transaction_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('type');
            $table->double('amount');
            $table->text('reason');
            $table->string('journal_entry_code', 15);
            $table->string('branch_identifier', 3);

            $table->index('cashbox_code');
            $table->foreign('cashbox_code')->references('code')->on('cashboxes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashbox_transactions');
    }
}
