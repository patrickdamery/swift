<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationBreakdown extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'quotations_breakdown';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'quotation_code', 'product_code', 'quantity', 'price', 'discount_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
