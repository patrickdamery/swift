<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'contracts';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'client_code', 'created', 'quota_interval', 'quota', 'start_date',
      'payment_dates', 'interest', 'debt', 'state', 'branch_code', 'account_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
