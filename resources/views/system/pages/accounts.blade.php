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
  swift_menu.get_language().add_sentence('accounts-view-accounts-tab', {
                                        'en': 'View Accounts',
                                        'es': 'Ver Cuentas'
                                      });
  swift_menu.get_language().add_sentence('accounts-reports-tab', {
                                      'en': 'Account Reports',
                                      'es': 'Reportes de Cuentas'
                                    });

swift_event_tracker.register_swift_event('#accounts-view-accounts-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#accounts-view-accounts-tab', function(e) {
  swift_event_tracker.fire_event(e, '#accounts-view-accounts-tab');
});

swift_event_tracker.register_swift_event('#accounts-reports-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#accounts-reports-tab', function(e) {
  swift_event_tracker.fire_event(e, '#accounts-reports-tab');
});

</script>

<section class="content-header">
  <h1>
    @lang('accounts.title')
    <small class="crumb">@lang('accounts.view_accounts')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-money"></i> @lang('accounts.title')</li>
    <li class="active crumb">@lang('accounts.view_accounts')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#accounts-view-accounts" id="accounts-view-accounts-tab" data-toggle="tab" aria-expanded="true">@lang('accounts.view_accounts')</a></li>
      <li class=""><a href="#accounts-reports" id="accounts-reports-tab" data-toggle="tab" aria-expanded="false">@lang('accounts.account_reports')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="accounts-view-accounts">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="account-code" class="control-label">@lang('accounts.code')</label>
              <input class="form-control" id="account-code">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="account-type" class="control-label">@lang('accounts.type')</label>
              <select class="form-control" id="account-type">
                <option value="as">@lang('accounts.asset')</option>
                <option value="dr">@lang('accounts.draw')</option>
                <option value="ex">@lang('accounts.expense')</option>
                <option value="li">@lang('accounts.liability')</option>
                <option value="eq">@lang('accounts.equity')</option>
                <option value="re">@lang('accounts.revenue')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="accounts-create">
                <i class="fa fa-plus"></i> @lang('accounts.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('accounts.code')</th>
                      <th>@lang('accounts.type')</th>
                      <th>@lang('accounts.increases')</th>
                      <th>@lang('accounts.name')</th>
                      <th>@lang('accounts.value')</th>
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
      <div class="tab-pane" id="accounts-reports">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="account-report-code" class="control-label">@lang('accounts.code')</label>
              <input class="form-control" id="account-report-code">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="account-report-date-range" class="control-label">@lang('accounts.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="account-report-date-range">
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="account-report-type" class="control-label">@lang('accounts.report_type')</label>
              <select class="form-control" id="account-report-type">
                <option value="summary">@lang('accounts.summary')</option>
                <option value="detail">@lang('accounts.detail')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="accounts-generate">
                <i class="fa fa-gears"></i> @lang('accounts.generate')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="accounts-print">
                <i class="fa fa-print"></i> @lang('accounts.print')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('accounts.date')</th>
                      <th>@lang('accounts.description')</th>
                      <th>@lang('accounts.debit')</th>
                      <th>@lang('accounts.credit')</th>
                      <th>@lang('accounts.value')</th>
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
