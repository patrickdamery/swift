<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'accounts';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'type', 'name', 'parent_account',
      'has_children', 'amount' , 'currency_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;

  /**
   * Function to get Amount in parents account.
   */
  public function load_amount() {
    if($this->has_children) {
      $children = \App\Account::where('parent_account', $this->code)->get();
      $total = 0;
      foreach($children as $child) {
        $total += $child->load_amount();
      }

      return $total;
    } else {
      return $this->amount;
    }
      return Worker::find($this->WorkerId);
  }
}
