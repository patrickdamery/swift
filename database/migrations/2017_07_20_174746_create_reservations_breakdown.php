<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reservation_code', 10);
            $table->string('product_code', 10);
            $table->double('quantity');
            $table->double('price');
            $table->string('discount_code', 10);

            $table->index('reservation_code');
            $table->index('product_code');
            $table->foreign('reservation_code')->references('code')->on('reservations');
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
        Schema::dropIfExists('reservations_breakdown');
    }
}
