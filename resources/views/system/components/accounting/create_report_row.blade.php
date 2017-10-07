<div class="modal fade in" id="create-report-row">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/journal.create_row')</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <label for="create-report-row-columns" class="control-label">@lang('accounting/journal.columns')</label>
            <input type="text" class="form-control" id="create-report-row-columns">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/journal.close')</button>
        <button type="button" class="btn btn-primary" id="create-report-row-create">@lang('accounting/journal.add')</button>
      </div>
    </div>
  </div>
</div>
