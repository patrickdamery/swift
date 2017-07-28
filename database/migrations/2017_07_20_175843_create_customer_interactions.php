<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInteractions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_interactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->timestamp('interaction_date');
            $table->tinyInteger('interaction_type');
            $table->string('client_code');
            $table->string('worker_code', 10);
            $table->text('worker_comments');
            $table->tinyInteger('interaction_result');
            $table->string('interaction_result_reference', 10);
            $table->softDeletes();

            $table->index('interaction_date');
            $table->index('client_code');
            $table->index('worker_code');
            $table->index('interaction_result');
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
        Schema::dropIfExists('client_interactions');
    }
}
