<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('warehouse_code', 10);
            $table->string('stand', 4);
            $table->string('row', 4);
            $table->smallInteger('cell');
            $table->double('used_space');
            $table->double('free_space');
            $table->double('total_space');

            $table->index('warehouse_code');
            $table->foreign('warehouse_code')->references('code')->on('warehouses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_locations');
    }
}
