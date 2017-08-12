<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationBreakdown extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'reservations_breakdown';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'reservation_code', 'product_code', 'quantity', 'price', 'discount_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
