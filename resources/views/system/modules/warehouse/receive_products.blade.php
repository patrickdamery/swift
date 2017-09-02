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
    @lang('receive_products.title')
    <small class="crumb">@lang('receive_products.receive')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-plus"></i> @lang('receive_products.title')</li>
    <li class="active crumb">@lang('receive_products.receive')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#view-receive-products" id="view-receive-products-tab" data-toggle="tab" aria-expanded="true">@lang('receive_products.receive')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="view-receive-products">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="receive-products-reason" class="control-label">@lang('receive_products.reason')</label>
              <select class="form-control" id="receive-products-reason">
                <option value="purchase">@lang('receive_products.purchase')</option>
                <option value="return">@lang('receive_products.return')</option>
                <option value="reparacion">@lang('receive_products.repair')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="receive-products-reason-code" class="control-label">@lang('receive_products.document_code')</label>
              <input type="text" class="form-control" id="receive-products-reason-code">
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="receive-products-code" class="control-label">@lang('receive_products.code')</label>
              <input type="text" class="form-control" id="receive-products-code">
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
                      <th>@lang('receive_products.code')</th>
                      <th>@lang('receive_products.description')</th>
                      <th>@lang('receive_products.quantity')</th>
                      <th>@lang('receive_products.location')</th>
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
              <button type="button" class="btn btn-info" id="receive-products-add">
                <i class="fa fa-plus"></i> @lang('receive_products.add')
              </button>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="receive-products-suggest">
                <i class="fa fa-cogs"></i> @lang('receive_products.suggest')
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
