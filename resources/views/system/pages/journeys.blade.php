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
</script>
<script>
  function initMap() {
    var uluru = {lat: -25.363, lng: 131.044};
    var map = new google.maps.Map(document.getElementById('journeys-view-map'), {
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
    @lang('journeys.title')
    <small class="crumb">@lang('journeys.view_journeys')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-map"></i> @lang('journeys.title')</li>
    <li class="active crumb">@lang('journeys.view_journeys')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-journeys" id="view-journeys-tab" data-toggle="tab" aria-expanded="true">@lang('journeys.view_journeys')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-journeys">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journeys-date-range" class="control-label">@lang('journeys.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="journeys-date-range">
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journeys-vehicle" class="control-label">@lang('journeys.vehicle')</label>
              <select class="form-control" id="journeys-vehicle">
                @foreach(\App\Vehicle::where('code', '!=', 0)->get() as $journeys)
                  <option value="{{ $journeys->code }}">{{ $journeys->make }} {{ $journeys->model }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="journeys-search">
                <i class="fa fa-search"></i> @lang('journeys.search')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="journeys-create">
                <i class="fa fa-plus"></i> @lang('journeys.create')
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
                      <th>@lang('journeys.date')</th>
                      <th>@lang('journeys.driver')</th>
                      <th>@lang('journeys.km')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div id="journeys-view-map" class="map">
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
