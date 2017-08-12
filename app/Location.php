<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'locations';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'description', 'latitude', 'longitude'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
