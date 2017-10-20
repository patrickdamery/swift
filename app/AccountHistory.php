<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHistory extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'account_history';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'month', 'year', 'code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
