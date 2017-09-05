<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Account;
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
        'error' => \Lang::get('controllers/account_controller.account_data_required')
      );
      return response()->json($response);
    }

    // Check if type is defined.
    $accounts = array();
    $search_type = ($request->has('type') && Input::get('type') != 'all')? true : false;

    if($search_type) {
      $accounts = Account::where('code', 'like',  '%'.Input::get('code').'%')
      ->where('name', 'like', '%'.Input::get('code').'%')
      ->where('type', Input::get('type'))->get();
    } else {
      $accounts = Account::where('code', 'like',  '%'.Input::get('code').'%')
      ->where('name', 'like', '%'.Input::get('code').'%')->get();
    }

    $response = array();
    foreach($accounts as $account) {
        array_push($response, array(
          'label' => $account->name,
          'value' => $account->code,
        ));
    }
    return response()->json($response);
  }



  public function load_accounts() {
    $validator = Validator::make(Input::all(),
      array(
        'account_data' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.account_data_required')
      );
      return response()->json($response);
    }

    return view('system.components.accounting.accounts_table_body',
     ['account_data' => Input::get('account_data')]);
  }


  public function create_account() {
    $validator = Validator::make(Input::all(),
      array(
        'account' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.account_required')
      );
      return response()->json($response);
    }

    // Check if parent is defined, and if it is make sure that parent has children.
    $parent_account = Input::get('account')['parent'];
    if($parent_account != '') {
      $parent = Account::where('code', Input::get('account')['parent'])->first();
      if(!$parent->has_children) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('controllers/account_controller.no_children')
        );
        return response()->json($response);
      }
    } else {
      $parent_account = 0;
    }

    // Make sure an account with specified code does not exist already.
    $account_check = Account::where('code', Input::get('account')['code'])->first();
    if($account_check) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.account_exists')
      );
      return response()->json($response);
    }

    $account = Account::create(array(
      'code' => Input::get('account')['code'],
      'type' => Input::get('account')['type'],
      'name' => Input::get('account')['name'],
      'parent_account' => $parent_account,
      'has_children' => Input::get('account')['children'],
      'amount' => Input::get('account')['amount'],
    ));
    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/account_controller.account_created')
    );
    return response()->json($response);
  }


}
