<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'warehouses';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'name', 'branch_code', 'location_code', 'used_space',
      'free_space', 'total_space'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
