<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseLocation extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'warehouse_locations';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'warehouse_code', 'stand', 'row', 'cell', 'used_space',
      'free_space', 'total_space'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
