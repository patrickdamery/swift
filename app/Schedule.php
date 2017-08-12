<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'schedules';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'description', 'data'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
