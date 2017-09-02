<div class="modal fade in" id="create-account">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/create_account.title')</h4>
      </div>
      <div class="modal-body">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-account-code" class="control-label">@lang('accounting/create_account.code')</label>
            <input class="form-control" id="create-account-code">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-account-name" class="control-label">@lang('accounting/create_account.name')</label>
            <input class="form-control" id="create-account-name">
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-account-type" class="control-label">@lang('accounting/create_account.type')</label>
            <select class="form-control" id="create-account-type">
              <option value="as">@lang('accounting/accounts.asset')</option>
              <option value="dr">@lang('accounting/accounts.draw')</option>
              <option value="ex">@lang('accounting/accounts.expense')</option>
              <option value="li">@lang('accounting/accounts.liability')</option>
              <option value="eq">@lang('accounting/accounts.equity')</option>
              <option value="re">@lang('accounting/accounts.revenue')</option>
            </select>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-account-children" class="control-label">@lang('accounting/create_account.children')</label>
            <select class="form-control" id="create-account-children">
              <option value="1">@lang('accounting/create_account.yes')</option>
              <option value="0">@lang('accounting/create_account.no')</option>
            </select>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-account-parent" class="control-label">@lang('accounting/create_account.parent')</label>
            <input class="form-control" id="create-account-parent">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-account-amount" class="control-label">@lang('accounting/create_account.amount')</label>
            <input class="form-control" id="create-account-amount">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/create_account.close')</button>
        <button type="button" class="btn btn-primary" id="create-account-create">@lang('accounting/create_account.create')</button>
      </div>
    </div>
  </div>
</div>
