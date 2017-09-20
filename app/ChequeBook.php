<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChequeBook extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'cheque_book';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'bank_account_code', 'name', 'current_number'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
