<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerIncome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers_income', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->unique();
            $table->timestamp('income_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('branch_code', 10);
            $table->string('worker_code', 10);
            $table->double('income');
            $table->tinyInteger('type');
            $table->string('payment_code', 10);
            $table->string('journal_entry_code', 15);
            $table->string('branch_identifier', 3);

            $table->index('branch_code');
            $table->index('worker_code');
            $table->index('income_date');
            $table->index('payment_code');
            $table->index('type');
            $table->foreign('branch_code')->references('code')->on('branches');
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
        Schema::dropIfExists('workers_income');
    }
}
