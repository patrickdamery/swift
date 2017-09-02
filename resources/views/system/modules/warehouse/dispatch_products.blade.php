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
    @lang('dispatch_products.title')
    <small class="crumb">@lang('dispatch_products.dispatch')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-minus"></i> @lang('dispatch_products.title')</li>
    <li class="active crumb">@lang('dispatch_products.dispatch')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-dispatch-products" id="view-dispatch-products-tab" data-toggle="tab" aria-expanded="true">@lang('dispatch_products.dispatch')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-dispatch-products">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="dispatch-products-reason" class="control-label">@lang('dispatch_products.reason')</label>
              <select class="form-control" id="dispatch-products-reason">
                <option value="sale">@lang('dispatch_products.sale')</option>
                <option value="order">@lang('dispatch_products.order')</option>
                <option value="return_repair">@lang('dispatch_products.return_repair')</option>
                <option value="production">@lang('dispatch_products.production')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="dispatch-products-reason-code" class="control-label">@lang('dispatch_products.document_code')</label>
              <input type="text" class="form-control" id="dispatch-products-reason-code">
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="dispatch-products-code" class="control-label">@lang('dispatch_products.code')</label>
              <input type="text" class="form-control" id="dispatch-products-code">
            </div>
          </div>
        </div>
        <div class="row form-inline" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('dispatch_products.code')</th>
                      <th>@lang('dispatch_products.description')</th>
                      <th>@lang('dispatch_products.quantity')</th>
                      <th>@lang('dispatch_products.location')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="dispatch-products-remove">
                <i class="fa fa-minus"></i> @lang('dispatch_products.remove')
              </button>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="dispatch-products-suggest">
                <i class="fa fa-cogs"></i> @lang('dispatch_products.suggest')
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
