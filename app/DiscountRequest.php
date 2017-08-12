<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountRequest extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'discount_requests';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'created', 'code', 'requested_by_code', 'decided_by_code', 'discount',
      'discount_type', 'reason', 'data', 'used'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
