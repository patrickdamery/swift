<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocktakeBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocktakes_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stocktake_code', 10);
            $table->string('product_code', 10);
            $table->double('system_quantity');
            $table->double('counted');
            $table->double('difference');
            $table->tinyInteger('state');
            $table->json('extra_data');

            $table->index('stocktake_code');
            $table->foreign('stocktake_code')->references('code')->on('stocktakes');
            $table->foreign('product_code')->references('code')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocktakes_breakdown');
    }
}
