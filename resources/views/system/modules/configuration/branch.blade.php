<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<script>
$(function(){
 $('.daterangepicker-sel').daterangepicker({
        format: 'dd-mm-yyyy'
      });
  });
  swift_menu.new_submenu();
  swift_menu.get_language().add_sentence('view-branch-tab', {
                                        'en': 'View Branch',
                                        'es': 'Ver Sucursal',
                                      });
  swift_menu.get_language().add_sentence('branch-utilities-tab', {
                                        'en': 'View Utilities',
                                        'es': 'Ver Utilidades',
                                      });

swift_event_tracker.register_swift_event('#view-branch-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#view-branch-tab', function(e) {
  swift_event_tracker.fire_event(e, '#view-branch-tab');
});
swift_event_tracker.register_swift_event('#branch-utilities-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#branch-utilities-tab', function(e) {
  swift_event_tracker.fire_event(e, '#branch-utilities-tab');
});
</script>
<script>
  function initMap() {
    var uluru = {lat: -25.363, lng: 131.044};
    var map = new google.maps.Map(document.getElementById('branch-view-map'), {
      zoom: 4,
      center: uluru
    });
    var marker = new google.maps.Marker({
      position: uluru,
      map: map
    });
  }
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXap_tqT_ErXCLLlmvc2RQFemtAJcDtCo&callback=initMap">
</script>
<section class="content-header">
  <h1>
    @lang('branch.title')
    <small class="crumb">@lang('branch.view_branch')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-building"></i> @lang('branch.title')</li>
    <li class="active crumb">@lang('branch.view_branch')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-branch" id="view-branch-tab" data-toggle="tab" aria-expanded="true">@lang('branch.view_branch')</a></li>
      <li><a href="#branch-utilities" id="branch-utilities-tab" data-toggle="tab" aria-expanded="true">@lang('branch.utilities')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-branch">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="branch" class="control-label">@lang('branch.branch')</label>
              <select class="form-control" id="branch">
                @foreach(\App\Branch::all() as $branch)
                  <option value="{{ $branch->code }}">{{ $branch->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="branch-search">
                <i class="fa fa-search"></i> @lang('branch.search')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="branch-create">
                <i class="fa fa-plus"></i> @lang('branch.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="branch-name" class="control-label">@lang('branch.name')</label>
              <input type="text" class="form-control" id="branch-name">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="branch-phone" class="control-label">@lang('branch.phone')</label>
              <input type="text" class="form-control" id="branch-phone">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="branch-schedule" class="control-label">@lang('branch.schedule')</label>
              <select class="form-control" id="branch-schedule">
                @foreach(\App\Schedule::all() as $schedule)
                  <option value="{{ $schedule->code}}">{{ $schedule->description }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="branch-vehicle" class="control-label">@lang('branch.vehicle')</label>
              <select class="form-control" id="branch-vehicle">
                @foreach(\App\Group::where('type', 4)->get() as $group)
                  <option value="{{ $group->code}}">{{ $group->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="branch-worker" class="control-label">@lang('branch.worker')</label>
              <select class="form-control" id="branch-worker">
                @foreach(\App\Group::where('type', 2)->get() as $group)
                  <option value="{{ $group->code}}">{{ $group->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="branch-address" class="control-label">@lang('branch.address')</label>
              <textarea cols="25" id="branch-address">
              </textarea>
            </div>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="branch-view-map" class="map">
            </div>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="branch-save">
                <i class="fa fa-save"></i> @lang('branch.save')
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="branch-utilities">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="branch-utilities-branch" class="control-label">@lang('branch.branch')</label>
              <select class="form-control" id="branch-utilities-branch">
                @foreach(\App\Branch::all() as $branch)
                  <option value="{{ $branch->code }}">{{ $branch->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="branch-utilities-search">
                <i class="fa fa-search"></i> @lang('branch.search')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="branch-utilities-create">
                <i class="fa fa-plus"></i> @lang('branch.create_utility')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('branch.provider')</th>
                      <th>@lang('branch.name')</th>
                      <th>@lang('branch.interval')</th>
                      <th>@lang('branch.average')</th>
                      <th>@lang('branch.taxes')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
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
