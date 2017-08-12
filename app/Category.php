<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'category';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'description', 'parent_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
