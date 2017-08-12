<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderBillBreakdown extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'provider_bills_breakdown';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'provider_bill_code', 'product_code', 'quantity', 'old_real_cost', 'old_average_cost',
      'current_real_cost', 'discount', 'current_discount_code',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
