<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('start')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('worker_code', 10);
            $table->string('title', 50);
            $table->boolean('all_day')->default(false);
            $table->boolean('reminded')->default(false);
            $table->tinyInteger('type');

            $table->index('start');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendars');
    }
}
