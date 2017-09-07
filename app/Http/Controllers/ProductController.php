<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\product;
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

    // Check if type is defined.
    $products = array();
    $search_type = ($request->has('type') && Input::get('type') != 'all')? true : false;

    if($search_type) {
      $products = product::where('code', 'like',  '%'.Input::get('code').'%')
      ->where('name', 'like', '%'.Input::get('code').'%')
      ->where('type', Input::get('type'))->get();
    } else {
      $products = product::where('code', 'like',  '%'.Input::get('code').'%')
      ->where('name', 'like', '%'.Input::get('code').'%')->get();
    }

    $response = array();
    foreach($products as $product) {
        array_push($response, array(
          'label' => $product->name,
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



    // Make sure an product with specified code does not exist already.
    $product_check = product::where('code', Input::get('product')['code'])->first();
    if($product_check) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/product_controller.product_exists')
      );
      return response()->json($response);
    }

    $product = product::create(array(

      'code' => Input::get('product')['code'],
      'provider' => Input::get('product')['provider'],
      'description' => Input::get('product')['description'],
      'category' => Input::get('product')['category'],
      'measurement_unit_code' => Input::get('product')['measurement_unit_code'],
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
