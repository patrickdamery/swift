<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
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
    @lang('providers.title')
    <small class="crumb">@lang('providers.view_providers')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-industry"></i> @lang('providers.title')</li>
    <li class="active crumb">@lang('providers.view_providers')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-providers" id="view-provider-tab" data-toggle="tab" aria-expanded="true">@lang('providers.view_providers')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-providers">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="providers-providers" class="control-label">@lang('providers.provider')</label>
              <select class="form-control" id="providers-providers">
                @foreach(\App\Provider::where('code', '!=', 0)->get() as $provider)
                  <option value="{{ $provider->code }}">{{ $provider->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="providers-create">
                <i class="fa fa-plus"></i> @lang('providers.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="providers-name" class="control-label">@lang('providers.name')</label>
              <input type="text" class="form-control" id="providers-name">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="providers-phone" class="control-label">@lang('providers.phone')</label>
              <input type="text" class="form-control" id="providers-phone" data-inputmask="mask": "9999-9999" data-mask>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="providers-email" class="control-label">@lang('providers.email')</label>
              <input type="email" class="form-control" id="providers-email">
            </div>
          </div>
        </div>
        <div class="row form-inline  lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="providers-ruc" class="control-label">@lang('providers.ruc')</label>
              <input type="text" class="form-control" id="providers-ruc">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="providers-tax-type" class="control-label">@lang('providers.contributor_type')</label>
              <select class="form-control" id="providers-tax-type">
                <option value="1">@lang('providers.small_contributor')</option>
                <option value="2">@lang('providers.collects_VAT')</option>
                <option value="3">@lang('providers.big_contributor')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="providers-type" class="control-label">@lang('providers.type')</label>
              <select class="form-control" id="providers-type">
                <option value="1">@lang('providers.product_provider')</option>
                <option value="2">@lang('providers.service_provider')</option>
                <option value="3">@lang('providers.product_service')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline  lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="providers-offers-credit" class="control-label">@lang('providers.offers_credit')</label>
              <select class="form-control" id="providers-offers-credit">
                <option value="1">@lang('providers.yes')</option>
                <option value="0">@lang('providers.no')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="providers-credit-limit" class="control-label">@lang('providers.credit_limit')</label>
              <input type="text" class="form-control" id="providers-credit-limit">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="providers-credit-days" class="control-label">@lang('providers.days')</label>
              <input type="text" class="form-control" id="providers-credit-days">
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="padding-top:15px;">
            <div class="form-group">
              <label for="providers-delivers" class="control-label">@lang('providers.delivers')</label>
              <select class="form-control" id="providers-delivers">
                <option value="1">@lang('providers.yes')</option>
                <option value="0">@lang('providers.no')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="padding-top:15px;">
            <div class="form-group">
              <label for="providers-address" class="control-label">@lang('providers.address')</label>
              <textarea col="25" row="25" class="form-control" id="providers-address">
              </textarea>
            </div>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="providers-view-map" class="map">
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
