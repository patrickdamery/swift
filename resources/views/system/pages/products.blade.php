<script>
  swift_menu.new_submenu();
  swift_menu.get_language().add_sentence('products-view-product-tab', {
                                        'en': 'View Products',
                                        'es': 'Ver Productos'
                                      });
  swift_menu.get_language().add_sentence('products-view-service-tab', {
                                      'en': 'View Services',
                                      'es': 'Ver Servicios'
                                    });
  swift_menu.get_language().add_sentence('products-view-analysis-tab', {
                                      'en': 'View Analysis',
                                      'es': 'Ver Analisis'
                                    });

swift_event_tracker.register_swift_event('#products-view-analysis-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#products-view-analysis-tab', function(e) {
  swift_event_tracker.fire_event(e, '#products-view-analysis-tab');
});

swift_event_tracker.register_swift_event('#products-view-service-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#products-view-service-tab', function(e) {
  swift_event_tracker.fire_event(e, '#products-view-service-tab');
});

swift_event_tracker.register_swift_event('#products-view-product-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#products-view-product-tab', function(e) {
  swift_event_tracker.fire_event(e, '#products-view-product-tab');
});
</script>

<section class="content-header">
  <h1>
    @lang('products.title')
    <small class="crumb">@lang('products.view_product')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cube"></i> @lang('products.title')</li>
    <li class="active crumb">@lang('products.view_product')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#products-view-product" id="products-view-product-tab" data-toggle="tab" aria-expanded="true">@lang('products.view_product')</a></li>
      <li class=""><a href="#products-view-service" id="products-view-service-tab" data-toggle="tab" aria-expanded="false">@lang('products.view_service')</a></li>
      <li class=""><a href="#products-view-analysis" id="products-view-analysis-tab" data-toggle="tab" aria-expanded="false">@lang('products.view_analysis')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="products-view-product">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="products-product-code" class="control-label">@lang('products.product_code')</label>
              <input type="email" class="form-control" id="products-product-code">
            </div>
          </div>
          <div class="col-lg-5 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="products-product-provider" class="control-label">@lang('products.product_provider')</label>
              <select class="form-control" id="products-product-provider">
                <option value="0">@lang('products.all_providers')</option>
                @foreach(\App\Provider::where('code', '!=', '0')->get() as $provider)
                  <option value="{{ $provider->code }}">{{ $provider->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="products-create-product">
                <i class="fa fa-plus"></i> @lang('products.create_product')
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
                      <th>@lang('products.product_table_code')</th>
                      <th>@lang('products.product_table_provider')</th>
                      <th>@lang('products.product_description')</th>
                      <th>@lang('products.product_avg_cost')</th>
                      <th>@lang('products.product_cost')</th>
                      <th>@lang('products.product_price')</th>
                      <th>@lang('products.product_sellable')</th>
                      <th>@lang('products.product_sell_at_base_price')</th>
                      <th>@lang('products.product_base_price')</th>
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
      <div class="tab-pane" id="products-view-service">
        <div class="row form-inline">
          <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="products-service-code" class="control-label">@lang('products.service_code')</label>
              <input type="email" class="form-control" id="products-service-code">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="products-create-service">
                <i class="fa fa-plus"></i> @lang('products.create_service')
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
                      <th>@lang('products.service_table_code')</th>
                      <th>@lang('products.service_description')</th>
                      <th>@lang('products.service_cost')</th>
                      <th>@lang('products.service_price')</th>
                      <th>@lang('products.service_category')</th>
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
      <div class="tab-pane" id="products-view-analysis">

      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
