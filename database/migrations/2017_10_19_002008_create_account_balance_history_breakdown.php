<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountBalanceHistoryBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('account_history_breakdown', function (Blueprint $table) {
         $table->increments('id');
         $table->string('account_history_code', 10);
         $table->string('account_code', 20);
         $table->double('balance');

         $table->foreign('account_history_code')->references('code')->on('account_history');
         $table->foreign('account_code')->references('code')->on('accounts');
       });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
       Schema::dropIfExists('account_history_breakdown');
     }
}
