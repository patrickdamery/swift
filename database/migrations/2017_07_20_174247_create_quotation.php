<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('code', 10)->unique();
            $table->string('worker_code', 10);
            $table->double('subtotal');
            $table->double('tax');
            $table->string('discount_code', 10);
            $table->double('total');
            $table->string('client_code');
            $table->tinyInteger('state');
            $table->integer('day_limit');
            $table->softDeletes();

            $table->index('worker_code');
            $table->index('created');
            $table->index('client_code');
            $table->foreign('client_code')->references('code')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');
    }
}
