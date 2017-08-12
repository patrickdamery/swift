<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtherExpense extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'other_expenses';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'type', 'transaction_code', 'reason', 'value', 'journal_entry_code',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
