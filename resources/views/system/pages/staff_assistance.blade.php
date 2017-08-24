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
      <li class="active"><a href="#staff-assistance-schedule" id="staff-assistance-schedule-tab" data-toggle="tab" aria-expanded="true">@lang('staff_assistance.view_staff')</a></li>
      <li><a href="#staff-assistance-entries" id="staff-assistance-entries-tab" data-toggle="tab" aria-expanded="true">@lang('staff_assistance.group_payments')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="staff-assistance-schedule">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-assistance-staff-code" class="control-label">@lang('staff_assistance.code')</label>
              <input type="text" class="form-control" id="staff-assistance-staff-code">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <label for="staff-assistance-staff-branch" class="control-label">@lang('staff_assistance.branch')</label>
              <select class="form-control" id="staff-assistance-staff-branch">
                @foreach(\App\Branch::all() as $branch)
                  <option value="{{ $branch->code }}">{{ $branch->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-assistance-staff-search">
                <i class="fa fa-search"></i> @lang('staff_assistance.search')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">@lang('staff_assistance.income')</h3>
              </div>
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('staff_assistance.date')</th>
                      <th>@lang('staff_assistance.hours')</th>
                      <th>@lang('staff_assistance.salary')</th>
                      <th>@lang('staff_assistance.commission')</th>
                      <th>@lang('staff_assistance.total')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">@lang('staff_assistance.loans')</h3>
              </div>
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('staff_assistance.date')</th>
                      <th>@lang('staff_assistance.description')</th>
                      <th>@lang('staff_assistance.loan')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-assistance-staff-add">
                <i class="fa fa-plus"></i> @lang('staff_assistance.add_hours')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-assistance-staff-loan">
                <i class="fa fa-minus"></i> @lang('staff_assistance.loan')
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="staff-assistance-entries">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-assistance-group-branch" class="control-label">@lang('staff_assistance.branch')</label>
              <select class="form-control" id="staff-assistance-group-branch">
                @foreach(\App\Branch::all() as $branch)
                  <option value="{{ $branch->code }}">{{ $branch->name }}</option>
                @endforeach
              </select>
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
                      <th>@lang('staff_assistance.select')</th>
                      <th>@lang('staff_assistance.worker')</th>
                      <th>@lang('staff_assistance.salary')</th>
                      <th>@lang('staff_assistance.loan')</th>
                      <th>@lang('staff_assistance.commission')</th>
                      <th>@lang('staff_assistance.bonus')</th>
                      <th>@lang('staff_assistance.holidays')</th>
                      <th>@lang('staff_assistance.antiquity')</th>
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
              <button type="button" class="btn btn-success" id="staff-assistance-group-pay">
                <i class="fa fa-money"></i> @lang('staff_assistance.pay')
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
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="staff-assistance-group-print">
                <i class="fa fa-print"></i> @lang('staff_assistance.print')
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
