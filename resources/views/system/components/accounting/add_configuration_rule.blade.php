<div class="modal fade in" id="add-configuration-rule">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/add_configuration_rule.title')</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="add-configuration-rule-start" class="control-label">@lang('accounting/add_configuration_rule.start')</label>
            <input type="text" class="form-control" id="add-configuration-rule-start">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="add-configuration-rule-end" class="control-label">@lang('accounting/add_configuration_rule.end')</label>
            <input type="text" class="form-control" id="add-configuration-rule-end">
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space xs-top-space">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <label for="add-configuration-rule-percentage" class="control-label">@lang('accounting/add_configuration_rule.percentage')</label>
            <input type="text" class="form-control" id="add-configuration-rule-percentage">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/add_configuration_rule.close')</button>
        <button type="button" class="btn btn-primary" id="add-configuration-rule-add">@lang('accounting/add_configuration_rule.add')</button>
      </div>
    </div>
  </div>
</div>
