<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sales_code', 10);
            $table->string('product_code', 10);
            $table->string('discount_code', 10);
            $table->double('quantity');
            $table->double('cost');
            $table->double('price');
            $table->json('extra_data');

            $table->index('sales_code');
            $table->index('product_code');
            $table->foreign('sales_code')->references('code')->on('sales');
            $table->foreign('product_code')->references('code')->on('products');
            $table->foreign('discount_code')->references('code')->on('discount_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_breakdown');
    }
}
