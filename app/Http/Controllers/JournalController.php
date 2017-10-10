<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use DB;
use App\JournalEntry;
use App\JournalEntryBreakdown;
use App\Account;
use App\Report;
class JournalController extends Controller
{
  public function generate_report() {
    $validator = Validator::make(Input::all(),
      array(
        'report' => 'required',
        'date_range' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    $report = Report::where('id', Input::get('report'))->first();

    if(!$report) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.report_not_found')
      );
      return response()->json($response);
    }

    // Explode date range.
    $date_range = Input::get('date_range');
    $date_range = explode(' - ', $date_range);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    $report->layout = json_decode($report->layout);
    $report->variables = json_decode($report->variables);

    // Return view.
    return view('system.components.accounting.report',
     [
       'report' => $report,
       'date_range' => $date_range,
    ]);
  }

  public function edit_report() {
    $validator = Validator::make(Input::all(),
      array(
        'report' => 'required',
        'name' => 'required',
        'variables' => 'required',
        'layout' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    // TODO: Do not rely on javascript checks.

    $report = Report::where('id', Input::get('report'))->first();

    if(!$report) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.report_not_found')
      );
      return response()->json($response);
    }

    $report->name = Input::get('name');
    $report->layout = json_encode(Input::get('layout'));
    $report->variables = json_encode(Input::get('variables'));
    $report->save();

    $response = array(
      'state' => 'Success',
      'report' => $report,
    );
    return response()->json($response);
  }

  public function load_report() {
    $validator = Validator::make(Input::all(),
      array(
        'report' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    $report = Report::where('id', Input::get('report'))->first();

    if(!$report) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.report_not_found')
      );
      return response()->json($response);
    }

    $report->layout = json_decode($report->layout);
    $report->variables = json_decode($report->variables);
    $response = array(
      'state' => 'Success',
      'report' => $report,
    );
    return response()->json($response);
  }

  public function create_report() {
    $validator = Validator::make(Input::all(),
      array(
        'name' => 'required',
        'variables' => 'required',
        'layout' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    // TODO: We should not depend on JS checks.
    $report = Report::create(array(
      'name' => Input::get('name'),
      'variables' => json_encode(Input::get('variables')),
      'layout' => json_encode(Input::get('layout'))
    ));

    $response = array(
      'state' => 'Success',
      'report' => $report,
      'message' => \Lang::get('controllers/journal_controller.report_created')
    );
    return response()->json($response);
  }

  public function create_entries() {
    $validator = Validator::make(Input::all(),
      array(
        'entries' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    // Make sure all accounts exist and that debits and credits add up.
    $entries = Input::get('entries');
    $debit = 0;
    $credit = 0;
    $accounts = array();
    foreach($entries as $entry) {
      $debit += ($entry['type'] == 'debit') ? $entry['amount'] : 0;
      $credit += ($entry['type'] == 'credit') ? $entry['amount'] : 0;
      $account = Account::where('code', $entry['account'])->first();
      if(!$account) {
        $response = array(
          'state' => 'Error',
          'error' => \Lang::get('controllers/journal_controller.account_not_found')
        );
        return response()->json($response);
      }
      array_push($accounts, $entry['account']);
    }

    if($credit != $debit) {
      $response = array(
        'state' => 'Error',
        'credit' => $credit,
        'debit' => $debit,
        'error' => \Lang::get('controllers/journal_controller.credit_debit_mismatch')
      );
      return response()->json($response);
    }

    $tries = 0;
    $complete = false;
    while($tries < 5 && !$complete) {
      try {
        DB::beginTransaction();
        // First lock any data we will be working with.
        $last_entry = DB::table('journal_entries')
          ->orderBy('id', 'desc')
          ->limit(1)
          ->lockForUpdate()
          ->get();
        $locked_accounts = DB::table('accounts')
          ->whereIn('code', $accounts)
          ->lockForUpdate()
          ->get();

        $entry_code = (count($last_entry) > 0) ? $last_entry[0]->code+1 : 1;
        DB::table('journal_entries')->insert([
          ['code' => $entry_code, 'state' => 1]
        ]);

        // Create entry breakdown.
        foreach($entries as $entry) {
          // Get account.
          $account = Account::where('code', $entry['account'])->first();

          // Update Account.
          if(in_array($account->type, array('li', 'eq', 're'))) {
            if($entry['type'] == 'debit') {
              DB::table('accounts')->where('code', $entry['account'])
                ->decrement('amount', $entry['amount']);
            } else {
              DB::table('accounts')->where('code', $entry['account'])
                ->increment('amount', $entry['amount']);
            }
          } else {
            if($entry['type'] == 'debit') {
              DB::table('accounts')->where('code', $entry['account'])
                ->increment('amount', $entry['amount']);
            } else {
              DB::table('accounts')->where('code', $entry['account'])
                ->decrement('amount', $entry['amount']);
            }
          }
          $balance = DB::table('accounts')->where('code', $entry['account'])
            ->first()->amount;

          // Make the entry breakdown.
          DB::table('journal_entries_breakdown')->insert([
            [
              'journal_entry_code' => $entry_code,
              'debit' => ($entry['type'] == 'debit') ? 1 : 0,
              'account_code' => $entry['account'],
              'description' => $entry['description'],
              'amount' => $entry['amount'],
              'balance' => $balance
            ]
          ]);
        }
        DB::commit();
        $complete = true;
      } catch(\Exception $e) {
        $tries++;
        if($tries == 5) {
          $response = array(
            'state' => 'Error',
            'error' => \Lang::get('controllers/journal_controller.create_entries_failed')
          );
          return response()->json($response);
        }
      }
    }

    $response = array(
      'state' => 'Success',
      'message' => \Lang::get('controllers/journal_controller.created_entries')
    );
    return response()->json($response);
  }

  private function sum_children($journal, $code) {
    // Check if this element has been added.
    if(!$journal[$code]['added']) {
      // Check if it has children.
      if($journal[$code]['children']) {
        foreach($journal as $entry_code => $entry) {
          if($entry['parent'] == $code) {
            if($journal[$entry_code]['added']) {
              $journal[$code]['initial'] += $entry['initial'];
              $journal[$code]['final'] += $entry['final'];
              $journal[$code]['credit'] += $entry['credit'];
              $journal[$code]['debit'] += $entry['debit'];
            } else {
              $sums = $this->sum_children($journal, $entry_code);
              $journal[$code]['initial'] += $sums['initial'];
              $journal[$code]['final'] += $sums['final'];
              $journal[$code]['credit'] += $sums['credit'];
              $journal[$code]['debit'] += $sums['debit'];
            }
          }
        }
      }
    }
    $journal[$code]['added'] = true;
    return $journal[$code];
  }

  public function search_entries() {
    $validator = Validator::make(Input::all(),
      array(
        'type' => 'required',
        'date_range' => 'required',
        'offset' => 'required',
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    // Explode date range.
    $date_range = Input::get('date_range');
    $date_range = explode(' - ', $date_range);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    // Return view.
    return view('system.components.accounting.journal_table',
     [
       'type' => Input::get('type'),
       'date_range' => $date_range,
       'offset' => Input::get('offset')
    ]);
  }

  public function download_entries() {
    /*
    $validator = Validator::make(Input::all(),
      array(
        'type' => 'required',
        'date_range' => 'required',
      )
    );
    */
    $validator = Validator::make(Input::all(),
      array(
        'entries_data' => 'required'
      )
    );
    if($validator->fails()) {
      $response = array(
        'state' => 'Error',
        'error' => \Lang::get('controllers/journal_controller.data_required')
      );
      return response()->json($response);
    }

    // Explode date range.
    $entries_data = json_decode(Input::get('entries_data'));
    $date_range = explode(' - ', $entries_data->date_range);
    $type = $entries_data->type;
    //$date_range = Input::get('date_range');
    //$type = Input::get('type');
    //$date_range = explode(' - ', $date_range);
    $date_range[0] = date('Y-m-d H:i:s', strtotime($date_range[0]));
    $date_range[1] = date('Y-m-d H:i:s', strtotime($date_range[1].' 23:59:59'));

    // Get journal data.
    $journal = array();
    $entries = array();
    switch($type) {
      case 'detail':
        $journal = DB::table('journal_entries')
          ->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
          ->select('journal_entries.*', 'journal_entries_breakdown.*')
          ->whereBetween('journal_entries.entry_date', $date_range)->get();
        break;
      case 'summary':
        $accounts = \App\Account::where('code', '!=', 0)
          ->orderBy('code')
          //->orderBy('type')
          ->get();

        foreach($accounts as $account) {
          $journal[$account->code] = array(
              'name' => $account->name,
              'initial' => $account->amount,
              'final' => $account->amount,
              'credit' => 0,
              'debit' => 0,
              'added' => (!$account->has_children) ? true : false,
              'first_found' => false,
              'type' => $account->type,
              'children' => $account->has_children,
              'parent' => $account->parent_account,
            );
        }

        $entries = DB::table('journal_entries')
          ->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
          ->select('journal_entries_breakdown.*')
          ->whereBetween('journal_entries.entry_date', $date_range)
          ->get();

        foreach($entries as $entry) {
          // Check if this is the first time we found an entry for this account.
          if(!$journal[$entry->account_code]['first_found']) {
            // Update it account data.
            $journal[$entry->account_code]['first_found'] = true;

            // Check if it's a debit transaction and update account data based on
            // Account type.
            if($entry->debit) {
              if(in_array($journal[$entry->account_code]['type'], array('li', 'eq', 're'))) {
                $journal[$entry->account_code]['initial'] = $entry->balance+$entry->amount;
              } else {
                $journal[$entry->account_code]['initial'] = $entry->balance-$entry->amount;
              }
              $journal[$entry->account_code]['debit'] += $entry->amount;
            } else {
              if(in_array($journal[$entry->account_code]['type'], array('li', 'eq', 're'))) {
                $journal[$entry->account_code]['initial'] = $entry->balance-$entry->amount;
              } else {
                $journal[$entry->account_code]['initial'] = $entry->balance+$entry->amount;
              }
              $journal[$entry->account_code]['credit'] += $entry->amount;
            }
            $journal[$entry->account_code]['final'] = $entry->balance;
          } else {
            if($entry->debit) {
              $journal[$entry->account_code]['debit'] += $entry->amount;
            } else {
              $journal[$entry->account_code]['credit'] += $entry->amount;
            }
            $journal[$entry->account_code]['final'] = $entry->balance;
          }
        }

        foreach($journal as $code => $entry) {
          if(!$journal[$code]['added']) {
            $sums = $this->sum_children($journal, $code);
            $journal[$code]['initial'] += $sums['initial'];
            $journal[$code]['final'] += $sums['final'];
            $journal[$code]['credit'] += $sums['credit'];
            $journal[$code]['debit'] += $sums['debit'];
          }
        }
        break;
    }

    // Prepare headers.
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=".(($type == 'detail') ? \Lang::get('controllers/journal_controller.detailed_report') : \Lang::get('controllers/journal_controller.summary_report')).".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $columns = array();
    if($type == 'detail') {
      $columns = array(\Lang::get('controllers/journal_controller.date'), \Lang::get('controllers/journal_controller.account_code'),
        \Lang::get('controllers/journal_controller.description'), \Lang::get('controllers/journal_controller.debit'),
        \Lang::get('controllers/journal_controller.credit'), \Lang::get('controllers/journal_controller.balance')
      );
    } else {
      $columns = array(\Lang::get('controllers/journal_controller.account_code'), \Lang::get('controllers/journal_controller.account_name'),
        \Lang::get('controllers/journal_controller.initial'), \Lang::get('controllers/journal_controller.debit'),
        \Lang::get('controllers/journal_controller.credit'), \Lang::get('controllers/journal_controller.final'),
      );
    }
    $callback = function() use ($journal, $columns, $type) {
      $file = fopen('php://output', 'w');
      fputcsv($file, $columns);
      if($type == 'detail') {
        foreach($journal as $entry) {
          fputcsv($file, array($entry->entry_date, $entry->account_code,
            $entry->description, ($entry->debit) ? $entry->amount : '',
            (!$entry->debit) ? $entry->amount : '', $entry->balance));
        }
      } else {
        foreach($journal as $code => $entry) {
          fputcsv($file, array($code, $entry['name'], $entry['initial'],
            $entry['debit'], $entry['credit'], $entry['final'])
          );
        }
      }
      fclose($file);
    };

    return response()->stream($callback, 200, $headers);
  }
}
