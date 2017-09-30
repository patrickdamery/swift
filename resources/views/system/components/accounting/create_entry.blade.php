<div class="modal fade in" id="create-entry">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('accounting/create_entry.title')</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-entry-account" class="control-label">@lang('accounting/create_entry.account')</label>
            <input type="text" class="form-control" id="create-entry-account">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-entry-amount" class="control-label">@lang('accounting/create_entry.amount')</label>
            <input type="text" class="form-control" id="create-entry-amount">
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-entry-type" class="control-label">@lang('accounting/create_entry.type')</label>
            <input type="text" class="form-control" id="create-entry-type">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-entry-description" class="control-label">@lang('accounting/create_entry.description')</label>
            <input type="text" class="form-control" id="create-entry-description">
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space xs-top-space">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="journal-create-add">
                <i class="fa fa-plus"></i> @lang('accounting/create_entry.add')
              </button>
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">@lang('accounting/create_entry.entries')</h3>
              </div>
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('accounting/create_entry.account')</th>
                      <th>@lang('accounting/create_entry.description')</th>
                      <th>@lang('accounting/create_entry.debit')</th>
                      <th>@lang('accounting/create_entry.credit')</th>
                    </tr>
                  </thead>
                  <tbody id="journal-entry-table-body">
                  </tbody>
                  <tfoot id="journal-entry-table-footer">
                    <tr>
                      <th colspan="2"></th>
                      <th class="debit"></th>
                      <th class="credit"></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('accounting/create_entry.close')</button>
        <button type="button" class="btn btn-primary" id="create-entry-create">@lang('accounting/create_entry.create')</button>
      </div>
    </div>
  </div>
</div>
