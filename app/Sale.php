<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'sales';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'created', 'code', 'worker_code', 'client_code', 'branch_code', 'credit_sale',
      'subtotal', 'discount_code', 'taxes', 'total', 'pos_code', 'pos_commission',
      'transaction_type', 'transaction_code', 'state', 'journal_entry_code',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
