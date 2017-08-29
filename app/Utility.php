<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'utilities';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'provider_code', 'branch_code', 'name', 'interval', 'average',
      'taxes', 'account_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
