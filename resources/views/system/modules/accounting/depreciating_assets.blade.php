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
  $('.datepicker-sel').datepicker({
         format: 'dd-mm-yyyy'
       });
  });
  swift_menu.new_submenu();
  swift_menu.get_language().add_sentence('depreciating-assets-view-accounts-tab', {
                                        'en': 'View Assets',
                                        'es': 'Ver Activos'
                                      });

  // Define Feedback Messages.
  swift_language.add_sentence('create_account_blank_code', {
                              'en': 'Bank Account Code can\'t be left blank!',
                              'es': 'Codigo de Cuenta de Banco no puede dejarse en blanco!'
                            });
  swift_utils.register_ajax_fail();

// Check if we have already loaded the Depreciating Assets JS file.
if(typeof depreciating_assets_js === 'undefined') {
  $.getScript('{{ URL::to('/') }}/js/swift/accounting/depreciating_assets.js');
}
</script>
@include('system.components.accounting.create_depreciating_asset')
<section class="content-header">
  <h1>
    @lang('accounting/depreciating_assets.title')
    <small class="crumb">@lang('accounting/depreciating_assets.view_assets')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-car"></i> @lang('accounting/depreciating_assets.title')</li>
    <li class="active crumb">@lang('accounting/depreciating_assets.view_assets')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#depreciating-assets-view-accounts" id="depreciating-assets-view-tab" data-toggle="tab" aria-expanded="true">@lang('accounting/depreciating_assets.view_assets')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="depreciating-assets-view-accounts">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
              <label for="depreciating-assets-code" class="control-label">@lang('accounting/depreciating_assets.code')</label>
              <select class="form-control" id="depreciating-assets-code">
                @foreach(\App\Asset::all() as $asset)
                  <option value="{{ $asset->code }}">{{ $asset->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="depreciating-assets-search">
                <i class="fa fa-search"></i> @lang('accounting/depreciating_assets.search')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
            <div class="form-group">
              <button type="button" id="create-depreciating-asset-button" class="btn btn-info"  data-toggle="modal" data-target="#create-depreciating-assets">
                <i class="fa fa-plus"></i> @lang('accounting/depreciating_assets.create_account')
              </button>
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="depreciating-assets-name" class="control-label">@lang('accounting/depreciating_assets.name')</label>
              <input id="depreciating-assets-name" class="form-control">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="depreciating-assets-description" class="control-label">@lang('accounting/depreciating_assets.description')</label>
              <textarea id="depreciating-assets-description" class="form-control"></textarea>
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="depreciating-assets-depreciation" class="control-label">@lang('accounting/depreciating_assets.depreciation')</label>
              <input id="depreciating-assets-depreciation" class="form-control">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="depreciating-assets-asset-account" class="control-label">@lang('accounting/depreciating_assets.asset_account')</label>
              <input id="depreciating-assets-asset-account" class="form-control">
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="depreciating-assets-depreciation-expense-account" class="control-label">@lang('accounting/depreciating_assets.depreciation_expense_account')</label>
              <input id="depreciating-assets-depreciation-expense-account" class="form-control">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="depreciating-assets-depreciation-account" class="control-label">@lang('accounting/depreciating_assets.accumulated_depreciation_account')</label>
              <input id="depreciating-assets-depreciation-account" class="form-control">
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="depreciating-assets-save">
                <i class="fa fa-save"></i> @lang('accounting/depreciating_assets.save')
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
