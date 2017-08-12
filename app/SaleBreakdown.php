<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleBreakdown extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'sales_breakdown';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'sales_code', 'product_code', 'discount_code', 'quantity', 'cost',
      'price', 'extra_data'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
