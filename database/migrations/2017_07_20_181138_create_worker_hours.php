<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerHours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 15)->unique();
            $table->timestamp('recorded_at');
            $table->string('worker_code', 10);
            $table->tinyInteger('type');
            $table->boolean('processed')->default(false);

            $table->index('worker_code');
            $table->index('type');
            $table->index('recorded_at');
            $table->foreign('worker_code')->references('code')->on('workers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worker_hours');
    }
}
