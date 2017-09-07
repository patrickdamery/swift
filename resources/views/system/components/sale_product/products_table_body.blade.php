@php

  $products = array();
  if(isset($product_data)) {
    if($product_data['code'] == '') {
      if($product_data['type'] == 'all') {
        $products = \App\Product::where('code', '!=', '0')->get();
      } else {
        $products = \App\Product::where('type', $product_data['type'])->get();
      }
    } else {
      if($product_data['type'] == 'all') {
        $products = \App\Product::where('code', $product_data['code'])->get();
      } else {
        $products = \App\Product::where('code', $product_data['code'])
        ->where('type', $product_data['type'])->get();
      }
    }
  } else {
    $products = \App\Product::where('code', '!=', '0')->get();
  }
@endphp
@foreach($products as $product)
  <tr id="product-{{ $product->code }}">
    <td>{{ $product->code }}</td>
    <td>{{ $product->provider_code }}</td>
    <td>{{ $product->description }}</td>
    <td>{{ $product->avg_cost }}</td>
    <td>{{ $product->cost }}</td>
    <td>{{ $product->price }}</td>
    <td>{{ $product->sellable }}</td>
    <td>{{ $product->sell-at-base-price }}</td>
    <td>{{ $product->base-price }}</td>
  </tr>
@endforeach
