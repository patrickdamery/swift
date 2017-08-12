<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerSavingTransaction extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'worker_savings_transactions';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'savings_code', 'transaction_date', 'type', 'before', 'amount', 'after',
      'journal_entry_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
