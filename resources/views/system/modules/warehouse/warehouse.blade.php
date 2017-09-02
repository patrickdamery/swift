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
   swift_menu.get_language().add_sentence('view-warehouse-tab', {
                                         'en': 'View Warehouse',
                                         'es': 'Ver Bodegas',
                                       });
   swift_menu.get_language().add_sentence('view-locations-tab', {
                                         'en': 'View Locations',
                                         'es': 'Ver Ubicaciones',
                                       });

 swift_event_tracker.register_swift_event('#view-warehouse-tab', 'click', swift_menu, 'select_submenu_option');
 $(document).on('click', '#view-warehouse-tab', function(e) {
   swift_event_tracker.fire_event(e, '#view-warehouse-tab');
 });

 swift_event_tracker.register_swift_event('#view-locations-tab', 'click', swift_menu, 'select_submenu_option');
 $(document).on('click', '#view-locations-tab', function(e) {
   swift_event_tracker.fire_event(e, '#view-locations-tab');
 });

</script>
<script>
  function initMap() {
    var uluru = {lat: -25.363, lng: 131.044};
    var map = new google.maps.Map(document.getElementById('providers-view-map'), {
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
    @lang('warehouse.title')
    <small class="crumb">@lang('warehouse.view_warehouse')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-building"></i> @lang('warehouse.title')</li>
    <li class="active crumb">@lang('warehouse.view_warehouse')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-warehouse" id="view-warehouse-tab" data-toggle="tab" aria-expanded="true">@lang('warehouse.view_warehouse')</a></li>
      <li><a href="#view-locations" id="view-locations-tab" data-toggle="tab" aria-expanded="true">@lang('warehouse.locations')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-warehouse">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="warehouse-warehouse" class="control-label">@lang('warehouse.warehouses')</label>
              <select class="form-control" id="warehouse-warehouse">
                @foreach(\App\Warehouse::where('code', '!=', 0)->get() as $warehouse)
                  <option value="{{ $warehouse->code }}">{{ $warehouse->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space md-top-space lg-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="warehouse-create">
                <i class="fa fa-plus"></i> @lang('warehouse.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="warehouse-used" class="control-label">@lang('warehouse.used')</label>
              <input type="text" class="form-control" id="warehouse-used">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="warehouse-free" class="control-label">@lang('warehouse.free')</label>
              <input type="text" class="form-control" id="warehouse-free">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="warehouse-total" class="control-label">@lang('warehouse.total')</label>
              <input type="text" class="form-control" id="warehouse-total">
            </div>
          </div>
        </div>
        <div class="row form-inline  lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="warehouse-name" class="control-label">@lang('warehouse.name')</label>
              <input type="text" class="form-control" id="warehouse-name">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="warehouse-address" class="control-label">@lang('warehouse.address')</label>
              <textarea col="25" row="25" class="form-control" id="warehouse-address">
              </textarea>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="warehouse-branch" class="control-label">@lang('warehouse.branch')</label>
              <select class="form-control" id="warehouse-branch">
                @foreach(\App\Branch::all() as $branch)
                  <option value="{{ $branch->code }}">{{ $branch->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="providers-view-map" class="map">
            </div>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="warehouse-save">
                <i class="fa fa-save"></i> @lang('warehouse.save')
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="view-locations">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="locations-code" class="control-label">@lang('warehouse.code')</label>
              <input type="text" class="form-control" id="locations-code">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="locations-provider" class="control-label">@lang('warehouse.provider')</label>
              <select class="form-control" id="locations-provider">
                @foreach(\App\Provider::all() as $provider)
                  <option value="{{ $provider->code }}">{{ $provider->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space md-top-space lg-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="locations-create">
                <i class="fa fa-plus"></i> @lang('warehouse.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="locations-branch" class="control-label">@lang('warehouse.branch')</label>
              <select class="form-control" id="locations-branch">
                @foreach(\App\Branch::all() as $branch)
                  <option value="{{ $branch->code }}">{{ $branch->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="locations-warehouse" class="control-label">@lang('warehouse.warehouse')</label>
              <select class="form-control" id="locations-warehouse">
                @foreach(\App\Warehouse::all() as $warehouse)
                  <option value="{{ $warehouse->code }}">{{ $warehouse->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="locations-search">
                <i class="fa fa-search"></i> @lang('warehouse.search')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">@lang('warehouse.locations')</h3>
              </div>
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('warehouse.warehouse')</th>
                      <th>@lang('warehouse.description')</th>
                      <th>@lang('warehouse.quantity')</th>
                      <th>@lang('warehouse.stand')</th>
                      <th>@lang('warehouse.row')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="locations-print">
                <i class="fa fa-print"></i> @lang('warehouse.print')
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
