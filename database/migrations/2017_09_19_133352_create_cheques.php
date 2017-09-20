<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('cheques', function (Blueprint $table) {
          $table->increments('id');
          $table->string('code', 10)->unique();
          $table->string('cheque_book_code', 10);
          $table->string('cheque_number', 10)->index();
          $table->string('journal_entry_code', 15);

          $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cheques');
    }
}
