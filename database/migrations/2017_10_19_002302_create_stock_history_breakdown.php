<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockHistoryBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('stock_history_breakdown', function (Blueprint $table) {
         $table->increments('id');
         $table->string('stock_history_code', 10);
         $table->string('product_code', 20);
         $table->string('branch_code', 10);
         $table->double('amount');

         $table->foreign('stock_history_code')->references('code')->on('stock_history');
         $table->foreign('product_code')->references('code')->on('products');
         $table->foreign('branch_code')->references('code')->on('branches');
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
       Schema::dropIfExists('stock_history_breakdown');
     }
}
