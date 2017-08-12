<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'providers';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'name', 'phone', 'email', 'ruc', 'website', 'taxes', 'provider_type',
      'offers_credit', 'credit_limit', 'credit_days', 'ai_managed', 'sample_range_days',
      'order_range_days', 'location_code', 'delivers',
      'preferred_contact_method', 'account_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
