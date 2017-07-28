<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contract_code', 10);
            $table->string('product_code', 10);
            $table->double('quantity');
            $table->double('price');

            $table->index('contract_code');
            $table->foreign('contract_code')->references('code')->on('contracts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts_breakdown');
    }
}
