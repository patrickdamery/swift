<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportationOrder extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'importation_orders';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'order_date', 'provider_code', 'state', 'expected_arrival_date'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
