<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrintRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('print_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('worker_code', 10);
            $table->timestamp('requested_at');
            $table->tinyInteger('state');
            $table->tinyInteger('print_type');
            $table->string('print_code', 10);

            $table->index('worker_code');
            $table->index('requested_at');
            $table->index('state');
            $table->foreign('worker_code')->references('code')->on('workers');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('print_requests');
    }
}
