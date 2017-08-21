<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
 <script>
 $(function(){
  $('.datepicker-sel').datepicker({
        format: 'dd-mm-yyyy'
      });
  });
</script>
<section class="content-header">
  <h1>
    @lang('local_purchases.title')
    <small class="crumb">@lang('local_purchases.view_purchases')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-shopping-cart"></i> @lang('local_purchases.title')</li>
    <li class="active crumb">@lang('local_purchases.view_purchases')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#local-purchases-add-purchases" id="local-purchases-add-purchases-tab" data-toggle="tab" aria-expanded="true">@lang('purchases.view_purchases')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="local-purchases-add-purchases">
        <div class="row form-inline">
          <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
            <div class="form-group pull-right">
              <label for="local-purchases-date" class="control-label">@lang('local_purchases.date')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control datepicker-sel" id="local-purchases-date" value="{{ date('d-m-Y') }}">
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="local-purchases-providers" class="control-label">@lang('local_purchases.provider')</label>
              <select class="form-control" id="local-purchases-providers">
                @foreach(\App\Provider::where('code', '!=', 0)->get() as $provider)
                  <option value="{{ $provider->code }}">{{ $provider->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="local-purchases-bill" class="control-label">@lang('local_purchases.bill')</label>
              <input type="text" class="form-control" id="local-purchases-bill">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <select class="form-control" id="local-purchases-type">
                <option value="1">@lang('local_purchases.product_provider')</option>
                <option value="2">@lang('local_purchases.service_provider')</option>
                <option value="3">@lang('local_purchases.product_service')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="local-purchases-code" class="control-label">@lang('local_purchases.code')</label>
              <input type="text" class="form-control" id="local-purchases-code">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="local-purchases-credit" class="control-label">@lang('local_purchases.payment_type')</label>
              <select class="form-control" id="local-purchases-credit">
                <option value="credit">@lang('local_purchases.credit')</option>
                <option value="cash">@lang('local_purchases.cash')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="local-purchases-pay">
                <i class="fa fa-money"></i> @lang('local_purchases.pay_bill')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('local_purchases.code')</th>
                      <th>@lang('local_purchases.description')</th>
                      <th>@lang('local_purchases.quantity')</th>
                      <th>@lang('local_purchases.cost')</th>
                      <th>@lang('local_purchases.discount')</th>
                      <th>@lang('local_purchases.total')</th>
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
            <button type="button" class="btn btn-success" id="local-purchases-input">
              <i class="fa fa-send"></i> @lang('local_purchases.input')
            </button>
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
