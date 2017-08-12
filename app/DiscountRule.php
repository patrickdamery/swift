<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountRule extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'discount_rules';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'discount_code', 'product_code', 'rules', 'discount_type', 'discount'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
