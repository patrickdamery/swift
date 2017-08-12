<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeasurementUnit extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'measurement_units';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'name'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
