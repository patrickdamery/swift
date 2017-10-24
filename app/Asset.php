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
      'code', 'description', 'depreciation', 'asset_code', 'depreciation_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
