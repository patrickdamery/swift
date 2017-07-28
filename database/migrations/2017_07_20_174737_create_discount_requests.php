<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created');
            $table->string('code', 10)->unique();
            $table->string('requested_by_code', 10);
            $table->string('decided_by_code', 10);
            $table->double('discount');
            $table->tinyInteger('discount_type');
            $table->string('reason', 50);
            $table->json('data');
            $table->boolean('used')->default(false);

            $table->index('requested_by_code');
            $table->index('decided_by_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_requests');
    }
}
