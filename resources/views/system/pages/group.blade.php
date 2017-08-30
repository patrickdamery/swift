<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<section class="content-header">
  <h1>
    @lang('group.title')
    <small class="crumb">@lang('group.view_group')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-users"></i> @lang('group.title')</li>
    <li class="active crumb">@lang('group.view_group')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-group" id="view-group-tab" data-toggle="tab" aria-expanded="true">@lang('group.view_group')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-group">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="group-select" class="control-label">@lang('group.group')</label>
              <select class="form-control" id="group-select">
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="configuration-currency" class="control-label">@lang('group.type')</label>
              <select class="form-control" id="group-type">
                <option value="all">@lang('group.all')</option>
                <option value="branch">@lang('group.branch')</option>
                <option value="worker">@lang('group.worker')</option>
                <option value="client">@lang('group.client')</option>
                <option value="vehicle">@lang('group.vehicle')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="group-create">
                <i class="fa fa-plus"></i> @lang('group.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="group-member" class="control-label">@lang('group.group')</label>
              <input type="text" class="form-control" id="group-member">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="group-add">
                <i class="fa fa-plus"></i> @lang('group.add')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
          </div>
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="padding-top:15px;">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('group.code')</th>
                      <th>@lang('group.member')</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
