<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockHistoryBreakdown extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'stock_history_breakdown';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'stock_history_code', 'branch_code', 'product_code', 'existence'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
