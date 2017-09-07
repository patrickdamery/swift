<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocktake extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocktakes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('code', 10)->unique();
            $table->string('worker_code', 10);
            $table->string('branch_code', 10);
            $table->string('warehouse_code', 10);
            $table->tinyInteger('state');
            $table->softDeletes();

            $table->index('worker_code');
            $table->index('branch_code');
            $table->index('warehouse_code');
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
        Schema::dropIfExists('stocktakes');
    }
}
