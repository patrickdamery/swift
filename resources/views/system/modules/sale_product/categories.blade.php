<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<section class="content-header">
  <h1>
    @lang('categories.title')
    <small class="crumb">@lang('categories.view_categories')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-list"></i> @lang('categories.title')</li>
    <li class="active crumb">@lang('categories.view_categories')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-categories" id="view-categories-tab" data-toggle="tab" aria-expanded="true">@lang('categories.view_categories')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-categories">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="categories-code" class="control-label">@lang('categories.code')</label>
              <input type="text" class="form-control" id="categories-code">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="categories-search">
                <i class="fa fa-search"></i> @lang('categories.search')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="categories-create">
                <i class="fa fa-plus"></i> @lang('categories.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
          </div>
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="padding-top:15px;">
            <div class="box">

            </div>
          </div>
          <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
