<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviderBills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->timestamp('bill_date');
            $table->string('bill_number', 10);
            $table->tinyInteger('bill_type');
            $table->double('subtotal');
            $table->double('discount');
            $table->double('taxes');
            $table->double('total');
            $table->tinyInteger('state');
            $table->string('provider_code', 10);
            $table->string('branch_code', 10);
            $table->softDeletes();

            $table->index('bill_date');
            $table->index('bill_number');
            $table->index('bill_type');
            $table->index('provider_code');
            $table->foreign('provider_code')->references('code')->on('providers');
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
        Schema::dropIfExists('provider_bills');
    }
}
