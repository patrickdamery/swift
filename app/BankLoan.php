<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankLoan extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'bank_loans';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'bank_account_code', 'account_code', 'journal_entry_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
