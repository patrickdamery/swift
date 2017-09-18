<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->unique();
            $table->string('provider_code', 10);
            $table->string('description', 50);
            $table->string('category_code', 8);
            $table->string('currency_code', 10);
            $table->string('onload_function', 10);
            $table->string('onsale_function', 10);
            $table->string('measurement_unit_code', 10);
            $table->double('cost');
            $table->double('avg_cost');
            $table->double('price');
            $table->boolean('sellable')->default(true);
            $table->boolean('sell_at_base_price')->default(false);
            $table->double('base_price');
            $table->json('alternatives');
            $table->double('volume')->default(0);
            $table->double('weight')->default(0);
            $table->string('package_code', 20);
            $table->string('package_measurement_unit_code', 10);
            $table->tinyInteger('order_by');
            $table->boolean('service')->default(false);
            $table->json('materials');
            $table->double('points_cost');
            $table->string('sales_account', 10);
            $table->string('returns_account', 10);
            $table->softDeletes();

            $table->index('provider_code');
            $table->index('package_code');
            $table->index('service');
            $table->index('sell_at_base_price');
            $table->index('sellable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
