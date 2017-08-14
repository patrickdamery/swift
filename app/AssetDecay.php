<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class AIOrder extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'asset_decay';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'asset_code', 'decayed_date', 'value', 'journal_entry_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}