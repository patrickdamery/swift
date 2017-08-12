<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{


  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'groups';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'name', 'type', 'members'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
