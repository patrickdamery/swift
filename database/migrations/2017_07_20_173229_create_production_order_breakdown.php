<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionOrderBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_order_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('production_order_code', 10);
            $table->string('product_code', 10);
            $table->double('quantity');

            $table->index('production_order_code');
            $table->foreign('production_order_code')->references('code')->on('production_order');
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
        Schema::dropIfExists('production_order_breakdown');
    }
}
