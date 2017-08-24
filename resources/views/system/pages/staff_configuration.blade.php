<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<section class="content-header">
  <h1>
    @lang('staff_configuration.title')
    <small class="crumb">@lang('staff_configuration.view_config')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cogs"></i> @lang('staff_configuration.title')</li>
    <li class="active crumb">@lang('staff_configuration.view_config')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#staff-configuration" id="staff-configuration-tab" data-toggle="tab" aria-expanded="true">@lang('staff_configuration.view_config')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="staff-configuration">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-configuration-code" class="control-label">@lang('staff_configuration.code')</label>
              <input type="text" class="form-control" id="staff-configuration-code">
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-configuration-hourly-rate" class="control-label">@lang('staff_configuration.hourly_rate')</label>
              <input type="text" class="form-control" id="staff-configuration-hourly-rate">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-configuration-hours-day" class="control-label">@lang('staff_configuration.hours_day')</label>
              <input type="text" class="form-control" id="staff-configuration-hours-day">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-configuration-schedule">
                <i class="fa fa-calendar"></i> @lang('staff_configuration.schedule')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-configuration-notification-group" class="control-label">@lang('staff_configuration.notification_group')</label>
              <input type="text" class="form-control" id="staff-configuration-notification-group">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-configuration-self-print" class="control-label">@lang('staff_configuration.self_print')</label>
              <select class="form-control" id="staff-configuration-self-print">
                <option value="yes">@lang('staff_configuration.yes')</option>
                <option value="no">@lang('staff_configuration.no')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="staff-configuration-print-group" class="control-label">@lang('staff_configuration.print_group')</label>
              <input type="text" class="form-control" id="staff-configuration-print-group">
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-configuration-commission">
                <i class="fa fa-money"></i> @lang('staff_configuration.commission')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="staff-configuration-discounts">
                <i class="fa fa-money"></i> @lang('staff_configuration.discounts')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-configuration-branch">
                <i class="fa fa-building"></i> @lang('staff_configuration.branches')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-configuration-pos">
                <i class="fa fa-credit-card"></i> @lang('staff_configuration.pos')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-configuration-holidays" class="control-label">@lang('staff_configuration.holidays')</label>
              <select class="form-control" id="staff-configuration-holidays">
                <option value="yes">@lang('staff_configuration.yes')</option>
                <option value="no">@lang('staff_configuration.no')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="staff-configuration-bonus" class="control-label">@lang('staff_configuration.bonus')</label>
              <select class="form-control" id="staff-configuration-bonus">
                <option value="yes">@lang('staff_configuration.yes')</option>
                <option value="no">@lang('staff_configuration.no')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-configuration-antiquity" class="control-label">@lang('staff_configuration.antiquity')</label>
              <select class="form-control" id="staff-configuration-antiquity">
                <option value="yes">@lang('staff_configuration.yes')</option>
                <option value="no">@lang('staff_configuration.no')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-configuration-save">
                <i class="fa fa-save"></i> @lang('staff_configuration.save')
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
