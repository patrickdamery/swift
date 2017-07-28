<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderBillsBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_bills_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provider_bill_code', 10);
            $table->string('product_code', 10);
            $table->double('quantity');
            $table->double('old_real_cost');
            $table->double('old_average_cost');
            $table->double('current_real_cost');
            $table->double('discount');
            $table->double('current_discount_cost');

            $table->index('provider_bill_code');
            $table->index('product_code');
            $table->foreign('provider_bill_code')->references('code')->on('provider_bills');
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
        Schema::dropIfExists('provider_bills_breakdown');
    }
}
