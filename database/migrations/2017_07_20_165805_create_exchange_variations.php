<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeVariations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_exchange_variations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('exchange_date');
            $table->string('currency_code', 10);
            $table->double('exchange_rate');
            $table->double('buy_rate');
            $table->string('local_currency_code', 10);

            $table->index('exchange_date');
            $table->index('currency_code');
            $table->foreign('currency_code')->references('code')->on('currencies');
            $table->foreign('local_currency_code')->references('code')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_exchange_variations');
    }
}
