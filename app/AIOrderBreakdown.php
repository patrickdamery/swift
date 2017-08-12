<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class AIOrderBreakdown extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'ai_orders_breakdown';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'ai_order_code', 'product_code', 'quantity'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
