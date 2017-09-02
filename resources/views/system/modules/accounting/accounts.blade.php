<script>
$(function(){
 $('.daterangepicker-sel').daterangepicker({
        format: 'dd-mm-yyyy'
  });

  // Define Menu Tab Options.
  swift_menu.new_submenu();
  swift_menu.get_language().add_sentence('accounts-view-accounts-tab', {
                                        'en': 'View Accounts',
                                        'es': 'Ver Cuentas'
                                      });
  swift_menu.get_language().add_sentence('accounts-ledger-tab', {
                                      'en': 'Ledger',
                                      'es': 'Libro Mayor'
                                    });

  // Check if we have already loaded the accounts JS file.
  if(typeof accounts_js === 'undefined') {
    $.getScript('{{ URL::to('/') }}/js/swift/accounting/accounts.js')
  }
});
</script>
@include('system.components.accounting.create_account')
<section class="content-header">
  <h1>
    @lang('accounting/accounts.title')
    <small class="crumb">@lang('accounting/accounts.view_accounts')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-money"></i> @lang('accounting/accounts.title')</li>
    <li class="active crumb">@lang('accounting/accounts.view_accounts')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#accounts-view-accounts" id="accounts-view-accounts-tab" data-toggle="tab" aria-expanded="true">@lang('accounting/accounts.view_accounts')</a></li>
      <li class=""><a href="#accounts-ledger" id="accounts-ledger-tab" data-toggle="tab" aria-expanded="false">@lang('accounting/accounts.ledger')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="accounts-view-accounts">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="account-code" class="control-label">@lang('accounting/accounts.code')</label>
              <input class="form-control" id="account-code">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="account-type" class="control-label">@lang('accounting/accounts.type')</label>
              <select class="form-control" id="account-type">
                <option value="all">@lang('accounting/accounts.all')</option>
                <option value="as">@lang('accounting/accounts.asset')</option>
                <option value="dr">@lang('accounting/accounts.draw')</option>
                <option value="ex">@lang('accounting/accounts.expense')</option>
                <option value="li">@lang('accounting/accounts.liability')</option>
                <option value="eq">@lang('accounting/accounts.equity')</option>
                <option value="re">@lang('accounting/accounts.revenue')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-account">
                <i class="fa fa-plus"></i> @lang('accounting/accounts.create')
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
                      <th>@lang('accounting/accounts.code')</th>
                      <th>@lang('accounting/accounts.type')</th>
                      <th>@lang('accounting/accounts.increases')</th>
                      <th>@lang('accounting/accounts.name')</th>
                      <th>@lang('accounting/accounts.value')</th>
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
      <div class="tab-pane" id="accounts-ledger">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="account-report-code" class="control-label">@lang('accounting/accounts.code')</label>
              <input class="form-control" id="account-report-code">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="account-report-date-range" class="control-label">@lang('accounting/accounts.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="account-report-date-range">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="accounts-download">
                <i class="fa fa-download"></i> @lang('accounting/accounts.download')
              </button>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="accounts-print">
                <i class="fa fa-print"></i> @lang('accounting/accounts.print')
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
                      <th>@lang('accounting/accounts.date')</th>
                      <th>@lang('accounting/accounts.description')</th>
                      <th>@lang('accounting/accounts.debit')</th>
                      <th>@lang('accounting/accounts.credit')</th>
                      <th>@lang('accounting/accounts.value')</th>
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
