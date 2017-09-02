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
<section class="content-header">
  <h1>
    @lang('purchases.title')
    <small class="crumb">@lang('purchases.view_purchases')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-shopping-cart"></i> @lang('purchases.title')</li>
    <li class="active crumb">@lang('purchases.view_purchases')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#purchases-view-purchases" id="purchases-view-purchases-tab" data-toggle="tab" aria-expanded="true">@lang('purchases.view_purchases')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="purchases-view-purchases">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="purchases-date-range" class="control-label">@lang('purchases.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="purchases-date-range">
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="purchases-debt-client" class="control-label">@lang('purchases.provider')</label>
              <select class="form-control" id="providers-providers">
                @foreach(\App\Provider::where('code', '!=', 0)->get() as $provider)
                  <option value="{{ $provider->code }}">{{ $provider->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="purchases-debt-search">
                <i class="fa fa-search"></i> @lang('purchases.search')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="purchases-debt-print">
                <i class="fa fa-print"></i> @lang('purchases.print')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">@lang('purchases.purchases')</h3>
              </div>
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('purchases.date')</th>
                      <th>@lang('purchases.bill')</th>
                      <th>@lang('purchases.total')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">@lang('purchases.bill')</h3>
              </div>
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('purchases.code')</th>
                      <th>@lang('purchases.description')</th>
                      <th>@lang('purchases.quantity')</th>
                      <th>@lang('purchases.price')</th>
                      <th>@lang('purchases.discount')</th>
                      <th>@lang('purchases.total')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-3 col-sm-2 hidden-xs">
          </div>
          <div class="col-lg-8 col-md-9 col-sm-10 col-xs-12">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 hidden-xs">

              </div>
              <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 form-inline">
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="sales-subtotal" class="control-label">@lang('purchases.subtotal')</label>
                      <input type="text" class="form-control" id="sales-subtotal">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="sales-discount" class="control-label">@lang('purchases.discount')</label>
                      <input type="text" class="form-control" id="sales-discount">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="sales-tax" class="control-label">@lang('purchases.tax')</label>
                      <input type="text" class="form-control" id="sales-tax">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="sales-total" class="control-label">@lang('purchases.total')</label>
                      <input type="text" class="form-control" id="sales-total">
                    </div>
                  </div>
                </div>
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
