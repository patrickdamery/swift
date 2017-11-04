<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{

  use SoftDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'workers';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'code', 'name', 'legal_id', 'job_title', 'address', 'inss', 'phone', 'configuration_code', 'state', 'current_branch_code'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;

  /**
   * Function to get workers branch identifier.
   */
  public function branch_identifier() {
    return \App\BranchSetting::where('branch_code', $this->current_branch_code)->first()->identifier;
  }

  /**
   * Function to get workers settings.
   */
  public function get_settings() {
    return \App\WorkerSetting::where('id', $this->configuration_code)->first()->name;
  }
}
