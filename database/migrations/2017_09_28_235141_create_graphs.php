<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraphs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('graphs', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name', 25);
        $table->string('group_by', 7);
        $table->string('graph_type', 7);
        $table->json('variables');
        $table->json('colors');
        $table->json('graphed_variables');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('graphs');
    }
}
