@php
  // Get all children accounts.
  $account = \App\Account::where('code', $code)->first();
  $account_codes = $account->children_codes();

  // Get Initial Balance
  $account_balance = 0;
  $initial_balance = DB::table('account_history_breakdown')
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
  $entries = DB::table('journal_entries')
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
  $ledger = DB::table('journal_entries')
    //->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
    ->join('journal_entries_breakdown', function($join){
      $join->on('journal_entries.code', 'journal_entries_breakdown.journal_entry_code');
      $join->on('journal_entries.branch_identifier', 'journal_entries_breakdown.branch_identifier');
    })
    ->select('journal_entries.*', 'journal_entries_breakdown.*')
    ->whereIn('journal_entries_breakdown.account_code', $account_codes)
    ->whereBetween('journal_entries.entry_date', $date_range)
    ->get();
@endphp
<div class="printable-document">
  <div class="printable-header">
    <div class="ledger-report">
      <h3>@lang('accounting/accounts.ledger_report')</h3>
    </div>
    <div class="ledger-account">
      <p>@lang('accounting/accounts.ledger_account'): {{ \App\Account::where('code', $code)->first()->name }}</p>
    </div>
    <div class="ledger-date-range">
      <p>@lang('accounting/accounts.date_range'):
        {{ date('d/m/Y', strtotime($date_range[0])) }} - {{ date('d/m/Y', strtotime($date_range[1])) }}
      </p>
    </div>
  </div>
  <div class="printable-body">
    <table class="ledger">
      <tr>
        <th>@lang('accounting/accounts.date')</th>
        <th>@lang('accounting/accounts.description')</th>
        <th>@lang('accounting/accounts.debit')</th>
        <th>@lang('accounting/accounts.credit')</th>
        <th>@lang('accounting/accounts.value')</th>
      </tr>
      <tbody>
      @foreach($ledger as $entry)
      @php
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
      @endphp
        <tr id="entry-code-{{ $entry->code }}">
          <td>{{ $entry->entry_date }}</td>
          <td>{{ $entry->description }}</td>
          <td>{{ ($entry->debit == 1) ? $entry->amount : '' }}</td>
          <td>{{ ($entry->debit == 0) ? $entry->amount : '' }}</td>
          <td>{{ $account_balance }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>
