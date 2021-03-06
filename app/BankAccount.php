<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BankAccount extends Model
{

  use SoftDeletes;
  
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
      'code', 'bank_name', 'account_number', 'account_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
