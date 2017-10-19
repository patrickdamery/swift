<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJourneys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journeys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->date('journey_date');
            $table->time('journey_time');
            $table->string('vehicle_code', 10);
            $table->string('driver_code', 10);
            $table->double('start_latitude');
            $table->double('start_longitude');
            $table->json('path_taken');
            $table->double('end_latitude');
            $table->double('end_longitude');
            $table->double('distance_travelled');
            $table->text('end_address');
            $table->tinyInteger('journey_type');
            $table->tinyInteger('journey_reason_type');
            $table->string('journey_reason_code', 10);
            $table->tinyInteger('state');
            $table->double('depreciation');
            $table->string('journal_entry_code', 15);
            $table->string('branch_identifier', 3);
            $table->softDeletes();

            $table->index('vehicle_code');
            $table->index('driver_code');
            $table->index('journey_date');
            $table->index('journey_type');
            $table->index('journey_reason_type');
            $table->index('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journeys');
    }
}
