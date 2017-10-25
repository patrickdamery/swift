<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Account;
use App\Asset;
use App\AssetDecay;
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
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.data_required')
      );
      return response()->json($response);
    }

    // Check accounts.
    $check_account = Account::where('code', '=', Input::get('asset_account'))->first();
    if(!$check_account) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.account_not_found')
      );
      return response()->json($response);
    }
    if($check_account->type != 'as') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.not_asset')
      );
      return response()->json($response);
    }

    $check_account = Account::where('code', '=', Input::get('depreciation_account'))->first();
    if(!$check_account) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.account_not_found')
      );
      return response()->json($response);
    }
    if($check_account->type != 'ex') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.not_expense')
      );
      return response()->json($response);
    }

    $check_asset = Asset::where('asset_code', Input::get('asset_code'))->first();
    if($check_asset) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.asset_account_used')
      );
      return response()->json($response);
    }

    $check_asset = Asset::where('depreciation_code', Input::get('asset_code'))->first();
    if($check_asset) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.expense_account_used')
      );
      return response()->json($response);
    }

    $asset = Asset::create(array(
      'name' => Input::get('name'),
      'depreciation' => Input::get('depreciation'),
      'description' => Input::get('description'),
      'asset_account' => Input::get('asset_account'),
      'depreciation_account' => Input::get('depreciation_account'),
    ));

    $response = array(
      'state' => 'Success',
      'asset' => $asset
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
        'error' => \Lang::get('controllers/depreciating_assets.data_required')
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
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.data_required')
      );
      return response()->json($response);
    }

    // Check accounts.
    $check_account = Account::where('code', '=', Input::get('asset_account'))->first();
    if(!$check_account) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.account_not_found')
      );
      return response()->json($response);
    }
    if($check_account->type != 'as') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.not_asset')
      );
      return response()->json($response);
    }

    $check_account = Account::where('code', '=', Input::get('depreciation_account'))->first();
    if(!$check_account) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.account_not_found')
      );
      return response()->json($response);
    }
    if($check_account->type != 'ex') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.not_expense')
      );
      return response()->json($response);
    }

    $check_asset = Asset::where('asset_code', Input::get('asset_code'))->where('code', '!=', Input::get('code'))->first();
    if($check_asset) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.asset_account_used')
      );
      return response()->json($response);
    }

    $check_asset = Asset::where('depreciation_code', Input::get('asset_code'))->where('code', '!=', Input::get('code'))->first();
    if($check_asset) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/depreciating_assets.expense_account_used')
      );
      return response()->json($response);
    }

    $asset = Asset::where('id', Input::get('code'))->first();

    $asset->name = Input::get('name');
    $asset->depreciation = Input::get('depreciation');
    $asset->description = Input::get('description');
    $asset->asset_account = Input::get('asset_account');
    $asset->depreciation_account = Input::get('depreciation_account');

    $asset->save();
  }
}
