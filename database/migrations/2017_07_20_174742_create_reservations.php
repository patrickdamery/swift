<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created');
            $table->string('code', 10)->unique();
            $table->string('worker_code', 10);
            $table->string('client_code', 10);
            $table->double('subtotal');
            $table->string('discount_code', 10);
            $table->double('taxes');
            $table->double('total');
            $table->tinyInteger('transaction_type');   
            $table->string('transaction_code', 10);
            $table->tinyInteger('state');
            $table->double('deposit');
            $table->string('journal_entry_code', 15);
            $table->softDeletes();

            $table->index('worker_code');
            $table->index('client_code');
            $table->foreign('client_code')->references('code')->on('clients');
            $table->foreign('discount_code')->references('code')->on('discount_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
