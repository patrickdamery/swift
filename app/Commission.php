<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'commissions';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'name'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
