<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\BankAccount;
use App\Account;
class BankAccountController extends Controller
{

  public function bank_acocunt_transaction() {
    $validator = Validator::make(Input::all(),
      array(
        'transaction' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.transaction_required')
      );
      return response()->json($response);
    }

    // Get Worker making transaction and accounts to be used.
    $worker = Worker::where('code', Auth::user()->worker_code)->first();
    $bank_account = BankAccount::where('code', Input::get('transaction')['code'])->first();
    

  }

  public function search_bank_transactions() {
    $validator = Validator::make(Input::all(),
      array(
        'account_search' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_search_required')
      );
      return response()->json($response);
    }

    // Explode date range.
    $date_range = explode(' - ', Input::get('account_search')['date_range']);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    // Return view.
    return view('system.components.accounting.bank_account_table',
      [
        'account_search' => array(
          'code' => Input::get('account_search')['code'],
          'date_range' => $date_range,
          'offset' => Input::get('account_search')['offset']
        )
      ]
    );
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

    $bank_account = BankAccount::where('code', Input::get('code'))->first();

    $response = array(
      'state' => 'Success',
      'balance' => $bank_account->balance
    );
    return response()->json($response);
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

    // Make sure a bank account with specified code does not exist already.
    $account_check = BankAccount::where('code', Input::get('account')['code'])->first();
    if($account_check) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_exists')
      );
      return response()->json($response);
    }

    $bank_account = BankAccount::create(array(
      'code' => Input::get('account')['code'],
      'bank_name' => Input::get('account')['bank_name'],
      'account_number' => Input::get('account')['number'],
      'currency_code' => Input::get('account')['currency'],
      'balance' => Input::get('account')['balance'],
      'account_code' => Input::get('account')['account'],
    ));
    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/bank_account_controller.account_created')
    );
    return response()->json($response);
  }
}
