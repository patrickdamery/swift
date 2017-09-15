<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{


  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'groups';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'name', 'type', 'members'
  ];
  /**
   *  Type Definition:
   *  0 = Not Asigned
   *  1 = Branch
   *  2 = Worker
   *  3 = Client
   *  4 = Vehicles
   *  5 = Views
   *  6 = ChatGroup
   *  7 = Discounts
   *  8 = Commissions
   *  9 = POS
   */

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
