<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Asset extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'assets';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'description', 'value', 'lifespan', 'group_code',
       'depreciates', 'depreciation_option', 'account_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
