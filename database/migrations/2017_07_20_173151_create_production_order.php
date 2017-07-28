<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('client_code', 10);
            $table->timestamp('created');
            $table->boolean('completed')->default(false);
            $table->tinyInteger('type');
            $table->tinyInteger('priority');
            $table->softDeletes();

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
        Schema::dropIfExists('production_order');
    }
}
