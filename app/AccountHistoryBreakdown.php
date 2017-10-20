<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHistoryBreakdown extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'account_history_breakdown';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'account_history_code', 'account_code', 'balance'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
