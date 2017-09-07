<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionStages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_stages', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('started')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('production_order_code', 10);
            $table->tinyInteger('stage');
            $table->string('worker_code', 10);
            $table->json('materials');
            $table->json('wages');
            $table->softDeletes();

            $table->index('production_order_code');
            $table->foreign('production_order_code')->references('code')->on('production_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_stages');
    }
}
