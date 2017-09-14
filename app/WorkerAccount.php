<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerAccount extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'worker_accounts';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'worker_code', 'cashbox_account', 'stock_account', 'loan_account',
      'long_loan_account', 'salary_account', 'commission_account', 'bonus_account',
      'antiquity_account', 'holidays_account', 'savings_account', 'insurance_account',
      'reimbursement_accounts', 'draw_accounts', 'bank_accounts'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
