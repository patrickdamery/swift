<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalEntriesBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_entries_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->string('journal_entry_code', 10);
            $table->string('branch_identifier', 3);
            $table->boolean('debit')->default(true);
            $table->string('account_code', 20);
            $table->string('description', 255);
            $table->double('amount');

            $table->index('journal_entry_code');
            $table->index('branch_identifier');
            $table->index('debit');
            $table->index('account_code');
            $table->foreign('journal_entry_code')->references('code')->on('journal_entries');
            $table->foreign('branch_identifier')->references('branch_identifier')->on('journal_entries');
            $table->foreign('account_code')->references('code')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_entries_breakdown');
    }
}
