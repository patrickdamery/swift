<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'reservations';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'created', 'code', 'worker_code', 'client_code', 'state', 'subtotal',
      'discount_code', 'taxes', 'total', 'transaction_type', 'transaction_code',
      'deposit', 'journal_entry_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
