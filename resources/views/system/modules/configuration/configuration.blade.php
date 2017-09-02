<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<section class="content-header">
  <h1>
    @lang('configuration.title')
    <small class="crumb">@lang('configuration.view_config')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cogs"></i> @lang('configuration.title')</li>
    <li class="active crumb">@lang('configuration.view_config')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-configuration" id="configuration-tab" data-toggle="tab" aria-expanded="true">@lang('configuration.view_config')</a></li>
      <li><a href="#alonica-configuration" id="alonica-configuration-tab" data-toggle="tab" aria-expanded="true">@lang('configuration.modules_plugins')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-configuration">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="configuration-name" class="control-label">@lang('configuration.name')</label>
              <input type="text" class="form-control" id="configuration-name">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="configuration-short-name" class="control-label">@lang('configuration.short_name')</label>
              <input type="text" class="form-control" id="configuration-short-name">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="configuration-ruc" class="control-label">@lang('configuration.ruc')</label>
              <input type="text" class="form-control" id="configuration-ruc">
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="configuration-auth-dgi" class="control-label">@lang('configuration.auth_dgi')</label>
              <input type="text" class="form-control" id="configuration-auth-dgi">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="configuration-currency" class="control-label">@lang('configuration.currency')</label>
              <select class="form-control" id="configuration-currency">
                @foreach(\App\Currency::all() as $currency)
                  <option value="{{ $currency->code }}">{{ $currency->description }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="configuration-withdraw-option" class="control-label">@lang('configuration.withdraw_option')</label>
              <select class="form-control" id="configuration-withdraw-option">
                <option value="sale">@lang('configuration.withdraw_on_sale')</option>
                <option value="dispatch">@lang('configuration.withdraw_on_dispatch')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="configuration-quote-life" class="control-label">@lang('configuration.quote_life')</label>
              <input type="text" class="form-control" id="configuration-quote-life">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="configuration-reservation-life" class="control-label">@lang('configuration.reservation_life')</label>
              <input type="text" class="form-control" id="configuration-reservation-life">
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="configuration-points-percentage" class="control-label">@lang('configuration.points_percentage')</label>
              <input type="text" class="form-control" id="configuration-points-percentage">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="configuration-points-enable" class="control-label">@lang('configuration.points_enabled')</label>
              <select class="form-control" id="configuration-points-enable">
                <option value="yes">@lang('configuration.yes')</option>
                <option value="no">@lang('configuration.no')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="configuration-save">
                <i class="fa fa-save"></i> @lang('configuration.save')
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane active" id="alonica-configuration">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row form-inline">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="alonica-configuration-search" class="control-label">@lang('configuration.search')</label>
                  <input type="text" class="form-control" id="alonica-configuration-search">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">@lang('configuration.modules')</h3>
                  </div>
                  <div class="box-body table-responsive no-padding swift-table">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>@lang('configuration.module')</th>
                          <th>@lang('configuration.price')</th>
                          <th>@lang('configuration.state')</th>
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
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row form-inline">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="alonica-configuration-search" class="control-label">@lang('configuration.search')</label>
                  <input type="text" class="form-control" id="alonica-configuration-search">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="box">
                  <div class="box-header">
                    <h3 class="box-title">@lang('configuration.plugins')</h3>
                  </div>
                  <div class="box-body table-responsive no-padding swift-table">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>@lang('configuration.plugins')</th>
                          <th>@lang('configuration.price')</th>
                          <th>@lang('configuration.state')</th>
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
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="alonica-configuration-version" class="control-label">@lang('configuration.version')</label>
              <input type="text" class="form-control" id="alonica-configuration-version" disabled>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="alonica-configuration-recent-version" class="control-label">@lang('configuration.recent_version')</label>
              <input class="form-control" id="alonica-configuration-recent-version" disabled>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="alonica-configuration-api-key" class="control-label">@lang('configuration.api_key')</label>
              <input type="text" class="form-control" id="alonica-configuration-api-key">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="plugin-configuration-generate">
                <i class="fa fa-cogs"></i> @lang('configuration.generate')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="alonica-configuration-save">
                <i class="fa fa-save"></i> @lang('configuration.save')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="alonica-configuration-update">
                <i class="fa fa-cloud-download"></i> @lang('configuration.update')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="alonica-configuration-backup">
                <i class="fa fa-database"></i> @lang('configuration.backup')
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
