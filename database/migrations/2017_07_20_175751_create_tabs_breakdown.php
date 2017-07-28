<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabsBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabs_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tab_code', 10);
            $table->string('product_code', 10);
            $table->string('discount_code', 10);
            $table->double('quantity');

            $table->index('tab_code');
            $table->foreign('tab_code')->references('code')->on('tabs');
            $table->foreign('discount_code')->references('code')->on('discount_requests');
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
        Schema::dropIfExists('tabs_breakdown');
    }
}
