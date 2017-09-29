<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'graphs';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'setup'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
