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
      'name', 'group_by', 'graph_type', 'variables', 'colors', 'graphed_variables',
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
