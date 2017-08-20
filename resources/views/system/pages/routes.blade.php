<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
 <script>
 $(function(){
  $('.daterangepicker-sel').daterangepicker({
         format: 'mm-dd-yyyy'
       });
   });
</script>
<script>
  function initMap() {
    var uluru = {lat: -25.363, lng: 131.044};
    var map = new google.maps.Map(document.getElementById('routes-view-map'), {
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
    @lang('routes.title')
    <small class="crumb">@lang('routes.view_routes')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-map-signs"></i> @lang('routes.title')</li>
    <li class="active crumb">@lang('routes.view_routes')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-routes" id="view-routes-tab" data-toggle="tab" aria-expanded="true">@lang('routes.view_routes')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-routes">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="routes-vehicle" class="control-label">@lang('routes.vehicle')</label>
              <select class="form-control" id="routes-vehicle">
                @foreach(\App\Vehicle::where('code', '!=', 0)->get() as $routes)
                  <option value="{{ $routes->code }}">{{ $routes->make }} {{ $routes->model }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="routes-vehicle" class="control-label">@lang('routes.day')</label>
              <select class="form-control" id="routes-vehicle">
                <option value="mon">@lang('routes.monday')</option>
                <option value="tue">@lang('routes.tuesday')</option>
                <option value="wed">@lang('routes.wednesday')</option>
                <option value="thu">@lang('routes.thursday')</option>
                <option value="fri">@lang('routes.friday')</option>
                <option value="sat">@lang('routes.saturday')</option>
                <option value="sun">@lang('routes.sunday')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="routes-search">
                <i class="fa fa-search"></i> @lang('routes.search')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="routes-create">
                <i class="fa fa-plus"></i> @lang('routes.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('routes.description')</th>
                      <th>@lang('routes.address')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div id="routes-view-map" class="map">
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
