<script>
$(function(){
 $('.daterangepicker-sel').daterangepicker({
        format: 'dd-mm-yyyy'
      });
  });
</script>
<section class="content-header">
  <h1>
    @lang('stock_movement.title')
    <small class="crumb">@lang('stock_movement.view_movement')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-list"></i> @lang('stock_movement.title')</li>
    <li class="active crumb">@lang('stock_movement.view_movement')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#stock-movement" id="stock-movement-tab" data-toggle="tab" aria-expanded="true">@lang('stock_movement.view_movement')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="stock-movement">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="stock-movement-date-range" class="control-label">@lang('stock_movement.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="stock-movement-date-range">
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="stock-movement-code" class="control-label">@lang('stock_movement.code')</label>
              <input type="text" class="form-control" id="stock-movement-code">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="stock-movement-warehouse" class="control-label">@lang('stock_movement.warehouse')</label>
              <select class="form-control" id="stock-movement-warehouse" multiple>
                @foreach(\App\Warehouse::all() as $warehouse)
                  <option value="{{ $warehouse->code }}">{{ $warehouse->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="stock-movement-search">
                <i class="fa fa-search"></i> @lang('stock_movement.search')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('stock_movement.date')</th>
                      <th>@lang('stock_movement.warehouse')</th>
                      <th>@lang('stock_movement.description')</th>
                      <th>@lang('stock_movement.movement')</th>
                      <th>@lang('stock_movement.before')</th>
                      <th>@lang('stock_movement.after')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="stock-movement-print">
                <i class="fa fa-print"></i> @lang('stock_movement.print')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="stock-movement-download">
                <i class="fa fa-file-excel-o"></i> @lang('stock_movement.download')
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
