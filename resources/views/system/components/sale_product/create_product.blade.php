<div class="modal fade in" id="create-product">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">@lang('products/create_product.title')</h4>
      </div>
      <div class="modal-body">
        <div class="row form-inline">

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-product-code" class="control-label">@lang('products/create_product.code')</label>
            <input class="form-control" id="create-product-code">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <select class="form-control" id="create-product-provider">
              <option value="0">@lang('products.all_providers')</option>
              @foreach(\App\Provider::where('code', '!=', '0')->get() as $provider)
                <option value="{{ $provider->code }}">{{ $provider->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-product-description" class="control-label">@lang('products/create_product.description')</label>
            <input class="form-control" id="create-product-description">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-product-category" class="control-label">@lang('products/create_product.category')</label>
            <input class="form-control" id="create-product-category">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-product-onload-function" class="control-label">@lang('products/create_product.onload_function')</label>
            <input class="form-control" id="create-product-onload-function">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-product-onsale-function" class="control-label">@lang('products/create_product.onsale_function')</label>
            <input class="form-control" id="create-product-onsale-function">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-product-measurement_unit_code" class="control-label">@lang('products/create_product.measurement_unit_code')</label>
            <input class="form-control" id="create-product-measurement_unit_code">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-product-cost" class="control-label">@lang('products/create_product.cost')</label>
            <input class="form-control" id="create-product-cost">
          </div>



        </div>

        <div class="row form-inline lg-top-space md-top-space sm-top-space">


          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
            <label for="create-product-avg-cost" class="control-label">@lang('products/create_product.avg_cost')</label>
            <input class="form-control" id="create-product-avg-cost">
          </div>


          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-price" class="control-label">@lang('products/create_product.price')</label>
            <input class="form-control" id="create-product-price">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-sellable" class="control-label">@lang('products/create_product.sellable')</label>
            <input class="form-control" id="create-product-sellable">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-sell-at-base-price" class="control-label">@lang('products/create_product.sell_at_base_price')</label>
            <input class="form-control" id="create-product-sell-at-base-price">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-base-price" class="control-label">@lang('products/create_product.base_price')</label>
            <input class="form-control" id="create-product-base-price">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-alternatives" class="control-label">@lang('products/create_product.alternatives')</label>
            <input class="form-control" id="create-product-alternatives">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-volume" class="control-label">@lang('products/create_product.volume')</label>
            <input class="form-control" id="create-product-volume">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-weight" class="control-label">@lang('products/create_product.weight')</label>
            <input class="form-control" id="create-product-weight">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-packege-code" class="control-label">@lang('products/create_product.package_code')</label>
            <input class="form-control" id="create-product-package-code">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-package-mesasurement-unit-code" class="control-label">@lang('products/create_product.package_mesasurement_unit_code')</label>
            <input class="form-control" id="create-product-package-mesasurement-unit-code">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-oder-by" class="control-label">@lang('products/create_product.order_by')</label>
            <input class="form-control" id="create-product-order-by">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-service" class="control-label">@lang('products/create_product.service')</label>
            <input class="form-control" id="create-product-service">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-materials" class="control-label">@lang('products/create_product.materials')</label>
            <input class="form-control" id="create-product-materials">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-points-cost" class="control-label">@lang('products/create_product.points_cost')</label>
            <input class="form-control" id="create-product-points-cost">
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center sm-top-space">
            <label for="create-product-account-code" class="control-label">@lang('products/create_product.account_code')</label>
            <input class="form-control" id="create-product-account-code">
          </div>

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('products/create_product.close')</button>
        <button type="button" class="btn btn-primary" id="create-product-create">@lang('products/create_product.create')</button>
      </div>
    </div>
  </div>
</div>
