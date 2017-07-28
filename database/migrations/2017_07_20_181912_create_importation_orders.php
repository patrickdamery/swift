<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportationOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importation_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->timestamp('order_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('provider_code', 10);
            $table->tinyInteger('state');
            $table->timestamp('expected_arrival_date')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->index('provider_code');
            $table->index('order_date');
            $table->index('state');
            $table->foreign('provider_code')->references('code')->on('providers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('importation_orders');
    }
}
