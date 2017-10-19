<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsDecay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_decay', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asset_code', 10);
            $table->timestamp('decayed_date');
            $table->double('value');
            $table->string('journal_entry_code', 15);
            $table->string('branch_identifier', 3);

            $table->index('asset_code');
            $table->foreign('asset_code')->references('code')->on('assets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets_decay');
    }
}
