<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtilityBills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utility_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('utility_code', 10);
            $table->timestamp('utility_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('bill_number', 15);
            $table->double('subtotal');
            $table->double('discount');
            $table->double('taxes');
            $table->double('total');
            $table->string('journal_entry_code', 15);
            $table->string('branch_identifier', 3);
            $table->softDeletes();

            $table->index('utility_code');
            $table->index('utility_date');
            $table->foreign('utility_code')->references('code')->on('utilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utility_bills');
    }
}
