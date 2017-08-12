<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrintRequest extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'print_requests';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'worker_code', 'requested_at', 'state', 'print_type', 'print_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
