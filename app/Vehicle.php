<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'vehicles';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'make', 'model', 'efficiency', 'under_repairs', 'type',
       'initial_value', 'current_value', 'currency_code', 'number_plate',
       'latitude', 'longitude', 'account_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
