<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Carbon;
use DB;
use Auth;

use App\BankAccount;
use App\Account;
use App\POS;
use App\ChequeBook;
use App\JournalEntry;
use App\JournalEntryBreakdown;
use App\BankLoan;
use App\Worker;
class BankAccountController extends Controller
{

  /**
   * Edit Bank Loan.
   */
  public function edit_loan() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'next_payment' => 'required',
        'interval' => 'required',
        'payment_rate' => 'required',
        'interest_rate' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_code_required')
      );
      return response()->json($response);
    }

    // Edit Bank Loan.
    $tries = 0;
    $complete = false;
    while($tries < 5 && !$complete) {
      try {
        DB::beginTransaction();
        // First lock any data we will be working with.
        $cheque_book = DB::table('bank_loans')
          ->where('code', Input::get('code'))
          ->lockForUpdate()
          ->get();

        // Now update the cheque book.
        DB::table('bank_loans')
          ->where('code', Input::get('code'))
          ->update(
          [
            'next_payment' => date('Y-m-d', strtotime(Input::get('next_payment'))),
            'interval' => Input::get('interval'),
            'payment_rate' => Input::get('payment_rate'),
            'interest_rate' => Input::get('interest_rate'),
          ]
        );
        DB::commit();
        $complete = true;
      } catch(\Exception $e) {
        $tries++;
        if($tries == 5) {
          $response = array(
            'state' => 'Error',
            'error' => \Lang::get('controllers/bank_account_controller.loan_update_failed')
          );
          return response()->json($response);
        }
      }
    }

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/bank_account_controller.loan_update_success')
    );
    return response()->json($response);
  }

  /**
   * Get Bank Loan.
   */
  public function get_loan() {
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

    // Get Bank Loan.
    $loan = BankLoan::where('code', Input::get('code'))->first();
    $loan->next_payment = date('d-m-Y', strtotime($loan->next_payment));

    $response = array(
      'state' => 'Success',
      'loan' => $loan
    );
    return response()->json($response);
  }

  /**
   * Create Cheque.
   */
  public function create_cheque() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'account' => 'required',
        'amount' => 'required',
        'paid_to' => 'required',
        'description' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_code_required')
      );
      return response()->json($response);
    }

    // Make sure account exists.
    $account_check = Account::where('code', Input::get('account'))->first();
    if(!$account_check) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_not_found')
      );
      return response()->json($response);
    }

    // Get branch identifier.
    $branch_identifier = Worker::where('code', Auth::user()->worker_code)->first()->branch_identifier();

    // Create Cheque.
    $tries = 0;
    $complete = false;
    $cheque_code = 0;
    while($tries < 5 && !$complete) {
      try {
        DB::beginTransaction();
        // First lock any data we will be working with.
        $last_cheque = DB::table('cheques')
          ->orderBy('id', 'desc')
          ->limit(1)
          ->lockForUpdate()
          ->get();
        $cheque_book = DB::table('cheque_book')
          ->where('code', Input::get('code'))
          ->first();
        $bank_account = DB::table('bank_accounts')
          ->where('code', $cheque_book->bank_account_code)
          ->first();
        $credit_account = DB::table('accounts')
          ->where('code', $bank_account->account_code)
          ->lockForUpdate()
          ->get();
        $debit_account = DB::table('accounts')
          ->where('code', Input::get('account'))
          ->lockForUpdate()
          ->get();
        $last_entry = DB::table('journal_entries')
          ->where('branch_identifier', $branch_identifier)
          ->orderBy('id', 'desc')
          ->limit(1)
          ->lockForUpdate()
          ->get();

        // Create Journal Entry.
        $entry_code = (count($last_entry) > 0) ? $last_entry[0]->code+1 : 1;
        DB::table('journal_entries')->insert([
          ['code' => $entry_code, 'branch_identifier' => $branch_identifier, 'state' => 1]
        ]);

        // Now update the accounts.
        DB::table('accounts')->where('code', $bank_account->account_code)
          ->decrement('amount', Input::get('amount'));

        DB::table('accounts')->where('code', Input::get('account'))
          ->decrement('amount', Input::get('amount'));

        // Make the entry breakdowns.
        DB::table('journal_entries_breakdown')->insert([
          [
            'journal_entry_code' => $entry_code,
            'branch_identifier' => $branch_identifier,
            'debit' => 0,
            'account_code' => $bank_account->account_code,
            'description' => Input::get('description'),
            'amount' => Input::get('amount')
          ]
        ]);

        DB::table('journal_entries_breakdown')->insert([
          [
            'journal_entry_code' => $entry_code,
            'branch_identifier' => $branch_identifier,
            'debit' => 1,
            'account_code' => Input::get('account'),
            'description' => Input::get('description'),
            'amount' => Input::get('amount'),
          ]
        ]);

        // Now create the cheque.
        $cheque_code = (count($last_cheque) > 0) ? $last_cheque[0]->code+1 : 1;
        DB::table('cheques')
          ->insert([
            [
              'code' => $cheque_code,
              'cheque_book_code' => $cheque_book->code,
              'cheque_number' => $cheque_book->current_number,
              'paid_to' => Input::get('paid_to'),
              'journal_entry_code' => $entry_code,
              'branch_identifier' => $branch_identifier,
            ]
          ]);
        DB::commit();
        $complete = true;
      } catch(\Exception $e) {
        $tries++;
        if($tries == 5) {
          $response = array(
            'state' => 'Error',
            'error' => \Lang::get('controllers/bank_account_controller.cheque_failed'),
            'exception' => $e
          );
          return response()->json($response);
        }
      }
    }

    // Return view.
    return view('system.printables.accounting.cheque',
      [
        'code' => $cheque_code
      ]
    );
  }

  /**
   * Edit Cheque Book.
   */
  public function edit_cheque_book() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'name' => 'required',
        'number' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_code_required')
      );
      return response()->json($response);
    }

    // Edit Cheque book.
    $tries = 0;
    $complete = false;
    while($tries < 5 && !$complete) {
      try {
        DB::beginTransaction();
        // First lock any data we will be working with.
        $cheque_book = DB::table('cheque_book')
          ->where('code', Input::get('code'))
          ->lockForUpdate()
          ->get();

        // Now update the cheque book.
        DB::table('cheque_book')
          ->where('code', Input::get('code'))
          ->update(
          [
            'name' => Input::get('name'),
            'current_number' => Input::get('number')
          ]
        );
        DB::commit();
        $complete = true;
      } catch(\Exception $e) {
        $tries++;
        if($tries == 5) {
          $response = array(
            'state' => 'Error',
            'error' => \Lang::get('controllers/bank_account_controller.cheque_book_failed')
          );
          return response()->json($response);
        }
      }
    }

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/bank_account_controller.cheque_book_updated')
    );
    return response()->json($response);
  }

  /**
   * Load Cheques.
   */
  public function load_cheques() {
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
    $date_range = explode(' - ', Input::get('date_range'));
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    // Return view.
    return view('system.components.accounting.cheques_table',
      [
        'code' => Input::get('code'),
        'offset' => Input::get('offset'),
        'date_range' => $date_range
      ]
    );
  }

  /**
   * Get Cheque Book.
   */
  public function get_cheque_book() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_code_required')
      );
      return response()->json($response);
    }

    // Get Cheque book.
    $cheque_book = ChequeBook::where('code', Input::get('code'))->first();
    $response = array(
      'state' => 'Success',
      'cheque_book' => $cheque_book
    );
    return response()->json($response);
  }

  /**
   * Edit POS.
   */
  public function edit_pos() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'name' => 'required',
        'bank_commission' => 'required',
        'government_commission' => 'required',
        'commission_account' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_code_required')
      );
      return response()->json($response);
    }

    // Edit POS.
    $tries = 0;
    $complete = false;
    while($tries < 5 && !$complete) {
      try {
        DB::beginTransaction();
        // First lock any data we will be working with.
        $pos = DB::table('pos')
          ->where('code', Input::get('code'))
          ->lockForUpdate()
          ->get();

        // Now update pos.
        DB::table('pos')
          ->where('code', Input::get('code'))
          ->update(
          [
            'bank_account_code' => Input::get('code'),
            'name' => Input::get('name'),
            'bank_commission' => Input::get('bank_commission'),
            'government_commission' => Input::get('government_commission'),
            'commission_account' => Input::get('commission_account')
          ]
        );
        DB::commit();
        $complete = true;
      } catch(\Exception $e) {
        $tries++;
        if($tries == 5) {
          $response = array(
            'state' => 'Error',
            'error' => \Lang::get('controllers/bank_account_controller.pos_failed')
          );
          return response()->json($response);
        }
      }
    }

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/bank_account_controller.pos_updated')
    );
    return response()->json($response);
  }

  /**
   * Get POS.
   */
  public function get_pos() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required'
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
    $pos = POS::where('code', Input::get('code'))->first();
    $response = array(
      'state' => 'Success',
      'pos' => $pos
    );
    return response()->json($response);
  }

  /**
   * Create Bank Loan.
   */
  public function create_loan() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'account' => 'required',
        'amount' => 'required',
        'start_date' => 'required',
        'interest' => 'required',
        'payment' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_code_required')
      );
      return response()->json($response);
    }

    // Get Bank Account.
    $bank_account = BankAccount::where('code', Input::get('code'))->first();

    // Get Account.
    $account = Account::where('code', Input::get('account'))->first();

    if($account->type != 'li') {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.liability_required')
      );
      return response()->json($response);
    }

    // Prepare dates.
    $today = Carbon::now();
    $start_date = Carbon::createFromFormat('d-m-Y', Input::get('start_date'));
    $next_payment = $start_date->toDateString();
    if($start_date->isPast()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.past_start_date')
      );
      return response()->json($response);
    }

    // Get branch identifier.
    $branch_identifier = Worker::where('code', Auth::user()->worker_code)->first()->branch_identifier();

    // Insert data into database.
    $tries = 0;
    $complete = false;
    while($tries < 5 && !$complete) {
      try {
        DB::beginTransaction();

        // First lock any data we will work with.
        $last_entry = DB::table('journal_entries')
          ->where('branch_identifier', $branch_identifier)
          ->orderBy('id', 'desc')
          ->limit(1)
          ->lockForUpdate()
          ->get();
        $last_loan = DB::table('bank_loans')
          ->orderBy('id', 'desc')
          ->limit(1)
          ->lockForUpdate()
          ->get();
        DB::table('accounts')->where('code', $bank_account->account_code)
          ->lockForUpdate();
        DB::table('accounts')->where('code', Input::get('account'))
          ->lockForUpdate();

        // Create Journal Entry.
        $entry_code = (count($last_entry) > 0) ? $last_entry[0]->code+1 : 1;
        DB::table('journal_entries')->insert([
          ['code' => $entry_code, 'branch_identifier' => $branch_identifier, 'state' => 1]
        ]);

        // Now update the accounts.
        DB::table('accounts')->where('code', $bank_account->account_code)
          ->increment('amount', Input::get('amount'));

        DB::table('accounts')->where('code', Input::get('account'))
          ->increment('amount', Input::get('amount'));

        // Make the entry breakdowns.
        DB::table('journal_entries_breakdown')->insert([
          [
            'journal_entry_code' => $entry_code,
            'branch_identifier' => $branch_identifier,
            'debit' => 1,
            'account_code' => $bank_account->account_code,
            'description' => 'Prestamo de '.$bank_account->bank_name,
            'amount' => Input::get('amount'),
          ]
        ]);

        DB::table('journal_entries_breakdown')->insert([
          [
            'journal_entry_code' => $entry_code,
            'branch_identifier' => $branch_identifier,
            'debit' => 0,
            'account_code' => Input::get('account'),
            'description' => 'Prestamo de '.$bank_account->bank_name,
            'amount' => Input::get('amount'),
          ]
        ]);

        // Finally create loan.
        $loan_code = (count($last_loan) > 0) ? $last_loan[0]->code+1 : 1;
        DB::table('bank_loans')->insert([
          'code' => $loan_code,
          'bank_account_code' => Input::get('code'),
          'account_code' => Input::get('account'),
          'start_date' => $next_payment,
          'payment_rate' => Input::get('payment'),
          'interest_rate' => Input::get('interest'),
          'interval' => Input::get('interval'),
          'next_payment' => $next_payment,
          'state' => 1,
          'journal_entry_code' => $entry_code,
          'branch_identifier' => $branch_identifier,
        ]);

        DB::commit();
        $complete = true;
      } catch(\Exception $e) {
        $tries++;
        if($tries == 5) {
          $response = array(
            'state' => 'Error',
            'error' => \Lang::get('controllers/bank_account_controller.loan_failed')
          );
          return response()->json($response);
        }
      }
    }

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/bank_account_controller.loan_created')
    );
    return response()->json($response);
  }

  /**
   * Create Cheque Book.
   */
  public function create_cheque_book() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'name' => 'required',
        'number' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/bank_account_controller.account_code_required')
      );
      return response()->json($response);
    }

    // Create Cheque Book.
    $tries = 0;
    $complete = false;
    while($tries < 5 && !$complete) {
      try {
        DB::beginTransaction();
        // First lock any data we will be working with.
        $last_cheque_book = DB::table('cheque_book')
          ->orderBy('id', 'desc')
          ->limit(1)
          ->lockForUpdate()
          ->get();

        // Now create the cheque book.
        $code = (count($last_cheque_book) > 0) ? $last_cheque_book[0]->code+1 : 1;
        DB::table('cheque_book')->insert([
          [
            'code' => $code,
            'bank_account_code' => Input::get('code'),
            'name' => Input::get('name'),
            'current_number' => Input::get('number')
          ]
        ]);
        DB::commit();
        $complete = true;
      } catch(\Exception $e) {
        $tries++;
        if($tries == 5) {
          $response = array(
            'state' => 'Error',
            'error' => \Lang::get('controllers/bank_account_controller.cheque_book_failed')
          );
          return response()->json($response);
        }
      }
    }

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/bank_account_controller.cheque_book_created')
    );
    return response()->json($response);
  }

  /**
   * Create POS.
   */
  public function create_pos() {
    $validator = Validator::make(Input::all(),
      array(
        'code' => 'required',
        'name' => 'required',
        'bank_commission' => 'required',
        'government_commission' => 'required',
        'commission_account' => 'required',
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
    $tries = 0;
    $complete = false;
    while($tries < 5 && !$complete) {
      try {
        DB::beginTransaction();
        // First lock any data we will be working with.
        $last_pos = DB::table('pos')
          ->orderBy('id', 'desc')
          ->limit(1)
          ->lockForUpdate()
          ->get();

        // Now create the pos.
        $code = (count($last_pos) > 0) ? $last_pos[0]->code+1 : 1;
        DB::table('pos')->insert([
          [
            'code' => $code,
            'bank_account_code' => Input::get('code'),
            'name' => Input::get('name'),
            'bank_commission' => Input::get('bank_commission'),
            'government_commission' => Input::get('government_commission'),
            'commission_account' => Input::get('commission_account')
          ]
        ]);
        DB::commit();
        $complete = true;
      } catch(\Exception $e) {
        $tries++;
        if($tries == 5) {
          $response = array(
            'state' => 'Error',
            'error' => \Lang::get('controllers/bank_account_controller.pos_failed')
          );
          return response()->json($response);
        }
      }
    }

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/bank_account_controller.pos_created')
    );
    return response()->json($response);
  }

  /**
   * Search for Bank Account.
   */
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

  /**
   * Suggest Bank Accounts.
   */
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

  /**
   * Create Bank Accounts.
   */
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
    $tries = 0;
    $bank_account_id = 0;
    $complete = false;
    while($tries < 5 && !$complete) {
      try {
        DB::beginTransaction();
        // First lock any data we will be working with.
        $last_bank_account = DB::table('bank_accounts')
          ->orderBy('id', 'desc')
          ->limit(1)
          ->lockForUpdate()
          ->get();

        // Now bank account.
        $code = (count($last_bank_account) > 0) ? $last_bank_account[0]->code+1 : 1;
        $bank_account_id = DB::table('bank_accounts')->insertGetId(
          [
            'code' => $code,
            'bank_name' => Input::get('account')['bank_name'],
            'account_number' => Input::get('account')['number'],
            'account_code' => Input::get('account')['account'],
          ]
        );

        DB::commit();
        $complete = true;
      } catch(\Exception $e) {
        $tries++;
        if($tries == 5) {
          $response = array(
            'state' => 'Error',
            'error' => \Lang::get('controllers/bank_account_controller.account_failed')
          );
          return response()->json($response);
        }
      }
    }

    $bank_account = BankAccount::find($bank_account_id);
    $response = array(
      'state' => 'Success',
      'bank_account' => $bank_account,
      'message' => \Lang::get('controllers/bank_account_controller.account_created')
    );
    return response()->json($response);
  }
}
