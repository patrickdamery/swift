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
  swift_menu.get_language().add_sentence('bank-accounts-view-accounts-tab', {
                                        'en': 'View Accounts',
                                        'es': 'Ver Cuentas'
                                      });
  swift_menu.get_language().add_sentence('bank-accounts-reports-tab', {
                                      'en': 'Account Reports',
                                      'es': 'Reportes de Cuentas'
                                    });
  swift_menu.get_language().add_sentence('bank-accounts-pos-tab', {
                                      'en': 'POS',
                                      'es': 'POS'
                                    });


swift_event_tracker.register_swift_event('#bank-accounts-view-accounts-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#bank-accounts-view-accounts-tab', function(e) {
  swift_event_tracker.fire_event(e, '#bank-accounts-view-accounts-tab');
});

swift_event_tracker.register_swift_event('#bank-accounts-reports-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#bank-accounts-reports-tab', function(e) {
  swift_event_tracker.fire_event(e, '#bank-accounts-reports-tab');
});

swift_event_tracker.register_swift_event('#bank-accounts-pos-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#bank-accounts-pos-tab', function(e) {
  swift_event_tracker.fire_event(e, '#bank-accounts-pos-tab');
});
</script>

<section class="content-header">
  <h1>
    @lang('accounting/bank_accounts.title')
    <small class="crumb">@lang('accounting/bank_accounts.view_account')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-money"></i> @lang('accounting/bank_accounts.title')</li>
    <li class="active crumb">@lang('accounting/bank_accounts.view_account')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#bank-accounts-view-accounts" id="bank-accounts-view-accounts-tab" data-toggle="tab" aria-expanded="true">@lang('accounting/bank_accounts.view_account')</a></li>
      <li class=""><a href="#bank-accounts-reports" id="bank-accounts-reports-tab" data-toggle="tab" aria-expanded="false">@lang('accounting/bank_accounts.account_reports')</a></li>
      <li class=""><a href="#bank-accounts-pos" id="bank-accounts-pos-tab" data-toggle="tab" aria-expanded="false">@lang('accounting/bank_accounts.pos')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="bank-accounts-view-accounts">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="bank-account-code" class="control-label">@lang('accounting/bank_accounts.number')</label>
              <input class="form-control" id="bank-account-number">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="bank-account-report-date-range" class="control-label">@lang('accounting/bank_accounts.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="bank-account-report-date-range">
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="bank-accounts-create">
                <i class="fa fa-search"></i> @lang('accounting/bank_accounts.search')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space md-top-space lg-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="bank-accounts-transaction">
                <i class="fa fa-bank"></i> @lang('accounting/bank_accounts.make_transaction')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space md-top-space lg-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="bank-accounts-create">
                <i class="fa fa-plus"></i> @lang('accounting/bank_accounts.create')
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
                      <th>@lang('accounting/bank_accounts.date')</th>
                      <th>@lang('accounting/bank_accounts.description')</th>
                      <th>@lang('accounting/bank_accounts.type')</th>
                      <th>@lang('accounting/bank_accounts.value')</th>
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
      <div class="tab-pane" id="bank-accounts-reports">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="bank-account-report-number" class="control-label">@lang('accounting/bank_accounts.number')</label>
              <input class="form-control" id="bank-account-report-number">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="bank-account-report-date-range" class="control-label">@lang('accounting/bank_accounts.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="bank-account-report-date-range">
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="bank-account-report-type" class="control-label">@lang('accounting/bank_accounts.report_type')</label>
              <select class="form-control" id="bank-account-report-type">
                <option value="summary">@lang('accounting/bank_accounts.summary')</option>
                <option value="detail">@lang('accounting/bank_accounts.detail')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="bank-accounts-generate">
                <i class="fa fa-gears"></i> @lang('accounting/bank_accounts.generate')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="bank-accounts-print">
                <i class="fa fa-print"></i> @lang('accounting/bank_accounts.print')
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
                      <th>@lang('accounting/bank_accounts.date')</th>
                      <th>@lang('accounting/bank_accounts.description')</th>
                      <th>@lang('accounting/bank_accounts.credit')</th>
                      <th>@lang('accounting/bank_accounts.debit')</th>
                      <th>@lang('accounting/bank_accounts.value')</th>
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
      <div class="tab-pane" id="bank-accounts-pos">
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('accounting/bank_accounts.code')</th>
                      <th>@lang('accounting/bank_accounts.name')</th>
                      <th>@lang('accounting/bank_accounts.bank_commission')</th>
                      <th>@lang('accounting/bank_accounts.government_commission')</th>
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
          <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs">
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="bank-accounts-pos-create">
                <i class="fa fa-plus"></i> @lang('accounting/bank_accounts.create_pos')
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
