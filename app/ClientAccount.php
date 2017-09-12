<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAccount extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'client_accounts';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'client_code', 'owed_account', 'debt_account'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
