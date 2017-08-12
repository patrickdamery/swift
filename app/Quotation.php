<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'quotations';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'created', 'code', 'worker_code', 'client_code', 'subtotal', 'tax', 'discount_code',
      'total', 'state', 'day_limit'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
