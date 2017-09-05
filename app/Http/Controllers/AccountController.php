<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Account;
class AccountController extends Controller
{


  public function download_ledger() {
    $validator = Validator::make(Input::all(),
      array(
        'ledger_data' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.ledger_data_required')
      );
      return response()->json($response);
    }

    // Explode date range.
    $ledger_data = json_decode(Input::get('ledger_data'));
    $date_range = explode(' - ', $ledger_data->date_range);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    // Get the journal entries.
    $ledger = \DB::table('journal_entries')
      ->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
      ->select('journal_entries.*', 'journal_entries_breakdown.*')
      ->where('journal_entries_breakdown.account_code', $ledger_data->code)
      ->whereBetween('journal_entries.entry_date', $date_range)
      ->get();

    // Prepare headers.
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".\Lang::get('controllers/account_controller.ledger_report').".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array(\Lang::get('controllers/account_controller.date'), \Lang::get('controllers/account_controller.description'),
      \Lang::get('controllers/account_controller.debit'), \Lang::get('controllers/account_controller.credit'),
      \Lang::get('controllers/account_controller.value')
    );
    $callback = function() use ($ledger, $columns)
    {
      $file = fopen('php://output', 'w');
      fputcsv($file, $columns);
      foreach($ledger as $entry) {
        $debit = ($entry->debit == 1) ? $entry->amount : '';
        $credit = ($entry->debit == 0) ? $entry->amount : '';
        fputcsv($file, array($entry->entry_date, $entry->description,
          $debit, $credit, $entry->balance)
        );
      }
      fclose($file);
    };
    return response()->stream($callback, 200, $headers);
  }


  public function print_ledger() {
    $validator = Validator::make(Input::all(),
      array(
        'ledger_data' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.ledger_data_required')
      );
      return response()->json($response);
    }

    // Explode date range.
    $date_range = explode(' - ', Input::get('ledger_data')['date_range']);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    // Return view.
    return view('system.printables.accounting.ledger',
     [
       'code' => Input::get('ledger_data')['code'],
       'date_range' => $date_range
    ]);
  }

  public function load_ledger() {
    $validator = Validator::make(Input::all(),
      array(
        'ledger_data' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.ledger_data_required')
      );
      return response()->json($response);
    }

    // Explode date range.
    $date_range = explode(' - ', Input::get('ledger_data')['date_range']);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    // Return view.
    return view('system.components.accounting.ledger_table_body',
     [
       'code' => Input::get('ledger_data')['code'],
       'date_range' => $date_range,
       'offset' => Input::get('ledger_data')['offset']
    ]);
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
        'error' => \Lang::get('controllers/account_controller.account_data_required')
      );
      return response()->json($response);
    }

    // Check if type is defined.
    $accounts = array();
    $search_type = ($request->has('type') && Input::get('type') != 'all') ? true : false;

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
