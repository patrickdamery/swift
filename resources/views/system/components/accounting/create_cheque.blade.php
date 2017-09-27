<div class="modal fade in" id="create-cheque">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/create_cheque_book.create_cheque')</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="create-cheque-account" class="control-label">@lang('accounting/create_cheque_book.paid_account')</label>
            <input type="text" class="form-control" id="create-cheque-account">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="create-cheque-amount" class="control-label">@lang('accounting/create_cheque_book.amount')</label>
            <input type="text" class="form-control" id="create-cheque-amount">
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="create-cheque-pay-to" class="control-label">@lang('accounting/create_cheque_book.pay_to')</label>
            <input type="text" class="form-control" id="create-cheque-pay-to">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="create-cheque-description" class="control-label">@lang('accounting/create_cheque_book.description')</label>
            <textarea cols="25" rows="5" class="form-control" id="create-cheque-description"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/create_cheque_book.close')</button>
        <button type="button" class="btn btn-primary" id="create-cheque-create">@lang('accounting/create_cheque_book.print')</button>
      </div>
    </div>
  </div>
</div>
