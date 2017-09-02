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
    @lang('suggestions.title')
    <small class="crumb">@lang('suggestions.make_suggestion')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-sitemap"></i> @lang('suggestions.title')</li>
    <li class="active crumb">@lang('suggestions.make_suggestion')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#suggestions-generate" id="suggestions-generate-tab" data-toggle="tab" aria-expanded="true">@lang('suggestions.make_suggestion')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="suggestions-generate">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="suggestions-generate-providers" class="control-label">@lang('suggestions.provider')</label>
              <select class="form-control" id="suggestions-generate-providers">
                @foreach(\App\Provider::where('code', '!=', 0)->get() as $provider)
                  <option value="{{ $provider->code }}">{{ $provider->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="suggestions-generate-range" class="control-label">@lang('suggestions.range')</label>
              <input type="number" class="form-control" id="suggestions-generate-range">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="suggestions-generate-term" class="control-label">@lang('suggestions.term')</label>
              <input type="number" class="form-control" id="suggestions-generate-term">
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="suggestions-generate-suggest">
                <i class="fa fa-cogs"></i> @lang('suggestions.suggest')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="suggestions-generate-auto" class="control-label">@lang('suggestions.auto')</label>
              <select class="form-control" id="suggestions-generate-auto">
                <option value="yes">@lang('suggestions.yes')</option>
                <option value="no">@lang('suggestions.no')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="suggestions-generate-save">
                <i class="fa fa-save"></i> @lang('suggestions.save')
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
                      <th>@lang('suggestions.code')</th>
                      <th>@lang('suggestions.description')</th>
                      <th>@lang('suggestions.cost')</th>
                      <th>@lang('suggestions.existence')</th>
                      <th>@lang('suggestions.order')</th>
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
          <div class="col-lg-4 col-md-3 col-sm-2">
            <button type="button" class="btn btn-info" id="suggestions-generate-print">
              <i class="fa fa-print"></i> @lang('suggestions.print')
            </button>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
