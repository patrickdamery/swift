<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_loans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('worker_code', 10);
            $table->timestamp('loan_date');
            $table->double('amount');
            $table->string('payment_code', 10);
            $table->string('journal_entry_code', 15);
            $table->softDeletes();

            $table->index('worker_code');
            $table->index('loan_date');
            $table->index('payment_code');
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
        Schema::dropIfExists('worker_loans');
    }
}
