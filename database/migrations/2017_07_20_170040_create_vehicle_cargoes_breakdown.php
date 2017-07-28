<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleCargoesBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_cargo_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vehicle_cargo_code', 15);
            $table->string('product_code', 15);
            $table->double('quantity');

            $table->index('vehicle_cargo_code');
            $table->foreign('vehicle_cargo_code')->references('code')->on('vehicle_cargoes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_cargo_breakdown');
    }
}
