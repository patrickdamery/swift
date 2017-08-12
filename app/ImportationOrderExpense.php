<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportationOrderExpense extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'importation_orders_expenses';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'importation_order_code', 'type', 'expense_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
