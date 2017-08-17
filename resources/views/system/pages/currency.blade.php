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
  swift_menu.new_submenu();
  swift_menu.get_language().add_sentence('currency-view-currency-tab', {
                                        'en': 'View Currencies',
                                        'es': 'Ver Monedas'
                                      });
  swift_menu.get_language().add_sentence('currency-view-time-variation-tab', {
                                      'en': 'View Exchange Rate Variation',
                                      'es': 'Ver Variacion de Tasa de Cambio'
                                    });

swift_event_tracker.register_swift_event('#currency-view-currency-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#currency-view-currency-tab', function(e) {
  swift_event_tracker.fire_event(e, '#currency-view-currency-tab');
});

swift_event_tracker.register_swift_event('#currency-view-time-variation-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#currency-view-time-variation-tab', function(e) {
  swift_event_tracker.fire_event(e, '#currency-view-time-variation-tab');
});

</script>

<section class="content-header">
  <h1>
    @lang('currency.title')
    <small class="crumb">@lang('currency.view_currency')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-money"></i> @lang('currency.title')</li>
    <li class="active crumb">@lang('currency.view_currency')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#currency-view-currency" id="currency-view-currency-tab" data-toggle="tab" aria-expanded="true">@lang('currency.view_currency')</a></li>
      <li class=""><a href="#currency-view-time-variation" id="currency-view-time-variation-tab" data-toggle="tab" aria-expanded="false">@lang('currency.view_time_exchange')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="currency-view-currency">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="currency-main" class="control-label">@lang('currency.main')</label>
              <select class="form-control" id="currency-main">
                @foreach(\App\Currency::where('code', '!=', '0')->get() as $currency)
                  <option value="{{ $currency->code }}" {{ ($currency->code == $config->local_currency_code) ? 'selected' : '' }}>
                    {{ $currency->description }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="currency-save-main">
                <i class="fa fa-save"></i> @lang('currency.save_main')
              </button>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="currency-create">
                <i class="fa fa-plus"></i> @lang('currency.create')
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
                      <th>@lang('currency.code')</th>
                      <th>@lang('currency.description')</th>
                      <th>@lang('currency.exchange_rate')</th>
                      <th>@lang('currency.buy_rate')</th>
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
      <div class="tab-pane" id="currency-view-time-variation">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
            <div class="form-group">
              <label for="currency-date-range" class="control-label">@lang('currency.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="currency-date-range">
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="currency-main" class="control-label">@lang('currency.currency')</label>
              <select class="form-control" id="currency-main">
                @foreach(\App\Currency::where('code', '!=', '0')->get() as $currency)
                  <option value="{{ $currency->code }}">
                    {{ $currency->description }}
                  </option>
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
                      <th>@lang('currency.date')</th>
                      <th>@lang('currency.exchange_rate')</th>
                      <th>@lang('currency.buy_rate')</th>
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
