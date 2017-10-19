<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerIncome extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'workers_income';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'income_date', 'branch_date', 'worker_code', 'income', 'type',
      'payment_code', 'journal_entry_code', 'branch_identifier',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
