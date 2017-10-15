<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountingAccount extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'accounting_accounts';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'retained_VAT_account', 'advanced_VAT_account', 'VAT_percentage', 'fixed_fee', 'ISC_account',
      'advanced_IT_account', 'retained_IT_account', 'IT_percentage', 'IT_rules', 'entity_type'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;

}
