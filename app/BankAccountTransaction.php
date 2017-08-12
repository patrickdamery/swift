<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class BankAccountTransaction extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'bank_accounts_transactions';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'bank_account_code', 'transaction_date', 'worker_code', 'reason', 'type',
       'transaction_value', 'before', 'after', 'journal_entry_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
