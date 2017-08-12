<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'user_level';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'name', 'permissions', 'view'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
