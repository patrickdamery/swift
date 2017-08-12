<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMovement extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'stock_movements';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'created', 'product_code', 'quanitity_before_movement', 'quantity_to_move',
      'quantity_after_movement', 'type', 'reference_code', 'taxes', 'total', 'reason',
      'reason', 'journal_entry_code',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
