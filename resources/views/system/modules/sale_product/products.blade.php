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


  // Define Feedback Messages.
  swift_language.add_sentence('create_product_blank_code', {
                              'en': 'Product Code can\'t be left blank!',
                              'es': 'Codigo de Producto no puede dejarse en blanco!'
                            });


swift_event_tracker.register_swift_event('#products-view-service-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#products-view-service-tab', function(e) {
  swift_event_tracker.fire_event(e, '#products-view-service-tab');
});

swift_event_tracker.register_swift_event('#products-view-product-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#products-view-product-tab', function(e) {
  swift_event_tracker.fire_event(e, '#products-view-product-tab');

  if(typeof products.js === 'undefined') {
    $.getScript('{{ URL::to('/') }}/js/swift/products/products.js');
  }

});
</script>

@include('system.components.sale_product.create_product')

<section class="content-header">
  <h1>
    @lang('products/products.title')
    <small class="crumb">@lang('products/products.view_product')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cube"></i> @lang('products/products.title')</li>
    <li class="active crumb">@lang('products/products.view_product')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#products-view-product" id="products-view-product-tab" data-toggle="tab" aria-expanded="true">@lang('products/products.view_product')</a></li>
      <li class=""><a href="#products-view-service" id="products-view-service-tab" data-toggle="tab" aria-expanded="false">@lang('products/products.view_service')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="products-view-product">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="products-product-code" class="control-label">@lang('products/products.product_code')</label>
              <input for="products-product-code" type="text" class="form-control" id="products-product-code">
            </div>
          </div>
          <div class="col-lg-5 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="products-product-provider" class="control-label">@lang('products/products.product_provider')</label>
              <select for="products-product-provider" class="form-control" id="products-product-provider">
                <option value="0">@lang('products/products.all_providers')</option>
                @foreach(\App\Provider::where('code', '!=', '0')->get() as $provider)
                  <option value="{{ $provider->code }}">{{ $provider->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="create-product" data-toggle="modal" data-target="#create-product">
                <i class="fa fa-plus"></i> @lang('products/products.create_product')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
            <div class="box" id="products-table">
              @include('system.components.sale_product.products_table',
              [
                'product_data' => array(
                  'code' => '',
                  'provider' => 'all',
                  'offset' => 1,
                )
                ])
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="products-view-service">
        <div class="row form-inline">
          <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="products-service-code" class="control-label">@lang('products/products.service_code')</label>
              <input type="text" class="form-control" id="products-service-code">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="create-service">
                <i class="fa fa-plus"></i> @lang('products/products.create_service')
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
                      <th>@lang('products/products.service_table_code')</th>
                      <th>@lang('products/products.service_description')</th>
                      <th>@lang('products/products.service_cost')</th>
                      <th>@lang('products/products.service_price')</th>
                      <th>@lang('products/products.service_category')</th>
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
