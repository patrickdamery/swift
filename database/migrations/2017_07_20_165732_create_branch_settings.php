<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('branch_code', 10);
            $table->time('opening_time');
            $table->time('closing_time');
            $table->string('vehicle_group_code', 10);
            $table->string('worker_group_code', 10);

            $table->index('branch_code');
            $table->foreign('branch_code')->references('code')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch_settings');
    }
}
