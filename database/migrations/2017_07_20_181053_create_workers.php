<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('name', 60);
            $table->string('legal_id', 20)->unique();
            $table->string('job_title', 20);
            $table->mediumText('address');
            $table->string('inss', 20);
            $table->tinyInteger('state');
            $table->unsignedInteger('configuration_code')->index();
            $table->string('current_branch_code', 10);
            $table->softDeletes();

            $table->index('current_branch_code');
            $table->index('state');
            $table->foreign('current_branch_code')->references('code')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workers');
    }
}
