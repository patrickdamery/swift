<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<section class="content-header">
  <h1>
    @lang('staff.title')
    <small class="crumb">@lang('staff.view_staff')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-user"></i> @lang('staff.title')</li>
    <li class="active crumb">@lang('staff.view_staff')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-staff" id="view-staff-tab" data-toggle="tab" aria-expanded="true">@lang('staff.view_staff')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-staff">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-view-code" class="control-label">@lang('staff.code')</label>
              <input type="text" class="form-control" id="staff-view-code">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="staff-vehicle" class="control-label">@lang('staff.branch')</label>
              <select class="form-control" id="staff-vehicle">
                @foreach(\App\Branch::all() as $branch)
                  <option value="{{ $branch->code }}">{{ $branch->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="staff-create">
                <i class="fa fa-plus"></i> @lang('staff.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('staff.name')</th>
                      <th>@lang('staff.legal_id')</th>
                      <th>@lang('staff.job_title')</th>
                      <th>@lang('staff.state')</th>
                      <th>@lang('staff.user')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="staff-print">
                <i class="fa fa-print"></i> @lang('staff.print')
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
