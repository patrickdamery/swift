<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Calendar extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'calendars';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'start', 'end', 'worker_code', 'title', 'all_day',
       'reminded', 'type'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
