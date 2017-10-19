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
      'code', 'bank_account_code', 'account_code', 'start_date', 'payment_rate',
      'interest_rate', 'interval', 'next_payment', 'state', 'journal_entry_code',
      'branch_identifier',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
