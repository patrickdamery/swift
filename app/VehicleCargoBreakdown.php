<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleCargoBreakdown extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'vehicle_cargo_breakdown';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'vehicle_cargo_code', 'product_code', 'quantity'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
