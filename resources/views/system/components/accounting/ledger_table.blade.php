@php
  if($code == '') {
    return;
  }
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
    ->whereBetween('journal_entries.entry_date', $date_range);

  $records = $ledger->count();
  $pages = ceil($records/100);

  if($offset == 'first') {
    $offset = 0;
  } else if ($offset == 'last') {
    $offset = $pages-1;
  } else {
    $offset--;
  }
  $ledger = $ledger->offset($offset*100)
    ->limit(100)
    ->get()
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('accounting/accounts.ledger')</h3>
</div>
<div class="box-body table-responsive no-padding swift-table">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>@lang('accounting/accounts.date')</th>
        <th>@lang('accounting/accounts.description')</th>
        <th>@lang('accounting/accounts.debit')</th>
        <th>@lang('accounting/accounts.credit')</th>
        <th>@lang('accounting/accounts.value')</th>
      </tr>
    </thead>
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
          <td class="editable ledger-description">{{ $entry->description }}</td>
          <td>{{ ($entry->debit == 1) ? $entry->amount : '' }}</td>
          <td>{{ ($entry->debit == 0) ? $entry->amount : '' }}</td>
          <td>{{ $account_balance }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="box-footer clearfix">
  <ul class="pagination pagination-sm no-margin pull-right ledger-pagination">
    <li><a href="#" id="ledger-pagination-first">«</a></li>
    @if($offset+1 == 1)
      <li><a href="#" id="ledger-pagination-1">1</a></li>
      @for($i = 2; $i <= $pages; $i++)
        @if($i < 4)
          <li><a href="#" id="ledger-pagination-{{ $i }}">{{ $i }}</a></li>
        @endif
      @endfor
    @else
      <li><a href="#" id="ledger-pagination-{{ $offset }}">{{ $offset }}</a></li>
      <li><a href="#" id="ledger-pagination-{{ $offset+1 }}">{{ $offset+1 }}</a></li>
      @if($offset+2 <= $pages)
        <li><a href="#" id="ledger-pagination-{{ $offset+2 }}">{{ $offset+2 }}</a></li>
      @endif
    @endif
    <li><a href="#" id="ledger-pagination-last">»</a></li>
  </ul>
</div>
