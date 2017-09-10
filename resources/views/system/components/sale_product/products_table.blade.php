@php
  function get_sellable($t) {
    if($t == 1){
        return \Lang::get('products/create_product.yes');
    }else{
      return \Lang::get('products/create_product.no');
    }
  }

  function get_sell_at_base_price($t) {
    if($t == 1){
        return \Lang::get('products/create_product.yes');
    }else{
      return \Lang::get('products/create_product.no');
    }
  }




  $products = array();
  if(isset($product_data)) {
    if($product_data['code'] == '') {
      if($product_data['provider'] == 'all') {
        $products = \App\Product::where('code', '!=', '0');
      } else {
        $products = \App\Product::where('provider', $product_data['provider']);
      }
    } else {
      if($product_data['provider'] == 'all') {
        $products = \App\Product::where('code', $product_data['code']);
      } else {
        $products = \App\Product::where('code', $product_data['code'])
        ->where('provider', $product_data['provider']);
      }
    }
  } else {
    $products = \App\Product::where('code', '!=', '0');
  }


  function get_provider($t) {
    if($t != 0){
        $provider = \App\Provider::where('code', '===', '$t');
        return $provider->name;
      }else{
    }
  }

  $records = $products->count();
  $pages = ceil($records/100);
  $offset = $product_data['offset'];
  if($offset == 'first') {
    $offset = 0;
  } else if ($offset == 'last') {
    $offset = $pages-1;
  } else {
    $offset--;
  }
  $products = $products->offset($offset*100)
    ->limit(100)
    ->get();
@endphp
<div class="box-body table-responsive no-padding swift-table">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>@lang('products/products.product_table_code')</th>
        <th>@lang('products/products.product_table_provider')</th>
        <th>@lang('products/products.product_description')</th>
        <th>@lang('products/products.product_avg_cost')</th>
        <th>@lang('products/products.product_cost')</th>
        <th>@lang('products/products.product_price')</th>
        <th>@lang('products/products.product_sellable')</th>
        <th>@lang('products/products.product_sell_at_base_price')</th>
        <th>@lang('products/products.product_base_price')</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $product)
        <tr id="product-{{ $product->code }}">
          <td>{{ $product->code }}</td>
          <td>{{ $product->provider_code}}</td>
          <td>{{ $product->description }}</td>
          <td>{{ $product->desc }}</td>
          <td>{{ $product->avg_cost }}</td>
          <td>{{ $product->cost }}</td>
          <td>{{ $product->price }}</td>
          <td>{{ get_sellable($product->sellable) }}</td>
          <td>{{ get_sell_at_base_price($product->sell_at_base_price) }}</td>
          <td>{{ $product->base_price }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="box-footer clearfix">
  <ul class="pagination pagination-sm no-margin pull-right products-pagination">
    <li><a href="#" id="products-pagination-first">«</a></li>
    @if($offset+1 == 1)
      <li><a href="#" id="products-pagination-1">1</a></li>
      @for($i = 2; $i <= $pages; $i++)
        @if($i < 4)
          <li><a href="#" id="products-pagination-{{ $i }}">{{ $i }}</a></li>
        @endif
      @endfor
    @else
      <li><a href="#" id="products-pagination-{{ $offset }}">{{ $offset }}</a></li>
      <li><a href="#" id="products-pagination-{{ $offset+1 }}">{{ $offset+1 }}</a></li>
      @if($offset+2 <= $pages)
        <li><a href="#" id="products-pagination-{{ $offset+2 }}">{{ $offset+2 }}</a></li>
      @endif
    @endif
    <li><a href="#" id="products-pagination-last">»</a></li>
  </ul>
</div>
