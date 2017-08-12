<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommisionRule extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'commission_rules';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'commission_code', 'type', 'goal', 'commission_type', 'commission',
      'itnerval'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
