<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'branches';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'name', 'phone', 'type'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
