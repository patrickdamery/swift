<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created');
            $table->string('code', 10)->unique();
            $table->string('client_code', 10);
            $table->string('discount_code', 10);
            $table->tinyInteger('state');

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
        Schema::dropIfExists('tabs');
    }
}
