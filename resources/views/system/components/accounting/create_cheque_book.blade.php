<div class="modal fade in" id="create-cheque-book">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/create_cheque_book.title')</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="create-cheque-book-name" class="control-label">@lang('accounting/create_cheque_book.name')</label>
            <input type="text" class="form-control" id="create-cheque-book-name">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="create-cheque-book-number" class="control-label">@lang('accounting/create_cheque_book.current_number')</label>
            <input type="text" class="form-control" id="create-cheque-book-number">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/create_cheque_book.close')</button>
        <button type="button" class="btn btn-primary" id="create-cheque-book-create">@lang('accounting/create_cheque_book.create')</button>
      </div>
    </div>
  </div>
</div>
