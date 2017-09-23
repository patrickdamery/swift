<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckBook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('cheque_book', function (Blueprint $table) {
          $table->increments('id');
          $table->string('code', 10)->unique();
          $table->string('bank_account_code', 10)->index();
          $table->string('name', 25);
          $table->string('current_number', 10);

          $table->foreign('bank_account_code')->references('code')->on('bank_accounts');
      });

      Schema::table('cheques', function (Blueprint $table) {
        $table->foreign('cheque_book_code')->references('code')->on('cheque_book');

      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('cheques', function (Blueprint $table) {
          $table->dropForeign(['cheque_book_code']);
      });
      Schema::dropIfExists('cheque_book');
    }
}
