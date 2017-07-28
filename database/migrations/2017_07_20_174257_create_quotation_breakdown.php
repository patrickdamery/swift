<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quotation_code', 10);
            $table->string('product_code', 10);
            $table->double('quantity');
            $table->double('price');
            $table->string('discount_code', 10);

            $table->index('quotation_code');
            $table->index('product_code');
            $table->foreign('quotation_code')->references('code')->on('quotations');
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
        Schema::dropIfExists('quotations_breakdown');
    }
}
