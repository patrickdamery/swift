<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderBillsPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_bills_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('payment_date');
            $table->string('provider_bill_code', 10);
            $table->string('transaction_code', 10);
            $table->tinyInteger('transaction_type');
            $table->double('payment');
            $table->double('debt');
            $table->string('journal_entry_code', 15);
            $table->softDeletes();

            $table->index('provider_bill_code');
            $table->foreign('provider_bill_code')->references('code')->on('provider_bills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_bills_payments');
    }
}
