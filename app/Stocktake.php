<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stocktake extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'stocktakes';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'created', 'code', 'worker_code', 'branch_code', 'warehouse_code', 'state'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
