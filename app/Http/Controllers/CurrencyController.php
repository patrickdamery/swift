<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use \App\Currency;
use \App\CurrencyExchange;
use \App\Configuration;
class CurrencyController extends Controller
{
  public function change_rate() {
    $validator = Validator::make(Input::all(),
      array(
        'change_data' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/currency_controller.change_data_required')
      );
      return response()->json($response);
    }

    if(Input::get('change_data')['change_type'] == 'variation') {
      $variation = CurrencyExchange::where('code', Input::get('change_data')['edit_code'])->first();
      if(Input::get('change_data')['edit_type'] == 'exchange') {
        $variation->exchange_rate = Input::get('change_data')['edit_value'];
        $variation->save();
      } else {
        $variation->buy_rate = Input::get('change_data')['edit_value'];
        $variation->save();
      }
    } else {
      $currency = Currency::where('code', Input::get('change_data')['edit_code'])->first();
      if(Input::get('change_data')['edit_type'] == 'exchange') {
        $currency->exchange_rate = Input::get('change_data')['edit_value'];
        $currency->save();
      } else {
        $currency->buy_rate = Input::get('change_data')['edit_value'];
        $currency->save();
      }
    }

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/currency_controller.rate_changed'),
    );
    return response()->json($response);
  }

  public function variation_search() {
    $validator = Validator::make(Input::all(),
      array(
        'variation_search' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/currency_controller.variation_search_error')
      );
      return response()->json($response);
    }

    // Explode date range.
    $variation_search = Input::get('variation_search');
    $date_range = explode(' - ', $variation_search['date_range']);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    // Return view.
    return view('system.components.accounting.currency_variation_table',
     [
       'code' => $variation_search['code'],
       'date_range' => $date_range
    ]);
  }

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
    $current_local->exchange_rate = round($current_local->exchange_rate/$new_local->exchange_rate, 4);
    $current_local->buy_rate = round($current_local->buy_rate/$new_local->buy_rate, 4);
    $current_local->save();

    $new_local->exchange_rate = 1;
    $new_local->buy_rate = 1;
    $new_local->save();

    $used_currencies = array($current_local->code, $new_local->code);

    $after_update_current = $current_local->exchange_rate;
    // Now get the remaining currencies and update their exchange rates and buy rates.
    $currencies = Currency::whereNotIn('code', $used_currencies)->get();
    foreach($currencies as $currency) {
      $currency->exchange_rate = $currency->exchange_rate*$current_local->exchange_rate;
      $currency->buy_rate = $currency->buy_rate*$current_local->buy_rate;
      $currency->save();
    }

    // Now update the local currency in configuration table.
    $config->local_currency_code = $new_local->code;
    $config->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/currency_controller.currency_created'),
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
