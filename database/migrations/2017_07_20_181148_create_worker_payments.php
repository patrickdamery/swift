<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->timestamp('payment_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('worker_code', 10);
            $table->json('payment_data');
            $table->double('total_paid');
            $table->string('journal_entry_code', 15);
            $table->string('branch_identifier', 3);

            $table->index('worker_code');
            $table->index('payment_date');
            $table->foreign('worker_code')->references('code')->on('workers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worker_payments');
    }
}
