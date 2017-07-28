<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AiOrderBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_orders_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ai_order_code', 10);
            $table->string('product_code', 10);
            $table->double('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ai_orders_breakdown');
    }
}
