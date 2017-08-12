<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderBill extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'provider_bills';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'bill_date', 'bill_number', 'bill_type', 'subtotal', 'discount',
      'taxes', 'total', 'state', 'provider_code', 'branch_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
