<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class AssetDepreciation extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'assets_depreciation';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'asset_code', 'journal_entry_code', 'branch_identifier',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
