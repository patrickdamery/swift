<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleCargoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_cargoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('journey_code', 15);
            $table->timestamp('loaded')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('unloaded')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('source_branch_code', 10);
            $table->tinyInteger('type');
            $table->string('type_code', 15);
            $table->tinyInteger('state');

            $table->foreign('source_branch_code')->references('code')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_cargoes');
    }
}
