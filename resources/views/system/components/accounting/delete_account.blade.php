<div class="modal fade in" id="delete-account">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/delete_account.title')</h4>
      </div>
      <div class="modal-body">
        <div class="row form-inline">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="delete-account-option" class="control-label">@lang('accounting/delete_account.confirm_delete')</label>
            <select class="form-control" id="delete-account-option">
              <option value="0">@lang('accounting/delete_account.no')</option>
              <option value="1">@lang('accounting/delete_account.yes')</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/delete_account.close')</button>
        <button type="button" class="btn btn-primary" id="delete-account-delete">@lang('accounting/delete_account.delete')</button>
      </div>
    </div>
  </div>
</div>
