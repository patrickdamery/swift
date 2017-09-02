<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<script>
  function initMap() {
    var uluru = {lat: -25.363, lng: 131.044};
    var map = new google.maps.Map(document.getElementById('vehicles-view-map'), {
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
    @lang('vehicles.title')
    <small class="crumb">@lang('vehicles.view_vehicles')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-car"></i> @lang('vehicles.title')</li>
    <li class="active crumb">@lang('vehicles.view_vehicles')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-vehicles" id="view-vehicles-tab" data-toggle="tab" aria-expanded="true">@lang('vehicles.view_vehicles')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-vehicles">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="vehicles-vehicle" class="control-label">@lang('vehicles.vehicle')</label>
              <select class="form-control" id="vehicles-vehicle">
                @foreach(\App\Vehicle::where('code', '!=', 0)->get() as $vehicles)
                  <option value="{{ $vehicles->code }}">{{ $vehicles->make }} {{ $vehicles->model }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="vehicles-create">
                <i class="fa fa-plus"></i> @lang('vehicles.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="vehicles-view-map" class="map">
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
