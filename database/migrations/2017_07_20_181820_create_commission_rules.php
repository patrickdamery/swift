<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommissionRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('commission_code', 10);
            $table->tinyInteger('type');
            $table->json('goal');
            $table->tinyInteger('commission_type');
            $table->double('commission');
            $table->string('interval', 10);

            $table->index('commission_code');
            $table->foreign('commission_code')->references('code')->on('commissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commission_rules');
    }
}
