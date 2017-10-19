<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journey extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'journeys';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'journey_date', 'journey_time', 'vehicle_code', 'driver_code',
      'start_latitude', 'start_longitude', 'path_taken', 'end_latitude', 'end_longitude',
      'distance_travelled', 'end_address', 'journey_type', 'journey_reason_type',
      'journey_reason_code', 'state', 'depreciation', 'journal_entry_code', 'branch_identifier',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
