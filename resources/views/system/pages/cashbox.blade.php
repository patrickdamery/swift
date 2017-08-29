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
  swift_menu.get_language().add_sentence('view-cashbox-tab', {
                                        'en': 'View Cashbox',
                                        'es': 'Ver Caja',
                                      });
  swift_menu.get_language().add_sentence('cashbox-transactions-tab', {
                                        'en': 'View Transactions',
                                        'es': 'Ver Transacciones',
                                      });
  swift_menu.get_language().add_sentence('cashbox-print-requests-tab', {
                                        'en': 'Print Requests',
                                        'es': 'Solicitud de Impresion',
                                      });

swift_event_tracker.register_swift_event('#view-cashbox-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#view-cashbox-tab', function(e) {
  swift_event_tracker.fire_event(e, '#view-cashbox-tab');
});
swift_event_tracker.register_swift_event('#cashbox-transactions-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#cashbox-transactions-tab', function(e) {
  swift_event_tracker.fire_event(e, '#cashbox-transactions-tab');
});
swift_event_tracker.register_swift_event('#cashbox-print-requests-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#cashbox-print-requests-tab', function(e) {
  swift_event_tracker.fire_event(e, '#cashbox-print-requests-tab');
});
</script>
<section class="content-header">
  <h1>
    @lang('cashbox.title')
    <small class="crumb">@lang('cashbox.view_cashbox')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-line-chart"></i> @lang('cashbox.title')</li>
    <li class="active crumb">@lang('cashbox.view_cashbox')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-cashbox" id="view-cashbox-tab" data-toggle="tab" aria-expanded="true">@lang('cashbox.title')</a></li>
      <li><a href="#cashbox-transactions" id="cashbox-transactions-tab" data-toggle="tab" aria-expanded="true">@lang('cashbox.transactions')</a></li>
      <li><a href="#cashbox-print-requests" id="cashbox-print-requests-tab" data-toggle="tab" aria-expanded="true">@lang('cashbox.print_requests')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-cashbox">
        <div class="row form-inline">
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="cashbox-open-close">
                <i class="fa fa-check"></i> @lang('cashbox.open_close')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="cashbox-withdraw">
                <i class="fa fa-eject"></i> @lang('cashbox.withdraw')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="cashbox-reimburse">
                <i class="fa fa-repeat"></i> @lang('cashbox.reimburse')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="cashbox-deposit">
                <i class="fa fa-bank"></i> @lang('cashbox.deposit')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-1" class="control-label">@lang('cashbox.1')</label>
                  <input type="text" class="form-control" id="cashbox-1">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-5" class="control-label">@lang('cashbox.5')</label>
                  <input type="text" class="form-control" id="cashbox-5">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-10" class="control-label">@lang('cashbox.10')</label>
                  <input type="text" class="form-control" id="cashbox-10">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-20" class="control-label">@lang('cashbox.20')</label>
                  <input type="text" class="form-control" id="cashbox-20">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-50" class="control-label">@lang('cashbox.50')</label>
                  <input type="text" class="form-control" id="cashbox-50">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-100" class="control-label">@lang('cashbox.100')</label>
                  <input type="text" class="form-control" id="cashbox-100">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-200" class="control-label">@lang('cashbox.200')</label>
                  <input type="text" class="form-control" id="cashbox-200">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-500" class="control-label">@lang('cashbox.500')</label>
                  <input type="text" class="form-control" id="cashbox-500">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-1000" class="control-label">@lang('cashbox.1000')</label>
                  <input type="text" class="form-control" id="cashbox-1000">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-dollar" class="control-label">@lang('cashbox.dollar')</label>
                  <input type="text" class="form-control" id="cashbox-dollar">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-pos" class="control-label">@lang('cashbox.pos')</label>
                  <input type="text" class="form-control" id="cashbox-pos">
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-total" class="control-label">@lang('cashbox.total')</label>
                  <input type="text" class="form-control" id="cashbox-total">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-total-cash" class="control-label">@lang('cashbox.total_cash')</label>
                  <input type="text" class="form-control" id="cashbox-total-cash">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-total-pos" class="control-label">@lang('cashbox.total_pos')</label>
                  <input type="text" class="form-control" id="cashbox-total-pos">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-total-provider" class="control-label">@lang('cashbox.total_provider')</label>
                  <input type="text" class="form-control" id="cashbox-total-provider">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-total-staff" class="control-label">@lang('cashbox.total_staff')</label>
                  <input type="text" class="form-control" id="cashbox-total-staff">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-total-expense" class="control-label">@lang('cashbox.total_expense')</label>
                  <input type="text" class="form-control" id="cashbox-total-expense">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-total-withdrawal" class="control-label">@lang('cashbox.total_withdrawal')</label>
                  <input type="text" class="form-control" id="cashbox-total-withadrawal">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-total-reimbursement" class="control-label">@lang('cashbox.total_reimbursement')</label>
                  <input type="text" class="form-control" id="cashbox-total-reimbursement">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-total-credit-payments" class="control-label">@lang('cashbox.total_credit_payments')</label>
                  <input type="text" class="form-control" id="cashbox-total-credit-payments">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-total-cash-sales" class="control-label">@lang('cashbox.total_cash_sales')</label>
                  <input type="text" class="form-control" id="cashbox-total-cash-sales">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:15px;">
            <div id="cashbox-chart">
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="cashbox-transactions">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-transaction-date-range" class="control-label">@lang('cashbox.date_range')</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control daterangepicker-sel" id="cashbox-transaction-date-range">
                  </div>
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space xs-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-transaction-type" class="control-label">@lang('cashbox.transaction_type')</label>
                  <select class="form-control" id="cashbox-transaction-type">
                    <option value="all">@lang('cashbox.transaction_all')</option>
                    <option value="cash-sale">@lang('cashbox.transaction_cash_sale')</option>
                    <option value="credit-payment">@lang('cashbox.transaction_credit_payment')</option>
                    <option value="prodiver-payment">@lang('cashbox.transaction_provider_payment')</option>
                    <option value="staff-payment">@lang('cashbox.transaction_staff_payment')</option>
                    <option value="expense-payment">@lang('cashbox.transaction_expense_payment')</option>
                    <option value="withdrawal">@lang('cashbox.transaction_withdrawal')</option>
                    <option value="reimbursement">@lang('cashbox.transaction_reimbursement')</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space xs-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-transaction-cashier" class="control-label">@lang('cashbox.transaction_cashier')</label>
                  <select class="form-control" id="cashbox-transaction-cashier">
                  </select>
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space xs-top-space">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="cashbox-transaction-client" class="control-label">@lang('cashbox.transaction_client')</label>
                  <input type="text" class="form-control" id="cashbox-transaction-client">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space xs-top-space">
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <button type="button" class="btn btn-info" id="cashbox-transaction-search">
                    <i class="fa fa-search"></i> @lang('cashbox.search')
                  </button>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 sm-top-space">
                <div class="form-group">
                  <button type="button" class="btn btn-info" id="cashbox-transaction-search-bill">
                    <i class="fa fa-search"></i> @lang('cashbox.search_bill')
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('cashbox.date')</th>
                      <th>@lang('cashbox.transaction')</th>
                      <th>@lang('cashbox.amount')</th>
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
      <div class="tab-pane" id="cashbox-print-requests">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="cashbox-print-requests-date-range" class="control-label">@lang('cashbox.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="cashbox-print-requests-date-range">
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="cashbox-print-request-filter" class="control-label">@lang('cashbox.filter')</label>
              <select class="form-control" id="cashbox-print-request-filter">
                <option value="all">@lang('cashbox.all')</option>
                <option value="client">@lang('cashbox.client')</option>
                <option value="salesman">@lang('cashbox.salesman')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="cashbox-print-request-auto" class="control-label">@lang('cashbox.auto_print')</label>
              <select class="form-control" id="cashbox-print-request-auto">
                <option value="1">@lang('cashbox.activate')</option>
                <option value="0">@lang('cashbox.deactivate')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline  lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="cashbox-print-requests-search">
                <i class="fa fa-search"></i> @lang('cashbox.search')
              </button>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="cashbox-print-requests-pay">
                <i class="fa fa-money"></i> @lang('cashbox.pay')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('cashbox.date')</th>
                      <th>@lang('cashbox.requestby')</th>
                      <th>@lang('cashbox.type')</th>
                      <th>@lang('cashbox.description')</th>
                      <th>@lang('cashbox.amount')</th>
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
