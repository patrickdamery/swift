<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('worker_code', 10);
            $table->double('hourly_rate');
            $table->string('vehicle_code', 10);
            $table->string('schedule_code', 10);
            $table->string('notification_group', 10);
            $table->boolean('self_print')->default(true);
            $table->string('print_group', 10);
            $table->string('commission_group', 10);
            $table->string('discount_group', 10);
            $table->string('branches_group', 10);
            $table->string('pos_group', 10);

            $table->index('worker_code');
            $table->foreign('worker_code')->references('code')->on('workers');
            $table->foreign('vehicle_code')->references('code')->on('vehicles');
            $table->foreign('notification_group')->references('code')->on('groups');
            $table->foreign('print_group')->references('code')->on('groups');
            $table->foreign('commission_group')->references('code')->on('groups');
            $table->foreign('discount_group')->references('code')->on('groups');
            $table->foreign('branches_group')->references('code')->on('groups');
            $table->foreign('pos_group')->references('code')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worker_settings');
    }
}
