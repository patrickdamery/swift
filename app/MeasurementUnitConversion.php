<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeasurementUnitConversion extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'measurement_unit_conversions';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'measurement_unit_code', 'convert_to_code', 'factor'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
