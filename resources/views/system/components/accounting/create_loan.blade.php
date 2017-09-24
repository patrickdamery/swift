<div class="modal fade in" id="create-loan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/create_loan.title')</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="create-loan-account" class="control-label">@lang('accounting/create_loan.account_code')</label>
            <input type="text" class="form-control" id="create-loan-account">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="create-loan-amount" class="control-label">@lang('accounting/create_loan.amount')</label>
            <input type="text" class="form-control" id="create-loan-amount">
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="create-loan-start-date" class="control-label">@lang('accounting/create_loan.start_date')</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control datepicker-sel" id="create-loan-start-date">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="create-loan-interval" class="control-label">@lang('accounting/create_loan.interval')</label>
            <select class="form-control" id="create-loan-interval">
              <option value="weekly">@lang('accounting/create_loan.weekly')</option>
              <option value="biweekly">@lang('accounting/create_loan.biweekly')</option>
              <option value="monthly">@lang('accounting/create_loan.monthly')</option>
              <option value="bimester">@lang('accounting/create_loan.bimester')</option>
              <option value="trimester">@lang('accounting/create_loan.trimester')</option>
              <option value="semester">@lang('accounting/create_loan.semester')</option>
              <option value="annualy">@lang('accounting/create_loan.annually')</option>
            </select>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="create-loan-interest" class="control-label">@lang('accounting/create_loan.interest_rate')</label>
            <div class="input-group">
              <input type="text" class="form-control" id="create-loan-interest">
              <span class="input-group-addon">%</span>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="create-loan-payment" class="control-label">@lang('accounting/create_loan.payment_rate')</label>
            <input type="text" class="form-control" id="create-loan-payment">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/create_loan.close')</button>
        <button type="button" class="btn btn-primary" id="create-loan-create">@lang('accounting/create_loan.create')</button>
      </div>
    </div>
  </div>
</div>
