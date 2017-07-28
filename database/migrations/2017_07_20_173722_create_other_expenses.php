<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type');
            $table->string('transaction_code', 10);
            $table->text('reason');
            $table->double('value');
            $table->string('journal_entry_code', 15);
            $table->softDeletes();

            $table->index('type');
            $table->index('transaction_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('other_expenses');
    }
}
