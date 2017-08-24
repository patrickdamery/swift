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
  swift_menu.get_language().add_sentence('staff-payments-staff-tab', {
                                        'en': 'View Staff',
                                        'es': 'Ver Personal',
                                      });
  swift_menu.get_language().add_sentence('staff-payments-group-tab', {
                                        'en': 'Pay Staff',
                                        'es': 'Pagar Personal',
                                      });
  swift_menu.get_language().add_sentence('staff-payments-past-tab', {
                                        'en': 'Past Payments',
                                        'es': 'Pagos Pasados',
                                      });

swift_event_tracker.register_swift_event('#staff-payments-staff-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#staff-payments-staff-tab', function(e) {
  swift_event_tracker.fire_event(e, '#staff-payments-staff-tab');
});

swift_event_tracker.register_swift_event('#staff-payments-group-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#staff-payments-group-tab', function(e) {
  swift_event_tracker.fire_event(e, '#staff-payments-group-tab');
});

swift_event_tracker.register_swift_event('#staff-payments-past-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#staff-payments-past-tab', function(e) {
  swift_event_tracker.fire_event(e, '#staff-payments-past-tab');
});

</script>
<section class="content-header">
  <h1>
    @lang('staff_payments.title')
    <small class="crumb">@lang('staff_payments.view_staff')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-money"></i> @lang('staff_payments.title')</li>
    <li class="active crumb">@lang('staff_payments.view_staff')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#staff-payments-staff" id="staff-payments-staff-tab" data-toggle="tab" aria-expanded="true">@lang('staff_payments.view_staff')</a></li>
      <li><a href="#staff-payments-group" id="staff-payments-group-tab" data-toggle="tab" aria-expanded="true">@lang('staff_payments.group_payments')</a></li>
      <li><a href="#staff-payments-past" id="staff-payments-past-tab" data-toggle="tab" aria-expanded="true">@lang('staff_payments.past_payments')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="staff-payments-staff">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-payments-staff-code" class="control-label">@lang('staff_payments.code')</label>
              <input type="text" class="form-control" id="staff-payments-staff-code">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <label for="staff-payments-staff-branch" class="control-label">@lang('staff_payments.branch')</label>
              <select class="form-control" id="staff-payments-staff-branch">
                @foreach(\App\Branch::all() as $branch)
                  <option value="{{ $branch->code }}">{{ $branch->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-payments-staff-search">
                <i class="fa fa-search"></i> @lang('staff_payments.search')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">@lang('staff_payments.income')</h3>
              </div>
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('staff_payments.date')</th>
                      <th>@lang('staff_payments.hours')</th>
                      <th>@lang('staff_payments.salary')</th>
                      <th>@lang('staff_payments.commission')</th>
                      <th>@lang('staff_payments.total')</th>
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
                <h3 class="box-title">@lang('staff_payments.loans')</h3>
              </div>
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('staff_payments.date')</th>
                      <th>@lang('staff_payments.description')</th>
                      <th>@lang('staff_payments.loan')</th>
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
              <button type="button" class="btn btn-success" id="staff-payments-staff-add">
                <i class="fa fa-plus"></i> @lang('staff_payments.add_hours')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-payments-staff-loan">
                <i class="fa fa-minus"></i> @lang('staff_payments.loan')
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="staff-payments-group">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-payments-group-branch" class="control-label">@lang('staff_payments.branch')</label>
              <select class="form-control" id="staff-payments-group-branch">
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
                      <th>@lang('staff_payments.select')</th>
                      <th>@lang('staff_payments.worker')</th>
                      <th>@lang('staff_payments.salary')</th>
                      <th>@lang('staff_payments.loan')</th>
                      <th>@lang('staff_payments.commission')</th>
                      <th>@lang('staff_payments.bonus')</th>
                      <th>@lang('staff_payments.holidays')</th>
                      <th>@lang('staff_payments.antiquity')</th>
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
              <button type="button" class="btn btn-success" id="staff-payments-group-pay">
                <i class="fa fa-money"></i> @lang('staff_payments.pay')
              </button>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="staff-payments-group-download">
                <i class="fa fa-download"></i> @lang('staff_payments.download')
              </button>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="staff-payments-group-print">
                <i class="fa fa-print"></i> @lang('staff_payments.print')
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="staff-payments-past">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-payments-past-date-range" class="control-label">@lang('staff_payments.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="staff-payments-past-date-range">
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-payments-past-code" class="control-label">@lang('staff_payments.code')</label>
              <input type="text" class="form-control" id="staff-payments-past-code">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <label for="staff-payments-staff-branch" class="control-label">@lang('staff_payments.branch')</label>
              <select class="form-control" id="staff-payments-staff-branch">
                @foreach(\App\Branch::all() as $branch)
                  <option value="{{ $branch->code }}">{{ $branch->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="staff-payments-past-search">
                <i class="fa fa-search"></i> @lang('staff_payments.search')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">@lang('staff_payments.payments')</h3>
              </div>
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('staff_payments.date')</th>
                      <th>@lang('staff_payments.hours')</th>
                      <th>@lang('staff_payments.description')</th>
                      <th>@lang('staff_payments.paid')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
