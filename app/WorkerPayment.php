<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerPayment extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'worker_payments';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'payment_date', 'worker_code', 'payment_data', 'total_paid',
      'journal_entry_code',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
