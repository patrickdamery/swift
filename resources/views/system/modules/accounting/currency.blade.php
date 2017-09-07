@php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
@endphp
<script>
$(function(){
 $('.daterangepicker-sel').daterangepicker({
        format: 'dd-mm-yyyy'
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

  // Define Feedback Messages.
  swift_language.add_sentence('create_currency_blank_code', {
                              'en': 'Currency Code can\'t be left blank!',
                              'es': 'Codigo de Moneda no puede dejarse en blanco!'
                            });
  swift_language.add_sentence('create_currency_blank_description', {
                              'en': 'Account Description can\'t be left blank!',
                              'es': 'Descripcion de Cuenta no puede dejarse en blanco!'
                            });
  swift_language.add_sentence('create_currency_exchange_error', {
                              'en': 'Exchange Rate can\'t be blank and must be a numeric value!',
                              'es': 'Tasa de Cambio no puede dejarse en blanco y debe ser un valor numerico!'
                            });
  swift_language.add_sentence('create_currency_buy_rate_error', {
                              'en': 'Buy Rate can\'t be blank and must be a numeric value!',
                              'es': 'Tasa de Compra no puede dejarse en blanco y debe ser un valor numerico!'
                            });
  swift_utils.register_ajax_fail();
// Check if we have already loaded the accounts JS file.
if(typeof currency_js === 'undefined') {
  $.getScript('{{ URL::to('/') }}/js/swift/accounting/currency.js')
}
</script>
@include('system.components.accounting.create_currency')
<section class="content-header">
  <h1>
    @lang('accounting/currency.title')
    <small class="crumb">@lang('accounting/currency.view_currency')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-money"></i> @lang('accounting/currency.title')</li>
    <li class="active crumb">@lang('accounting/currency.view_currency')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#currency-view-currency" id="currency-view-currency-tab" data-toggle="tab" aria-expanded="true">@lang('accounting/currency.view_currency')</a></li>
      <li class=""><a href="#currency-view-time-variation" id="currency-view-time-variation-tab" data-toggle="tab" aria-expanded="false">@lang('accounting/currency.view_time_exchange')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="currency-view-currency">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="currency-main" class="control-label">@lang('accounting/currency.main')</label>
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
                <i class="fa fa-save"></i> @lang('accounting/currency.save_main')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-currency">
                <i class="fa fa-plus"></i> @lang('accounting/currency.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
            <div class="box" id="currency-table">
              @include('system.components.accounting.currency_table',
                [
                  'offset' => 1,
                ]
              )
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="currency-view-time-variation">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
              <label for="currency-variation-date-range" class="control-label">@lang('accounting/currency.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="currency-variation-date-range">
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="currency-main" class="control-label">@lang('accounting/currency.currency')</label>
              <select class="form-control" id="currency-variation-main">
                @foreach(\App\Currency::where('code', '!=', '0')->get() as $currency)
                  <option value="{{ $currency->code }}">
                    {{ $currency->description }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="currency-variation-search">
                <i class="fa fa-search"></i> @lang('accounting/currency.search')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
            <div class="box" id="currency-variation-table">
              @include('system.components.accounting.currency_variation_table',
                [
                  'code' => '',
                  'date_range' => array(
                    date('Y-m-d').' 00:00:00',
                    date('Y-m-d').' 23:59:59',
                  ),
                  'offset' => 1,
                ]
              )
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
