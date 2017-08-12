<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'discounts';

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
