<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('discount_code', 10);
            $table->string('product_code', 10);
            $table->json('rules');
            $table->tinyInteger('discount_type');
            $table->double('discount');

            $table->index('discount_code');
            $table->index('product_code');
            $table->foreign('discount_code')->references('code')->on('discounts');
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
        Schema::dropIfExists('discount_rules');
    }
}
