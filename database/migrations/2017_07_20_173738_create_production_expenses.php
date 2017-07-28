<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_code', 10);
            $table->tinyInteger('stage');
            $table->json('materials');
            $table->double('bonus');
            $table->softDeletes();

            $table->index('product_code');
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
        Schema::dropIfExists('production_expenses');
    }
}
