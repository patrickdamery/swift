<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('branch_identifier', 3)->index();
            $table->string('code', 10)->index();
            $table->string('worker_code', 10);
            $table->string('client_code', 10);
            $table->string('branch_code', 10);
            $table->boolean('credit_sale')->default(false);
            $table->double('subtotal');
            $table->string('discount_code', 10);
            $table->double('taxes');
            $table->double('total');
            $table->string('pos_code', 10)->default('0');
            $table->double('pos_commission')->default(0);
            $table->tinyInteger('transaction_type');
            $table->string('transaction_code', 10);
            $table->tinyInteger('state');
            $table->string('journal_entry_code', 15);
            $table->softDeletes();

            $table->index('worker_code');
            $table->index('client_code');
            $table->index('branch_code');
            $table->index('created');
            $table->unique(['branch_identifier', 'code']);
            $table->foreign('client_code')->references('code')->on('clients');
            $table->foreign('branch_code')->references('code')->on('branches');
            $table->foreign('discount_code')->references('code')->on('discount_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
