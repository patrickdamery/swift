<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerLongTermLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_long_term_loans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('worker_code', 10);
            $table->timestamp('start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('next_payment')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('interval');
            $table->double('quota');
            $table->double('debt');
            $table->boolean('paid')->default(false);

            $table->index('worker_code');
            $table->index('next_payment');
            $table->index('paid');
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
        Schema::dropIfExists('worker_long_term_loans');
    }
}
