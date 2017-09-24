<div class="modal fade in" id="view-pos">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/create_pos.edit_title')</h4>
      </div>
      <div class="modal-body">
        <div class="row form-inline">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <label for="view-pos-name" class="control-label">@lang('accounting/create_pos.name')</label>
            <input type="text" class="form-control" id="view-pos-name">
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="view-pos-bank-commission" class="control-label">@lang('accounting/create_pos.bank_commission')</label>
            <div class="input-group">
              <input type="text" class="form-control" id="view-pos-bank-commission">
              <span class="input-group-addon">%</span>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="view-pos-government-commission" class="control-label">@lang('accounting/create_pos.government_commission')</label>
            <div class="input-group">
              <input type="text" class="form-control" id="view-pos-government-commission">
              <span class="input-group-addon">%</span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/create_pos.close')</button>
        <button type="button" class="btn btn-primary" id="view-pos-edit">@lang('accounting/create_pos.update')</button>
      </div>
    </div>
  </div>
</div>
