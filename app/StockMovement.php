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
      'created', 'product_code', 'amount', 'type', 'reference_code', 'reason',
      'reason', 'journal_entry_code', 'branch_identifier',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
