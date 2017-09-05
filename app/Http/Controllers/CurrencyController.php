<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use \App\Currency;
use \App\Configuration;
class CurrencyController extends Controller
{
  public function save_local_currency() {
    $validator = Validator::make(Input::all(),
      array(
        'local_currency' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/currency_controller.local_currency_required')
      );
      return response()->json($response);
    }

    // Get current and new local currency.
    $config = Configuration::find(1);
    $current_local = Currency::where('code', $config->local_currency_code)->first();
    $new_local = Currency::where('code', Input::get('local_currency'))->first();

    if(!$new_local) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/currency_controller.currency_innexistant')
      );
      return response()->json($response);
    }

    // Now convert current local rates to reference new local.
    $current_local->exchange_rate = round($current_local->exchange_rate/$new_local->exchange_rate, 2);
    $current_local->buy_rate = round($current_local->buy_rate/$new_local->buy_rate, 2);
    $current_local->save();

    $new_local->exchange_rate = 1;
    $new_local->buy_rate = 1;
    $new_local->save();

    $used_currencies = array($current_local->code, $new_local->code);

    // Now get the remaining currencies and update their exchange rates and buy rates.
    $currencies = Currency::whereNotIn('code', $used_currencies)->get();
    foreach($currencies as $currency) {
      $currency->exchange_rate = round($currency->exchange_rate/$current_local->exchange_rate, 2);
      $currency->buy_rate = round($currency->buy_rate/$current_local->buy_rate, 2);
      $currency->save();
    }

    // Now update the local currency in configuration table.
    $config->local_currency_code = $new_local->code;
    $config->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/currency_controller.currency_created')
    );
    return response()->json($response);
  }

  public function currency_table() {
    return view('system.components.accounting.currency_table_body');
  }

  public function create_currency() {
    $validator = Validator::make(Input::all(),
      array(
        'currency_data' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/currency_controller.currency_data_required')
      );
      return response()->json($response);
    }

    // Create Currency.
    Currency::create(array(
      'code' => Input::get('currency_data')['code'],
      'exchange_rate' => Input::get('currency_data')['exchange'],
      'buy_rate' => Input::get('currency_data')['buy_rate'],
      'description' => Input::get('currency_data')['description']
    ));

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/currency_controller.currency_created')
    );
    return response()->json($response);
  }
}
