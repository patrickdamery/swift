<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerSavings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_savings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('worker_code', 10);
            $table->string('currency_code', 10);
            $table->double('amount_saved')->default(0);
            $table->string('account_code');

            $table->index('worker_code');
            $table->foreign('worker_code')->references('code')->on('workers');
            $table->foreign('currency_code')->references('code')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worker_savings');
    }
}
