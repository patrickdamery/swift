<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('product_code', 20);
            $table->string('branch_code', 10);
            $table->string('warehouse_code', 10);
            $table->string('warehouse_location_code', 10);
            $table->double('quantity');

            $table->index('product_code');
            $table->index('branch_code');
            $table->index('warehouse_code');
            $table->index('warehouse_location_code');
            $table->foreign('product_code')->references('code')->on('products');
            $table->foreign('branch_code')->references('code')->on('branches');
            $table->foreign('warehouse_code')->references('code')->on('warehouses');
            $table->foreign('warehouse_location_code')->references('code')->on('warehouse_locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock');
    }
}
