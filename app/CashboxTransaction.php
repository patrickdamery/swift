<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class CashboxTransaction extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'cashbox_transactions';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'cashbox_code', 'code', 'transaction_time', 'type', 'amout',
       'reason', 'journal_entry_code', 'branch_identifier',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
