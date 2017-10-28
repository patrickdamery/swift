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
      'code', 'name', 'description', 'depreciation', 'asset_code', 'expense_code', 'depreciation_code', 'state'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
