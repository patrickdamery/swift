<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbox extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashboxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->string('worker_code', 10);
            $table->timestamp('cashbox_opened')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('cashbox_closed')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->json('open');
            $table->json('close');

            $table->index('cashbox_opened');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashboxes');
    }
}
