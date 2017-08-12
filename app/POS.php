<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class POS extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'pos';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'bank_account_code', 'bank_commission', 'government_commission'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
