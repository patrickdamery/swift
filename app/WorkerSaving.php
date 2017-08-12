<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerSaving extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'worker_savings';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'worker_code', 'currency_code', 'amount_saved', 'account_code',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
