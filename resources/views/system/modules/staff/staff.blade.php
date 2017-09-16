<script>
$(function(){

  // Define Feedback Messages.
  swift_language.add_sentence('active', {
                              'en': 'Active',
                              'es': 'Activo'
                            });
  swift_language.add_sentence('unactive', {
                              'en': 'Unactive',
                              'es': 'Inactivo'
                            });
  swift_language.add_sentence('create', {
                              'en': 'Create',
                              'es': 'Crear'
                            });
  swift_language.add_sentence('update', {
                              'en': 'Update',
                              'es': 'Actualizar'
                            });
  swift_language.add_sentence('short_pasword', {
                              'en': 'The password must be at least 6 characters long!',
                              'es': 'La contraseña debe tener al menos 6 caracteres!'
                            });
  swift_utils.register_ajax_fail();

  // Check if we have already loaded the staff JS file.
  if(typeof staff_js === 'undefined') {
    $.getScript('{{ URL::to('/') }}/js/swift/staff/staff.js');
  }
});
</script>
@include('system.components.staff.worker_user')
@include('system.components.staff.create_worker')
<section class="content-header">
  <h1>
    @lang('staff/staff.title')
    <small class="crumb">@lang('staff/staff.view_staff')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-user"></i> @lang('staff/staff.title')</li>
    <li class="active crumb">@lang('staff/staff.view_staff')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-staff" id="view-staff-tab" data-toggle="tab" aria-expanded="true">@lang('staff/staff.view_staff')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-staff">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-view-code" class="control-label">@lang('staff/staff.code')</label>
              <input type="text" class="form-control" id="staff-view-code">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-branch" class="control-label">@lang('staff/staff.branch')</label>
              <select class="form-control" id="staff-branch">
                <option value="all">@lang('staff/staff.all')</option>
                @foreach(\App\Branch::all() as $branch)
                  <option value="{{ $branch->code }}">{{ $branch->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-worker">
                <i class="fa fa-plus"></i> @lang('staff/staff.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box" id="staff-table">
              @include('system.components.staff.staff_table',[
                'code' => '',
                'branch' => '1',
                'offset' => 1
              ])
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="staff-print">
                <i class="fa fa-print"></i> @lang('staff/staff.print')
              </button>
            </div>
          </div>
        </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
