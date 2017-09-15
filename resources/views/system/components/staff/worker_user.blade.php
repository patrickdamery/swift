<div class="modal fade in" id="worker-user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('staff/worker_user.title')</h4>
      </div>
      <div class="modal-body">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="worker-user-username" class="control-label">@lang('staff/worker_user.username')</label>
            <input type="text" class="form-control" id="worker-user-username">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <label for="worker-user-email" class="control-label">@lang('staff/worker_user.email')</label>
            <input type="text" class="form-control" id="worker-user-email">
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="worker-user-password" class="control-label">@lang('staff/worker_user.password')</label>
            <input type="password" class="form-control" id="worker-user-password">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('staff/worker_user.close')</button>
        <button type="button" class="btn btn-primary" id="worker-user-update">@lang('staff/worker_user.create')</button>
      </div>
    </div>
  </div>
</div>
