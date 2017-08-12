<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportationOrderBreakdown extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'importation_orders_breakdown';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'importation_order_code', 'product_code', 'quantity', 'estimated_cost',
      'real_cost'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
