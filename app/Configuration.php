<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'configuration';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'ruc', 'dgi_auth', 'local_currency_code', 'quote_life', 'reservation_life', 'charge_tip',
      'points_enabled', 'hourly_payment', 'points_percentage', 'current_version',
      'latest_version', 'auth_key', 'latest_key_chage', 'key_change_counter',
      'base_url', 'modules', 'plugins', 'main_address',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'auth_key',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
