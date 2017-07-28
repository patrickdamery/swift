<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportationOrdersBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importation_orders_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('importation_order_code', 10);
            $table->string('product_code', 10);
            $table->double('quantity');
            $table->double('estimated_cost');
            $table->double('real_cost');

            $table->index('importation_order_code');
            $table->index('product_code');
            $table->foreign('importation_order_code')->references('code')->on('importation_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('importation_orders_breakdown');
    }
}
