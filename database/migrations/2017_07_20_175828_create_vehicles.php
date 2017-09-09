<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('make', 20);
            $table->string('model', 20);
            $table->double('efficiency');
            $table->boolean('under_repairs');
            $table->tinyInteger('type');
            $table->double('initial_value');
            $table->double('current_value');
            $table->string('currency_code', 6);
            $table->string('number_plate', 10);
            $table->double('latitude');
            $table->double('longitude');
            $table->string('asset_account', 10);
            $table->string('depreciation_account', 10);

            $table->index('under_repairs');
            $table->index('type');
            $table->foreign('currency_code')->references('code')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
