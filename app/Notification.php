<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'notifications';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'worker_code', 'created', 'reason', 'url', 'seen', 'loaded', 'data'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
