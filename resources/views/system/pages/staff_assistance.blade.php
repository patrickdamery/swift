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
  swift_menu.get_language().add_sentence('staff-assistance-schedule-tab', {
                                        'en': 'View Schedule',
                                        'es': 'Ver Horario',
                                      });
  swift_menu.get_language().add_sentence('staff-assistance-entries-tab', {
                                        'en': 'View Entries',
                                        'es': 'Ver Entradas',
                                      });

swift_event_tracker.register_swift_event('#staff-assistance-schedule-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#staff-assistance-schedule-tab', function(e) {
  swift_event_tracker.fire_event(e, '#staff-assistance-schedule-tab');
});

swift_event_tracker.register_swift_event('#staff-assistance-entries-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#staff-assistance-entries-tab', function(e) {
  swift_event_tracker.fire_event(e, '#staff-assistance-entries-tab');
});

</script>
<section class="content-header">
  <h1>
    @lang('staff_assistance.title')
    <small class="crumb">@lang('staff_assistance.view_schedule')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-calendar"></i> @lang('staff_assistance.title')</li>
    <li class="active crumb">@lang('staff_assistance.view_schedule')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#staff-assistance-schedule" id="staff-assistance-schedule-tab" data-toggle="tab" aria-expanded="true">@lang('staff_assistance.view_schedule')</a></li>
      <li><a href="#staff-assistance-entries" id="staff-assistance-entries-tab" data-toggle="tab" aria-expanded="true">@lang('staff_assistance.view_entries')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="staff-assistance-schedule">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-assistance-schedule" class="control-label">@lang('staff_assistance.schedule')</label>
              <select class="form-control" id="staff-assistance-schedule">
                @foreach(\App\Schedule::all() as $schedule)
                  <option value="{{ $schedule->code }}">{{ $schedule->description }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-assistance-create">
                <i class="fa fa-plus"></i> @lang('staff_assistance.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('staff_assistance.time')</th>
                      <th>@lang('staff_assistance.monday')</th>
                      <th>@lang('staff_assistance.tuesday')</th>
                      <th>@lang('staff_assistance.wednesday')</th>
                      <th>@lang('staff_assistance.thursday')</th>
                      <th>@lang('staff_assistance.friday')</th>
                      <th>@lang('staff_assistance.saturday')</th>
                      <th>@lang('staff_assistance.sunday')</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="staff-assistance-print">
                <i class="fa fa-print"></i> @lang('staff_assistance.print')
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="staff-assistance-entries">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-assistance-worker" class="control-label">@lang('staff_assistance.worker')</label>
              <input type="text" class="form-control" id="staff-assistance-worker">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-assistance-date-range" class="control-label">@lang('staff_assistance.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="staff-assistance-date-range">
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:15px;">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('staff_assistance.date')</th>
                      <th>@lang('staff_assistance.hour')</th>
                      <th>@lang('staff_assistance.type')</th>
                      <th>@lang('staff_assistance.state')</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="staff-assistance-group-print">
                <i class="fa fa-print"></i> @lang('staff_assistance.print')
              </button>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="staff-assistance-group-download">
                <i class="fa fa-download"></i> @lang('staff_assistance.download')
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
