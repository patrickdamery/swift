<div class="modal fade in" id="create-depreciating-assets">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/create_depreciating_asset.title')</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label for="create-depreciating-asset-name" class="control-label">@lang('accounting/create_depreciating_asset.name')</label>
            <input type="text" class="form-control" id="create-depreciating-asset-name">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 sm-top-space">
            <label for="create-depreciating-asset-depreciation" class="control-label">@lang('accounting/create_depreciating_asset.depreciation')</label>
            <input type="text" class="form-control" id="create-depreciating-asset-depreciation">
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label for="create-depreciating-asset-description" class="control-label">@lang('accounting/create_depreciating_asset.description')</label>
            <textarea class="form-control" id="create-depreciating-asset-description"></textarea>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label for="create-depreciating-asset-account" class="control-label">@lang('accounting/create_depreciating_asset.asset_account')</label>
            <input type="text" class="form-control" id="create-depreciating-asset-account">
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label for="create-depreciating-expense-account" class="control-label">@lang('accounting/create_depreciating_asset.expense_account')</label>
            <input type="text" class="form-control" id="create-depreciating-expense-account">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <label for="create-depreciating-depreciation-account" class="control-label">@lang('accounting/create_depreciating_asset.depreciation_account')</label>
            <input type="text" class="form-control" id="create-depreciating-depreciation-account">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/create_depreciating_asset.close')</button>
        <button type="button" class="btn btn-primary" id="create-depreciating-asset-create">@lang('accounting/create_depreciating_asset.create')</button>
      </div>
    </div>
  </div>
</div>
