<div class="modal fade in" id="make-closing-entry">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/make_closing_entry.title')</h4>
      </div>
      <div class="modal-body">
        <div class="row form-inline">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <label for="make-closing-entry-confirmation" class="control-label">@lang('accounting/make_closing_entry.confirmation')</label>
            <select class="form-control" id="make-closing-entry-confirmation">
              <option value="0">@lang('accounting/make_closing_entry.no')</option>
              <option value="1">@lang('accounting/make_closing_entry.yes')</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/make_closing_entry.close')</button>
        <button type="button" class="btn btn-primary" id="make-closing-entry-confirm">@lang('accounting/make_closing_entry.confirm')</button>
      </div>
    </div>
  </div>
</div>
