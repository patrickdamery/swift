<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderAccount extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'provider_accounts';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'provider_code', 'owed_account', 'service_account',
      'stock_account', 'intransit_account', 'debt_account'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
