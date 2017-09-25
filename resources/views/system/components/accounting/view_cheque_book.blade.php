<div class="modal fade in" id="view-cheque-book">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/create_cheque_book.edit_title')</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="view-cheque-book-name" class="control-label">@lang('accounting/create_cheque_book.name')</label>
            <input type="text" class="form-control" id="view-cheque-book-name">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="view-cheque-book-number" class="control-label">@lang('accounting/create_cheque_book.current_number')</label>
            <input type="text" class="form-control" id="view-cheque-book-number">
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>@lang('accounting/create_cheque_book.cheques')</h3>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <label for="view-cheque-book-date-range" class="control-label">@lang('accounting/create_cheque_book.date_range')</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control daterangepicker-sel" id="view-cheque-book-date-range">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 xs-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="view-cheque-book-search">
                <i class="fa fa-search"></i> @lang('accounting/create_cheque_book.search')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box" id="cheques-table">
              @include('system.components.accounting.cheques_table')
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="view-cheque-book-create">
                <i class="fa fa-edit"></i> @lang('accounting/create_cheque_book.create_cheque')
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/create_cheque_book.close')</button>
        <button type="button" class="btn btn-primary" id="view-cheque-book-update">@lang('accounting/create_cheque_book.update')</button>
      </div>
    </div>
  </div>
</div>
