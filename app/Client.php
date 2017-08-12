<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'clients';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'legal_id', 'name', 'company_code', 'phone', 'email',
      'address', 'ocupation', 'type', 'has_credit', 'credit_days',
      'credit_limit', 'points', 'discount_group_code', 'location_code',
      'account_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
