<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderBillPayment extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'provider_bills_payments';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'payment_date', 'provider_bill_code', 'transaction_code', 'transaction_type',
      'payment', 'debt', 'journal_entry_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
