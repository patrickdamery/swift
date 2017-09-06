<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsufficientStockEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insufficient_stock_events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('event_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('worker_code', 10);
            $table->string('branch_code', 10);
            $table->string('product_code', 10);
            $table->double('quantity');
            $table->boolean('available_alternatives')->default(false);

            $table->index('worker_code');
            $table->foreign('worker_code')->references('code')->on('workers');
            $table->foreign('branch_code')->references('code')->on('branches');
            $table->foreign('product_code')->references('code')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insufficient_stock_events');
    }
}
