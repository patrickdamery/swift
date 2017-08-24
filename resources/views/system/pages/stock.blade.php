<script>
  swift_menu.new_submenu();
  swift_menu.get_language().add_sentence('stocktake-tab', {
                                        'en': 'Stocktake',
                                        'es': 'Toma de Inventario'
                                      });
  swift_menu.get_language().add_sentence('stocktake-report-tab', {
                                      'en': 'Stocktake Reports',
                                      'es': 'Reportes de Toma de Inventario'
                                    });

swift_event_tracker.register_swift_event('#stocktake-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#stocktake-tab', function(e) {
  swift_event_tracker.fire_event(e, '#stocktake-tab');
});

swift_event_tracker.register_swift_event('#stocktake-report-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#stocktake-report-tab', function(e) {
  swift_event_tracker.fire_event(e, '#stocktake-report-tab');
});

</script>

<section class="content-header">
  <h1>
    @lang('stock.title')
    <small class="crumb">@lang('stock.stocktake')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-list"></i> @lang('stock.title')</li>
    <li class="active crumb">@lang('stock.stocktake')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#stocktake" id="stocktake-tab" data-toggle="tab" aria-expanded="true">@lang('stock.stocktake')</a></li>
      <li class=""><a href="#stocktake-report" id="stocktake-report-tab" data-toggle="tab" aria-expanded="false">@lang('stock.stocktake_report')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="stocktake">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="stocktake-code" class="control-label">@lang('stock.code')</label>
              <input type="text" class="form-control" id="stocktake-code">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="stocktake-branch" class="control-label">@lang('stock.branches')</label>
              <select class="form-control" id="stocktake-branch">
                @foreach(\App\Branch::all() as $branch)
                  <option value="{{ $branch->code }}">{{ $branch->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="stocktake-provider" class="control-label">@lang('stock.provider')</label>
              <select class="form-control" id="stocktake-provider" multiple>
                @foreach(\App\Provider::all() as $provider)
                  <option value="{{ $provider->code }}">{{ $provider->name }}</option>
                @endforeach
              </select>
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
                      <th>@lang('stock.code')</th>
                      <th>@lang('stock.description')</th>
                      <th>@lang('stock.in_system')</th>
                      <th>@lang('stock.counted')</th>
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
              <button type="button" class="btn btn-info" id="stocktake-print">
                <i class="fa fa-print"></i> @lang('stock.print')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="stocktake-revise">
                <i class="fa fa-edit"></i> @lang('stock.revise')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="stocktake-send">
                <i class="fa fa-send"></i> @lang('stock.send')
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="stocktake-report">
        <div class="row form-inline">
          <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="stocktake-report-date-range" class="control-label">@lang('stock.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="stocktake-report-date-range">
              </div>
            </div>
          </div>
          <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="stocktake-report-search">
                <i class="fa fa-search"></i> @lang('stock.search')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="stocktake-reports" class="control-label">@lang('stock.reports')</label>
              <select class="form-control" id="stocktake-reports">
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="stocktake-warehouse" class="control-label">@lang('stock.warehouse')</label>
              <input type="text" class="form-control" id="stocktake-warehouse">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="stocktake-submitted" class="control-label">@lang('stock.submitted')</label>
              <input type="text" class="form-control" id="stocktake-submitted">
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
                      <th>@lang('stock.code')</th>
                      <th>@lang('stock.description')</th>
                      <th>@lang('stock.in_system')</th>
                      <th>@lang('stock.counted')</th>
                      <th>@lang('stock.difference')</th>
                      <th>@lang('stock.state')</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-11 col-md-11 col-sm-12 col-xs-12">
            <div class="form-group pull-right">
              <button type="button" class="btn btn-success" id="stocktake-report-save">
                <i class="fa fa-save"></i> @lang('stock.save')
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
