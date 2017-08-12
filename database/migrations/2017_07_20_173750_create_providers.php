<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('name', 50);
            $table->string('phone', 20);
            $table->string('email', 80);
            $table->string('ruc', 15)->unique();
            $table->string('website', 25);
            $table->boolean('taxes')->default(true);
            $table->tinyInteger('provider_type');
            $table->boolean('offers_credit')->default(false);
            $table->double('credit_limit');
            $table->double('credit_days');
            $table->boolean('ai_managed')->default(false);
            $table->smallInteger('sample_range_days');
            $table->smallInteger('order_range_days');
            $table->string('location_code', 10);
            $table->boolean('delivers')->default(false);
            $table->string('preferred_contact_method', 20);
            $table->string('account_code', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
