<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtilities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('provider_code', 10);
            $table->string('branch_code', 10);
            $table->string('nombre', 15);
            $table->string('interval', 8);
            $table->double('average');
            $table->double('taxes');
            $table->string('account_code');

            $table->index('provider_code');
            $table->index('branch_code');
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
        Schema::dropIfExists('utilities');
    }
}
