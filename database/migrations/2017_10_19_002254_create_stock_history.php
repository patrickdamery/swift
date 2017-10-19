<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('stock_history', function (Blueprint $table) {
         $table->increments('id');
         $table->string('month', 3);
         $table->string('year', 3);
         $table->string('code', 10);

         $table->unique(['month', 'year']);
         $table->index('code');
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
       Schema::dropIfExists('stock_history');
     }
}
