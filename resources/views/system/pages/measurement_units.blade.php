<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<section class="content-header">
  <h1>
    @lang('measurement_units.title')
    <small class="crumb">@lang('measurement_units.view_units')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-list"></i> @lang('measurement_units.title')</li>
    <li class="active crumb">@lang('measurement_units.view_units')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#measurement-units-generate" id="measurement-units-generate-tab" data-toggle="tab" aria-expanded="true">@lang('measurement_units.view_units')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="measurement-units-generate">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="measurement-units-units" class="control-label">@lang('measurement_units.units')</label>
              <select class="form-control" id="measurement-units-units">
                @foreach(\App\MeasurementUnit::where('code', '!=', 0)->get() as $units)
                  <option value="{{ $units->code }}">{{ $units->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="measurement-units-create">
                <i class="fa fa-plus"></i> @lang('measurement_units.create')
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
                      <th>@lang('measurement_units.to')</th>
                      <th>@lang('measurement_units.factor')</th>
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
        <div class="row">
          <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
          </div>
          <div class="col-lg-4 col-md-3 col-sm-2">
            <button type="button" class="btn btn-success" id="measurement-units-conversion">
              <i class="fa fa-plus"></i> @lang('measurement_units.create_conversion')
            </button>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
