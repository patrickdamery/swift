<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Carbon;

use App\BankAccount;
use App\Account;
use App\POS;
use App\ChequeBook;
use App\JournalEntry;
use App\JournalEntryBreakdown;
use App\BankLoan;
class BankAccountController extends Controller
{

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

    // Create Journal Entry.
    $last_entry = JournalEntry::orderBy('id', 'desc')->first();
    $entry_code = ($last_entry) ? $last_entry->code : 0;

    $entry = JournalEntry::create(array(
      'code' => $entry_code+1,
      'state' => 1
    ));

    // Now create the Loan.
    $entry_breakdown = JournalEntryBreakdown::create(array(
      'journal_entry_code' => $entry->code,
      'debit' => 1,
      'account_code' => $bank_account->account_code,
      'description' => 'Prestamo de '.$bank_account->bank_name,
      'amount' => Input::get('amount'),
      'balance' => 0
    ));

    $entry_account = Account::where('code', $bank_account->account_code)->first();
    $entry_account->amount += Input::get('amount');
    $entry_account->save();

    $entry_breakdown->balance = $entry_account->amount;
    $entry_breakdown->save();

    $entry_breakdown = JournalEntryBreakdown::create(array(
      'journal_entry_code' => $entry->code,
      'debit' => 0,
      'account_code' => Input::get('account'),
      'description' => 'Prestamo de '.$bank_account->bank_name,
      'amount' => Input::get('amount'),
      'balance' => 0
    ));

    $entry_account = Account::where('code', Input::get('account'))->first();
    $entry_account->amount += Input::get('amount');
    $entry_account->save();

    $entry_breakdown->balance = $entry_account->amount;
    $entry_breakdown->save();

    $last_bank_loan = BankLoan::orderBy('id', 'desc')->first();
    $code = ($last_bank_loan) ? $last_bank_loan->code : 0;

    $today = strtotime("now");
    $date = new DateTime('2000-01-01');
    $date->add(new DateInterval('P10D'));
    echo $date->format('Y-m-d')
    $start_date = strtotime(Input::get('start_date'));
    $next_payment = $start_date;
    if($start_date < $today) {
      switch(Input::get('interval')) {
        case 'weekly':
          $day = date('D', $start_date);
          $next_payment = strtotime("+7 day", date('Y-m-').$day);
        break;
        case 'biweekly':
          $day = date('D', $start_date);
          $next_payment = strtotime("+14 day", date('Y-m-').$day);
        break;
        case 'monthly':
          $month = date('M', $start_date);
          $next_payment = strtotime("+1 month", date('Y-').$month.date('-d'));
        break;
        case 'bimester':

        break;
        case 'trimester':

        break;
        case 'semester':

        break;
        case 'annualy':

        break;
      }
    }

    $bank_loan = BankLoan::create(array(
      'code' => $code+1,
      'bank_account_code' => Input::get('code'),
      'account_code' => Input::get('account'),
      'start_date' => Input::get('start_date'),
      'payment_rate' => Input::get('payment_rate'),
      'interest_rate' => Input::get('interest_rate'),
      'interval' => Input::get('interval'),
      'next_payment' => $next_payment,
      'state' => 1,
      'journal_entry_code' => $entry->code,
    ));

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/bank_account_controller.loan_created')
    );
    return response()->json($response);
  }

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
    $last_cheque_book = ChequeBook::orderBy('id', 'desc')->first();
    $code = ($last_cheque_book) ? $last_cheque_book->code : 0;
    $cheque_book = ChequeBook::create(array(
      'code' => $code+1,
      'bank_account_code' => Input::get('code'),
      'name' => Input::get('name'),
      'current_number' => Input::get('number')
    ));

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/bank_account_controller.cheque_book_created')
    );
    return response()->json($response);
  }

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
