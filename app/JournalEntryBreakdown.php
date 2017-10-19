<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalEntryBreakdown extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'journal_entries_breakdown';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'branch_identifier', 'journal_entry_code', 'debit', 'account_code', 'description',
      'amount'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
