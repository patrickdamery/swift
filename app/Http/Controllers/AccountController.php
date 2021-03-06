<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Account;
use App\AccountHistory;
use App\AccountHistoryBreakdown;
use App\JournalEntryBreakdown;
use App\Worker;
class AccountController extends Controller
{
  public function check_account_code() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.account_data_required')
      );
      return response()->json($response);
    }

    // Get account.
    $codes = json_decode(json_encode(Input::get('code')), true);
    foreach($codes as $code) {
      $account = Account::where('code', $code)->first();

      // Make sure account is empty.
      if(!$account) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('controllers/account_controller.account_code_unexistent').$code
        );
        return response()->json($response);
      }
    }

    $response = array(
      'state' => 'Success',
    );
    return response()->json($response);
  }

  public function delete_account() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.account_data_required')
      );
      return response()->json($response);
    }

    // Get account.
    $account = Account::where('code', Input::get('code'))->first();

    // Make sure account is empty.
    if($account->load_amount() != 0) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.account_not_empty')
      );
      return response()->json($response);
    }

    // Delete it.
    $account->delete();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/account_controller.account_deleted')
    );
    return response()->json($response);
  }

  public function load_asset() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.account_data_required')
      );
      return response()->json($response);
    }

    // Get asset account.
    $account = Account::where('code', Input::get('code'))
      ->where('type', 'as')
      ->where('has_children', 0)
      ->first();

    if(!$account) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.account_not_found')
      );
      return response()->json($response);
    }

    $response = array(
      'state' => 'Success',
      'account' => $account
    );
    return response()->json($response);
  }

  public function suggest_asset() {
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

    $accounts = Account::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')->get();

    $accounts = $accounts->where('has_children', 0)
      ->where('type', 'as');

    $response = array();
    foreach($accounts as $account) {
      array_push($response, array(
        'label' => $account->name,
        'value' => $account->code,
      ));
    }
    return response()->json($response);
  }

  public function suggest_liability() {
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

    $accounts = Account::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')
      ->get();

    $accounts = $accounts->where('type', 'li');

    $response = array();
    foreach($accounts as $account) {
      array_push($response, array(
        'label' => $account->name,
        'value' => $account->code,
      ));
    }
    return response()->json($response);
  }

  public function suggest_expense() {
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

    $accounts = Account::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')
      ->get();

    $accounts = $accounts->where('type', 'ex');

    $response = array();
    foreach($accounts as $account) {
      array_push($response, array(
        'label' => $account->name,
        'value' => $account->code,
      ));
    }
    return response()->json($response);
  }

  public function suggest_contra_asset() {
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

    $accounts = Account::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')
      ->get();

    $accounts = $accounts->where('type', 'ca');

    $response = array();
    foreach($accounts as $account) {
      array_push($response, array(
        'label' => $account->name,
        'value' => $account->code,
      ));
    }
    return response()->json($response);
  }

  public function change_account_name() {
    $validator = Validator::make(Input::all(),
      array(
        'change_data' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.change_data_required')
      );
      return response()->json($response);
    }

    $account = Account::where('code', Input::get('change_data')['edit_code'])->first();
    $account->name = Input::get('change_data')['edit_value'];
    $account->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/account_controller.changed_data')
    );
    return response()->json($response);
  }

  public function change_ledger_description() {
    $validator = Validator::make(Input::all(),
      array(
        'change_data' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.change_data_required')
      );
      return response()->json($response);
    }

    $entry = JournalEntryBreakdown::where('code', Input::get('change_data')['edit_code'])->first();
    $entry->description = Input::get('change_data')['edit_value'];
    $entry->save();

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/account_controller.changed_data')
    );
    return response()->json($response);
  }

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

    // Get all children accounts.
    $account = \App\Account::where('code', $ledger_data->code)->first();
    $account_codes = $account->children_codes();

    // Get Initial Balance
    $account_balance = 0;
    $initial_balance = \DB::table('account_history_breakdown')
      ->join('account_history', 'account_history_breakdown.account_history_code', 'account_history.code')
      ->select('account_history.*', 'account_history_breakdown.*')
      ->where('account_history.month', '<=', date('m', strtotime($date_range[0])))
      ->where('account_history.year', '<=', date('Y', strtotime($date_range[0])))
      ->where('account_history.year', '>', date('Y', strtotime($date_range[0].' -1 year')))
      ->whereIn('account_history_breakdown.account_code', $account_codes)
      ->get();

    $month = '';
    $year = '';
    foreach($initial_balance as $balance) {
      $account_balance += $balance->balance;
      $month = $balance->month;
      $year = $balance->year;
    }

    // Update intial balance to whatever the start period was.
    $entries = \DB::table('journal_entries')
      //->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
      ->join('journal_entries_breakdown', function($join){
        $join->on('journal_entries.code', 'journal_entries_breakdown.journal_entry_code');
        $join->on('journal_entries.branch_identifier', 'journal_entries_breakdown.branch_identifier');
      })
      ->select('journal_entries_breakdown.*')
      ->whereBetween('journal_entries.entry_date', array(date('Y-m-d H:i:s', strtotime($year.'-'.$month.'-01')), $date_range[0]))
      ->whereIn('journal_entries_breakdown.account_code', $account_codes)
      ->get();

    foreach($entries as $entry) {
      // Check if it's a debit transaction and update account data based on
      // Account type.
      if($entry->debit) {
        if(in_array($account->type, array('li', 'eq', 're'))) {
          $account_balance -= $entry->amount;
        } else {
          $account_balance += $entry->amount;
        }
      } else {
        if(in_array($account->type, array('li', 'eq', 're'))) {
          $account_balance += $entry->amount;
        } else {
          $account_balance -= $entry->amount;
        }
      }
    }

    // Get the journal entries.
    $ledger = \DB::table('journal_entries')
      //->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
      ->join('journal_entries_breakdown', function($join){
        $join->on('journal_entries.code', 'journal_entries_breakdown.journal_entry_code');
        $join->on('journal_entries.branch_identifier', 'journal_entries_breakdown.branch_identifier');
      })
      ->select('journal_entries.*', 'journal_entries_breakdown.*')
      ->whereIn('journal_entries_breakdown.account_code', $account_codes)
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
    $callback = function() use ($ledger, $columns, $account_balance, $account)
    {
      $file = fopen('php://output', 'w');
      fputcsv($file, $columns);
      foreach($ledger as $entry) {
        if($entry->debit) {
          if(in_array($account->type, array('li', 'eq', 're'))) {
            $account_balance -= $entry->amount;
          } else {
            $account_balance += $entry->amount;
          }
        } else {
          if(in_array($account->type, array('li', 'eq', 're'))) {
            $account_balance += $entry->amount;
          } else {
            $account_balance -= $entry->amount;
          }
        }
        $debit = ($entry->debit == 1) ? $entry->amount : '';
        $credit = ($entry->debit == 0) ? $entry->amount : '';
        fputcsv($file, array($entry->entry_date, $entry->description,
          $debit, $credit, $account_balance)
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
    return view('system.components.accounting.ledger_table',
     [
       'code' => Input::get('ledger_data')['code'],
       'date_range' => $date_range,
       'offset' => Input::get('ledger_data')['offset']
    ]);
  }

  public function suggest_parent_accounts(Request $request) {
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

    $accounts = Account::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')
      ->get();

    $accounts = $accounts->where('has_children', 1);

    $response = array();
    foreach($accounts as $account) {
      array_push($response, array(
        'label' => $account->name,
        'value' => $account->code,
      ));
    }
    return response()->json($response);
  }

  public function suggest_child_accounts() {
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

    $accounts = Account::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')
      ->get();

    $accounts = $accounts->where('has_children', 0);

    $response = array();
    foreach($accounts as $account) {
      array_push($response, array(
        'label' => $account->name,
        'value' => $account->code,
      ));
    }
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
        'error' => \Lang::get('controllers/account_controller.account_data_required')
      );
      return response()->json($response);
    }

    // Check if type is defined.
    $accounts = array();
    $search_type = ($request->has('type') && Input::get('type') != 'all') ? true : false;

    if($search_type) {
      $accounts = Account::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')
      ->where('type', Input::get('type'))->get();
    } else {
      $accounts = Account::where('code', 'like',  '%'.Input::get('code').'%')
      ->orWhere('name', 'like', '%'.Input::get('code').'%')->get();
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

    return view('system.components.accounting.accounts_table',
      [
        'account_data' => Input::get('account_data')
      ]
    );
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

      if(!$parent) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('controllers/account_controller.parent_unexistent')
        );
        return response()->json($response);
      }

      if(!$parent->has_children) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('controllers/account_controller.no_children')
        );
        return response()->json($response);
      }
      if($parent->type != Input::get('account')['type']) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('controllers/account_controller.diff_type')
        );
        return response()->json($response);
      }
    } else {
      $parent_account = 0;
    }

    // Append Parent code if parent exists.
    $code = ($parent_account != 0) ? $parent_account.'.'.Input::get('account')['code'] : Input::get('account')['code'];

    // Make sure an account with specified code does not exist already.
    $account_check = Account::where('code', $code)->first();
    if($account_check) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/account_controller.account_exists')
      );
      return response()->json($response);
    }

    $thrashed_account_check = Account::withTrashed()->where('code', $code)->first();
    if($thrashed_account_check) {
      $thrashed_account_check->restore();
      $thrashed_account_check->type = Input::get('account')['type'];
      $thrashed_account_check->name = Input::get('account')['name'];
      $thrashed_account_check->parent_account = $parent_account;
      $thrashed_account_check->has_children = Input::get('account')['children'];
      $thrashed_account_check->amount = Input::get('account')['amount'];
      $thrashed_account_check->currency_code = Input::get('account')['currency'];
      $thrashed_account_check->save();

      $response = array(
        'state' => 'Success',
        'message' => \Lang::get('controllers/account_controller.account_created')
      );
      return response()->json($response);
    }
    $account = Account::create(array(
      'code' => $code,
      'type' => Input::get('account')['type'],
      'name' => Input::get('account')['name'],
      'parent_account' => $parent_account,
      'has_children' => Input::get('account')['children'],
      'amount' => Input::get('account')['amount'],
      'currency_code' => Input::get('account')['currency'],
    ));

    // Check if we already have accounts_balance for this month.
    $account_balance_history = AccountHistory::where('month', date('m'))
      ->where('year', date('Y'))->first();
    if($account_balance_history) {
      AccountHistoryBreakdown::create(array(
        'account_history_code' => $account_balance_history->code,
        'account_code' => $code,
        'balance' => Input::get('account')['amount'],
      ));
    } else {
      $account_balance_code = AccountHistory::orderBy('id', 'desc')->get();
      $account_balance_code = (count($account_balance_code) > 0) ? $account_balance_code[0]->code+1 : 1;

      $account_balance_history = AccountHistory::create(array(
        'month' => date('m'),
        'year' => date('Y'),
        'code' => $account_balance_code
      ));

      AccountHistoryBreakdown::create(array(
        'account_history_code' => $account_balance_history->code,
        'account_code' => $code,
        'balance' => 0,
      ));
    }

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/account_controller.account_created')
    );
    return response()->json($response);
  }
}
