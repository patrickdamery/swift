<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProduction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_production', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('production_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('production_order_code', 10);
            $table->string('product_code', 10);
            $table->tinyInteger('stage');
            $table->string('branch_code', 10);
            $table->tinyInteger('completed');
            $table->double('wages');
            $table->softDeletes();

            $table->index('production_order_code');
            $table->index('stage');
            $table->index('branch_code');
            $table->index('completed');
            $table->foreign('production_order_code')->references('code')->on('production_order');
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
        Schema::dropIfExists('product_production');
    }
}
