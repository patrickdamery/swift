<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UtilityBill extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'utility_bills';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'utility_code', 'utility_date', 'bill_number', 'sub_total', 'discount',
      'taxes', 'total', 'journal_entry_code', 'branch_identifier',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
