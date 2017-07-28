<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportationOrdersExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importation_orders_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('importation_order_code', 10);
            $table->string('code', 10)->unique();
            $table->tinyInteger('type');
            $table->string('expense_code');

            $table->index('importation_order_code');
            $table->index('type');
            $table->index('expense_code');
            $table->foreign('importation_order_code')->references('code')->on('importation_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('importation_orders_expenses');
    }
}
