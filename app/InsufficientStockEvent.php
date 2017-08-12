<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsufficientStockEvent extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'insufficient_stock_events';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'event_date', 'worker_code', 'branch_code', 'product_code', 'quantity',
      'available_alternatives'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
