<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\BankAccount;
use App\Account;
use App\POS;
class BankAccountController extends Controller
{

  public function create_pos() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'name' => 'required',
        'bank_commission' => 'required',
        'government_commission' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_code_required')
      );
      return response()->json($response);
    }

    // Create POS.
    $last_pos = POS::orderBy('id', 'desc')->first();
    $code = ($last_pos) ? $last_pos->code : 0;
    $pos = POS::create(array(
      'code' => $code+1,
      'bank_account_code' => Input::get('code'),
      'name' => Input::get('name'),
      'bank_commission' => Input::get('bank_commission'),
      'government_commission' => Input::get('government_commission')
    ));

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/bank_account_controller.pos_created')
    );
    return response()->json($response);
  }

  public function search_bank_account() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_code_required')
      );
      return response()->json($response);
    }

    // Return view.
    return view('system.components.accounting.bank_account_table',
      [
        'code' => Input::get('code'),
      ]
    );
  }

  public function suggest_accounts(Request $request) {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_data_required')
      );
      return response()->json($response);
    }

    $accounts = BankAccount::where('code', 'like',  '%'.Input::get('code').'%')
    ->orWhere('account_number', 'like', '%'.Input::get('code').'%')
    ->orWhere('bank_name', 'like', '%'.Input::get('code').'%')->get();

    $response = array();
    foreach($accounts as $account) {
      array_push($response, array(
        'label' => $account->bank_name.' '.$account->account_number,
        'value' => $account->code,
      ));
    }
    return response()->json($response);
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
        'error' => \Lang::get('controllers/bank_account_controller.account_required')
      );
      return response()->json($response);
    }

    // Check if accounting account is defined, and if it is make sure that parent has children.
    $account_code = Input::get('account')['account'];
    if($account_code != '') {
      $account = Account::where('code', Input::get('account')['account'])->first();
      if(!$account) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('controllers/bank_account_controller.inexistent_account')
        );
        return response()->json($response);
      }
    }

    // Make sure a bank account with specified account does not exist already.
    $account_check = BankAccount::where('account_code', Input::get('account')['account'])->first();
    if($account_check) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_exists')
      );
      return response()->json($response);
    }

    // Get last bank account.
    $last_bank_account = BankAccount::withTrashed()->orderBy('id', 'desc')->first();
    $code = ($last_bank_account) ? $last_bank_account->code : 0;

    try{
      $bank_account = BankAccount::create(array(
        'code' => $code+1,
        'bank_name' => Input::get('account')['bank_name'],
        'account_number' => Input::get('account')['number'],
        'account_code' => Input::get('account')['account'],
      ));

      $response = array(
        'state' => 'Success',
        'bank_account' => $bank_account,
        'message' => \Lang::get('controllers/bank_account_controller.account_created')
      );
      return response()->json($response);
    } catch(\Exception $e) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.db_exception')
      );
      return response()->json($response);
    }
  }
}
