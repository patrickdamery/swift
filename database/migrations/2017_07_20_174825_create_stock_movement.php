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
            $table->timestamp('created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('product_code', 10);
            $table->double('amount');
            $table->tinyInteger('type');
            $table->string('reference_code', 10);
            $table->text('reason');
            $table->string('journal_entry_code', 15);
            $table->string('branch_identifier', 3);
            $table->softDeletes();

            $table->index('product_code');
            $table->index('type');
            $table->index('branch_identifier');
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
