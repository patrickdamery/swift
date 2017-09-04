<div class="modal fade in" id="create-currency">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/create_currency.title')</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-account-code" class="control-label">@lang('accounting/create_currency.code')</label>
            <input class="form-control" id="create-currency-code">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-account-description" class="control-label">@lang('accounting/create_currency.description')</label>
            <input class="form-control" id="create-currency-description">
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-account-exchange" class="control-label">@lang('accounting/create_currency.exchange')</label>
            <input type="text" class="form-control" id="create-currency-exchange">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-account-buy-rate" class="control-label">@lang('accounting/create_currency.buy_rate')</label>
            <input type="text" class="form-control" id="create-currency-buy-rate">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/create_currency.close')</button>
        <button type="button" class="btn btn-primary" id="create-currency-create">@lang('accounting/create_currency.create')</button>
      </div>
    </div>
  </div>
</div>
