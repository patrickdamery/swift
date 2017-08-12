<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'products';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'provider_code', 'description', 'category_code', 'onload_function',
      'onsale_function', 'measurement_unit_code', 'cost', 'avg_cost', 'price',
      'sellable', 'sell_at_base_price', 'base_price', 'alternatives', 'volume',
      'weight', 'package_code', 'package_measurement_unit_code', 'order_by',
      'service', 'materials', 'points_cost', 'account_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
