<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleCargo extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'vehicle_cargoes';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'journey_code', 'loaded', 'unloaded', 'source_branch_code', 'type',
      'type_code', 'state'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
