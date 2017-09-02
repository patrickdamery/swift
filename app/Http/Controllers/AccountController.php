<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Account;
class AccountController extends Controller
{
  public function create_account() {
    // Check for token.
    $validator = Validator::make(Input::all(),
      array(
        'account' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controller/account_controller.account_required')
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
          'error' => \Lang::get('controller/account_controller.no_children')
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
        'error' => \Lang::get('controller/account_controller.account_exists')
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
      'message' => \Lang::get('controller/account_controller.account_created')
    );
    return response()->json($response);
  }
}
