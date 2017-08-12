<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StocktakeBreakdown extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'stocktakes_breakdown';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'stocktake_code', 'product_code', 'system_quantity', 'counted', 'difference',
      'state', 'extra_data'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
