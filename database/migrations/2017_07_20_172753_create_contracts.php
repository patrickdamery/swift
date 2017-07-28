<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('client_code', 10);
            $table->timestamp('created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('quota_interval', 20);
            $table->double('quota');
            $table->timestamp('start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->json('payment_dates');
            $table->tinyInteger('interest');
            $table->double('debt');
            $table->tinyInteger('state');
            $table->string('branch_code', 10);
            $table->string('account_code', 10);

            $table->index('client_code');
            $table->foreign('client_code')->references('code')->on('clients');
            $table->foreign('branch_code')->references('code')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
