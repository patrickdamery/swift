@php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
@endphp
<div class="modal fade in" id="bank-account-transaction">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/bank_account_transaction.title')</h4>
      </div>
      <div class="modal-body">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="bank-account-transaction-code" class="control-label">@lang('accounting/bank_account_transaction.code')</label>
            <input type="text" class="form-control" id="bank-account-transaction-code">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="bank-account-transaction-reason" class="control-label">@lang('accounting/bank_account_transaction.reason')</label>
            <input type="text" id="bank-account-transaction-reason" class="form-control">
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label for="bank-account-transaction-type" class="control-label">@lang('accounting/bank_account_transaction.type')</label>
            <select class="form-control" id="bank-account-transaction-type">
              <option value="1">@lang('accounting/bank_account_transaction.deposit')</option>
              <option value="2">@lang('accounting/bank_account_transaction.withdraw')</option>
            </select>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center ">
            <label for="bank-account-transaction-value" class="control-label">@lang('accounting/bank_account_transaction.value')</label>
            <input type="text" class="form-control" id="bank-account-transaction-value">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/bank_account_transaction.close')</button>
        <button type="button" class="btn btn-primary" id="make-bank-account-transaction">@lang('accounting/bank_account_transaction.create')</button>
      </div>
    </div>
  </div>
</div>
