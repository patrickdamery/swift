<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Product;
use App\JournalEntryBreakdown;
class ProductController extends Controller
{

  public function suggest_products(Request $request) {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/product_controller.product_data_required')
      );
      return response()->json($response);
    }

    $product = array();
    $search_provider = ($request->has('provider_code') && select::get('provider_code') != 'all') ? true : false;

    if($search_provider) {
      $products = Account::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('description', 'like', '%'.Input::get('code').'%')
      ->where('provider_code', Input::get('provider_code'))->get();
    } else {
      $products = Account::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('description', 'like', '%'.Input::get('code').'%')->get();
    }

    // Check if type is defined.

    $response = array();
    foreach($products as $product) {
        array_push($response, array(
          'label' => $product->description,
          'value' => $product->code,
        ));
    }
    return response()->json($response);
  }

  public function load_products() {
    $validator = Validator::make(Input::all(),
      array(
        'product_data' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/product_controller.product_data_required')
      );
      return response()->json($response);
    }

    return view('system.components.sale_product.products_table_body',
     ['product_data' => Input::get('product_data')]);
  }


  public function create_product() {
    $validator = Validator::make(Input::all(),
      array(
        'product' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/product_controller.product_required')
      );
      return response()->json($response);
    }

    $code = Product::where('code', Input::get('product')['code']);
    // Make sure an product with specified code does not exist already.
    $product_check = Product::where('code', Input::get('product')['code'])->first();
    if($product_check) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/product_controller.product_exists')
      );
      return response()->json($response);
    }

    $product = product::create(array(
      'code' => Input::get('product')['code'],,
      'provider' => Input::get('product')['provider_code'],
      'description' => Input::get('product')['description'],
      'category' => Input::get('product')['category'],
      'measurement_unit_code' => Input::get('product')['measurement-unit-code'],
      'avg-cost' => Input::get('product')['avg-cost'],
      'price'=> Input::get('product')['price'],
      'sellable'=> Input::get('product')['sellable'],
      'sell-at-base-price'=> Input::get('product')['sell-at-base-price'],
      'base-price'=> Input::get('product')['base-price'],
      'alternatives'=> Input::get('product')['alternatives'],
      'volume'=> Input::get('product')['volume'],
      'weight' => Input::get('product')['weight'],
      'package-code'=> Input::get('product')['package-code'],
      'package-mesasurement-unit-code'=> Input::get('product')['package-mesasurement-unit-code'],
      'order-by'=> Input::get('product')['order-by'],
      'service'=> Input::get('product')['service'],
      'materials'=> Input::get('product')['materials'],
      'cost'=> Input::get('product')['cost'],
    ));
    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/product_controller.product_created')
    );
    return response()->json($response);
  }
}
