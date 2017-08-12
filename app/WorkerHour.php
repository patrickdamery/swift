<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerHour extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'worker_hours';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'recorded_at', 'worker_code', 'type', 'processed'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
