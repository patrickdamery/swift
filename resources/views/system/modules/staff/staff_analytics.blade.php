<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<script>
$(function(){
 $('.daterangepicker-sel').daterangepicker({
        format: 'dd-mm-yyyy'
      });
  });
  swift_menu.new_submenu();
  swift_menu.get_language().add_sentence('staff-analytics-tab', {
                                        'en': 'View Analytics',
                                        'es': 'Ver Analítica',
                                      });

swift_event_tracker.register_swift_event('#staff-analytics-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#staff-analytics-tab', function(e) {
  swift_event_tracker.fire_event(e, '#staff-analytics-tab');
});
</script>
<section class="content-header">
  <h1>
    @lang('staff_analytics.title')
    <small class="crumb">@lang('staff_analytics.view_analytics')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-line-chart"></i> @lang('staff_analytics.title')</li>
    <li class="active crumb">@lang('staff_analytics.view_analytics')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#staff-analytics" id="staff-analytics-tab" data-toggle="tab" aria-expanded="true">@lang('staff_analytics.view_analytics')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="staff-analytics">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-analytics-worker" class="control-label">@lang('staff_analytics.worker')</label>
              <input type="text" class="form-control" id="staff-analytics-worker">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-analytics-date-range" class="control-label">@lang('staff_analytics.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="staff-analytics-date-range">
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline  lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-analytics-generate">
                <i class="fa fa-gears"></i> @lang('staff_analytics.generate')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:15px;">
            <div id="staff-analytics-chart">
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
