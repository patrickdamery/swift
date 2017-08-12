<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class BankAccount extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'bank_accounts';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'bank_name', 'account_number', 'currency_code', 'balance',
       'account_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
