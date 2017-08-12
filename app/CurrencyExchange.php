<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyExchange extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'currency_exchange_variations';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'exchange_date', 'currency_code', 'exchange_rate', 'buy_rate',
      'local_currency_code'
  ];

   /**
    * Disable Timestamps.
    */
    public $timestamps = false;
}
