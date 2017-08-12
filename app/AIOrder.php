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
  protected $table = 'ai_orders';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'generated', 'confirmed', 'state', 'provider_code',
       'state', 'branch_code', 'received'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
