<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'user_access';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'name', 'access'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
