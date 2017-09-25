<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'cheques';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'cheque_book_code', 'paid_to', 'cheque_number', 'journal_entry_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
