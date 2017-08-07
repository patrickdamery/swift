<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'currencies';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'exchange_rate', 'buy_rate', 'description'
  ];

   /**
    * Disable Timestamps.
    */
    public $timestamps = false;
}
