<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UtilityBill extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'utility_bills';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'worker_code', 'start_date', 'next_payment', 'interval', 'quota',
      'debt', 'paid'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
