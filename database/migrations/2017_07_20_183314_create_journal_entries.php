<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('branch_identifier', 2);
            $table->string('code', 15);
            $table->timestamp('entry_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('state');
            $table->softDeletes();

            $table->index('entry_date');
            $table->unique(['branch_identifier', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_entries');
    }
}
