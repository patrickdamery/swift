<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerLoan extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'worker_loans';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'worker_code', 'loan_date', 'amount', 'payment_code',
      'journal_entry_code', 'branch_identifier',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
