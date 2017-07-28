<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AiOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ai_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->timestamp('generated')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('confirmed')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('state');
            $table->string('provider_code', 10);
            $table->string('branch_code', 10);
            $table->boolean('received')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ai_orders');
    }
}
