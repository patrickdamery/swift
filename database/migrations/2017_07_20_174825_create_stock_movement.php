<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockMovement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created');
            $table->string('product_code', 10);
            $table->double('quantity_before_movement');
            $table->double('quantity_to_move');
            $table->double('quantity_after_movement');
            $table->tinyInteger('type');
            $table->string('reference_code', 10);
            $table->double('taxes');
            $table->double('total');
            $table->text('reason');
            $table->string('journal_entry_code', 15);
            $table->softDeletes();

            $table->index('product_code');
            $table->index('type');
            $table->index('reference_code');
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
        Schema::dropIfExists('stock_movements');
    }
}
