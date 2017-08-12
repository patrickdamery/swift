<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractBreakdown extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'contracts_breakdown';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'contract_code', 'product_code', 'quantity', 'price'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
