<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class CashboxReceipt extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'cashbox_receipts';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'cashbox_transaction_code', 'client_code', 'receipt_time',
       'amount', 'reason', 'journal_entry_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
