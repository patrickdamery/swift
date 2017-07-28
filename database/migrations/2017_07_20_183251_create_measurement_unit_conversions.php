<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasurementUnitConversions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurement_unit_conversions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('measurement_unit_code', 10);
            $table->string('convert_to_code', 10);
            $table->double('factor');

            $table->index('measurement_unit_code');
            $table->foreign('measurement_unit_code')->references('code')->on('measurement_units');
            $table->foreign('convert_to_code')->references('code')->on('measurement_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('measurement_unit_conversions');
    }
}
