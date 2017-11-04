<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkerSetting extends Model
{

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'worker_settings';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'full_shift_hours', 'hourly_rate', 'monthly_wage', 'schedule_code',
      'notification_group', 'self_print', 'print_group', 'commission_group',
      'discount_group', 'branches_group', 'pos_group'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
