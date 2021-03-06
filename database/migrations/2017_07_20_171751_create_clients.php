<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('legal_id', 15)->unique();
            $table->string('name', 50);
            $table->string('code', 10)->unique();
            $table->string('company_code', 10);
            $table->string('phone', 10);
            $table->string('email', 20);
            $table->string('ocupation', 30);
            $table->tinyInteger('type');
            $table->boolean('has_credit')->default(false);
            $table->smallInteger('credit_days');
            $table->double('credit_limit');
            $table->double('points');
            $table->string('website', 50);
            $table->text('auth_key');
            $table->string('discount_group_code', 10);
            $table->string('location_code', 10);
            $table->softDeletes();

            $table->index('company_code');
            $table->foreign('discount_group_code')->references('code')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
