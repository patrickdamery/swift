<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Cashbox extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'cashboxes';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'worker_code', 'cashbox_opened', 'cashbox_closed', 'open',
       'close'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
