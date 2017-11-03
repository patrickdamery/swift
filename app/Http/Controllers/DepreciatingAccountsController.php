<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use DB;

use App\Account;
use App\Asset;
use App\AssetDepreciation;
class DepreciatingAccountsController extends Controller
{
  public function create_depreciating_account() {
    $validator = Validator::make(Input::all(),
      array(
        'name' => 'required',
        'depreciation' => 'required',
        'description' => 'required',
        'asset_account' => 'required',
        'depreciation_account' => 'required',
        'expense_account' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.data_required')
      );
      return response()->json($response);
    }

    // Check accounts.
    $check_account = Account::where('code', '=', Input::get('asset_account'))->first();
    if(!$check_account) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.account_not_found').Input::get('asset_account')
      );
      return response()->json($response);
    }
    if($check_account->type != 'as') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.not_asset').Input::get('asset_account')
      );
      return response()->json($response);
    }

    $check_account = Account::where('code', '=', Input::get('expense_account'))->first();
    if(!$check_account) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.account_not_found').Input::get('expense_account')
      );
      return response()->json($response);
    }
    if($check_account->type != 'ex') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.not_expense').Input::get('expense_account')
      );
      return response()->json($response);
    }

    $check_account = Account::where('code', '=', Input::get('depreciation_account'))->first();
    if(!$check_account) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.account_not_found').Input::get('depreciation_account')
      );
      return response()->json($response);
    }
    if($check_account->type != 'ca') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.not_contra_asset').Input::get('depreciation_account')
      );
      return response()->json($response);
    }

    $check_asset = Asset::where('asset_code', Input::get('asset_code'))->first();
    if($check_asset) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.asset_account_used')
      );
      return response()->json($response);
    }

    $check_asset = Asset::where('expense_code', Input::get('expense_code'))->first();
    if($check_asset) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.expense_account_used')
      );
      return response()->json($response);
    }

    $check_asset = Asset::where('depreciation_code', Input::get('depreciation_code'))->first();
    if($check_asset) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.depreciation_account_used')
      );
      return response()->json($response);
    }

    $tries = 0;
    $complete = false;
    $cheque_code = 0;
    $last_code = 0;
    while($tries < 5 && !$complete) {
      try {
        DB::beginTransaction();
        $last_code = DB::table('assets')
          ->orderBy('id', 'desc')
          ->limit(1)
          ->lockForUpdate()
          ->get();

          $last_code = (count($last_code) > 0) ? $last_code[0]->code+1 : 1;
          DB::table('assets')->insert([
            [
              'code' => $last_code,
              'name' => Input::get('name'),
              'depreciation' => Input::get('depreciation'),
              'description' => Input::get('description'),
              'asset_code' => Input::get('asset_account'),
              'expense_code' => Input::get('expense_account'),
              'depreciation_code' => Input::get('depreciation_account'),
              'state' => 1
            ]
          ]);

        DB::commit();
        $complete = true;
      } catch(\Exception $e) {
        $tries++;
        if($tries == 5) {
          $response = array(
            'state' => 'Error',
            'error' => \Lang::get('controllers/depreciating_accounts_controller.asset_depreciation_failed'),
            'exception' => $e
          );
          return response()->json($response);
        }
      }
    }

    $asset = Asset::where('code', $last_code)->first();
    $response = array(
      'state' => 'Success',
      'asset' => $asset,
      'message' => \Lang::get('controllers/depreciating_accounts_controller.depreciation_asset_created'),
    );
    return response()->json($response);
  }

  public function search_depreciating_account() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.data_required')
      );
      return response()->json($response);
    }

    $asset = Asset::where('id', Input::get('code'))->first();

    $response = array(
      'state' => 'Success',
      'asset' => $asset
    );
    return response()->json($response);
  }

  public function save_depreciating_account() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'name' => 'required',
        'depreciation' => 'required',
        'description' => 'required',
        'asset_account' => 'required',
        'depreciation_account' => 'required',
        'expense_account' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.data_required')
      );
      return response()->json($response);
    }

    // Check accounts.
    $check_account = Account::where('code', '=', Input::get('asset_account'))->first();
    if(!$check_account) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.account_not_found').Input::get('asset_account')
      );
      return response()->json($response);
    }
    if($check_account->type != 'as') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.not_asset').Input::get('asset_account')
      );
      return response()->json($response);
    }

    $check_account = Account::where('code', '=', Input::get('depreciation_account'))->first();
    if(!$check_account) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.account_not_found').Input::get('depreciation_account')
      );
      return response()->json($response);
    }
    if($check_account->type != 'ca') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.not_contra_asset').Input::get('depreciation_account')
      );
      return response()->json($response);
    }

    $check_account = Account::where('code', '=', Input::get('expense_account'))->first();
    if(!$check_account) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.account_not_found').Input::get('expense_account')
      );
      return response()->json($response);
    }
    if($check_account->type != 'ex') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.not_expense').Input::get('expense_account')
      );
      return response()->json($response);
    }


    $check_asset = Asset::where('asset_code', Input::get('asset_code'))->where('code', '!=', Input::get('code'))->first();
    if($check_asset) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.asset_account_used')
      );
      return response()->json($response);
    }

    $check_asset = Asset::where('expense_code', Input::get('expense_code'))->where('code', '!=', Input::get('code'))->first();
    if($check_asset) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.expense_account_used')
      );
      return response()->json($response);
    }

    $check_asset = Asset::where('depreciation_code', Input::get('depreciation_code'))->where('code', '!=', Input::get('code'))->first();
    if($check_asset) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_accounts_controller.depreciation_account_used')
      );
      return response()->json($response);
    }

    $asset = Asset::where('id', Input::get('code'))->first();

    $asset->name = Input::get('name');
    $asset->depreciation = Input::get('depreciation');
    $asset->description = Input::get('description');
    $asset->asset_code = Input::get('asset_account');
    $asset->depreciation_code = Input::get('depreciation_account');
    $asset->expense_code = Input::get('expense_account');

    $asset->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/depreciating_accounts_controller.asset_updated')
    );
    return response()->json($response);
  }
}
