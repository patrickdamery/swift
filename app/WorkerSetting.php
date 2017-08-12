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
      'worker_code', 'full_shift_hours', 'hourly_rate', 'schedule_code',
      'notification_group', 'self_print', 'print_group', 'commission_group',
      'discount_group', 'branches_group', 'pos_group', 'account_code', 'pay_bonus',
      'pay_holidays', 'pay_antiquity'
  ];

  /**
   * Disable Timestamps.
   */
  public $timestamps = false;
}
