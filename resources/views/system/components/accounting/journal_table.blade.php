@php
  $journal = array();
  $entries = array();
  switch($type) {
    case 'detail':
      $entries = DB::table('journal_entries')
        ->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
        ->select('journal_entries.*', 'journal_entries_breakdown.*')
        ->whereBetween('journal_entries.entry_date', $date_range);
      break;
    case 'summary':
      $accounts = \App\Account::where('code', '!=', 0)
        ->orderBy('code')
        ->orderBy('code')
        ->get();

      foreach($accounts as $account) {
        $journal[$account->code] = array(
            'name' => $account->name,
            'initial' => $account->amount,
            'final' => $account->amount,
            'credit' => 0,
            'debit' => 0,
            'first_found' => 0,
            'type' => $account->type,
            'children' => $account->has_children,
          );
      }

      $entries = DB::table('journal_entries')
        ->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
        ->select('journal_entries_breakdown.*')
        ->whereBetween('journal_entries.entry_date', $date_range)
        ->get();

      foreach($entries as $entry) {
        if($journal[$entry->account_code]['first_found'] == 0) {
          $journal[$entry->account_code]['first_found'] = 1;
          if($entry->debit) {
            $journal[$entry->account_code]['credit'] += $entry->amount;
          } else {
            $journal[$entry->account_code]['debit'] += $entry->amount;
          }
          if(in_array($journal[$entry->account_code]['type'], array('li', 'eq', 're'))) {
            if($entry->debit) {
              $journal[$entry->account_code]['initial'] = $entry->balance+$entry->amount;
            } else {
              $journal[$entry->account_code]['initial'] = $entry->balance-$entry->amount;
            }
          } else {
            if($entry->debit) {
              $journal[$entry->account_code]['initial'] = $entry->balance-$entry->amount;
            } else {
              $journal[$entry->account_code]['initial'] = $entry->balance+$entry->amount;
            }
          }
          $journal[$entry->account_code]['final'] = $entry->balance;
        } else {
          if($entry->debit) {
            $journal[$entry->account_code]['credit'] += $entry->amount;
          } else {
            $journal[$entry->account_code]['debit'] += $entry->amount;
          }
          $journal[$entry->account_code]['final'] = $entry->balance;
        }
      }
      break;
  }

  $records = count($journal);
  $pages = ceil($records/50);

  if($offset == 'first') {
    $offset = 0;
  } else if ($offset == 'last') {
    $offset = $pages-1;
  } else {
    $offset--;
  }
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('accounting/journal.entries')</h3>
  <br>
  <span>@lang('accounting/journal.period')
    {{ date('d-m-Y', strtotime($date_range[0])) }} - {{ date('d-m-Y', strtotime($date_range[1])) }}</span>
</div>
<div class="box-body table-responsive no-padding swift-table">
  <table class="table table-hover">
    <thead>
      @switch($type)
        @case('detail')
          <tr>
            <th>@lang('accounting/journal.date')</th>
            <th>@lang('accounting/journal.account_code')</th>
            <th>@lang('accounting/journal.description')</th>
            <th>@lang('accounting/journal.debit')</th>
            <th>@lang('accounting/journal.credit')</th>
          </tr>
          @break
        @case('summary')
          <tr>
            <th>@lang('accounting/journal.account_code')</th>
            <th>@lang('accounting/journal.account_name')</th>
            <th>@lang('accounting/journal.initial')</th>
            <th>@lang('accounting/journal.debit')</th>
            <th>@lang('accounting/journal.credit')</th>
            <th>@lang('accounting/journal.final')</th>
          </tr>
        @break
      @endswitch
    </thead>
    <tbody>
      @switch($type)
        @case('detail')
          @foreach($journal as $entry)
            <tr class="journal-entry-row" id="entry-{{ $entry->code }}">
              <td colspan="4">{{ print_r($entry) }}</td>
            </tr>
          @endforeach
          @break
        @case('summary')
          @foreach($journal as $code => $entry)
            <tr class="journal-entry-row">
              <td>{{ $code }}</td>
              <td>{{ $entry['name'] }}</td>
              <td>{{ $entry['initial'] }}</td>
              <td>{{ $entry['debit'] }}</td>
              <td>{{ $entry['credit'] }}</td>
              <td>{{ $entry['final'] }}</td>
            </tr>
          @endforeach
          @break
      @endswitch
    </tbody>
  </table>
</div>
<div class="box-footer clearfix">
  <ul class="pagination pagination-sm no-margin pull-right journal-pagination">
    <li><a href="#" id="journal-pagination-first">«</a></li>
    @if($offset+1 == 1)
      <li><a href="#" id="journal-pagination-1">1</a></li>
      @for($i = 2; $i <= $pages; $i++)
        @if($i < 4)
          <li><a href="#" id="journal-pagination-{{ $i }}">{{ $i }}</a></li>
        @endif
      @endfor
    @else
      <li><a href="#" id="journal-pagination-{{ $offset }}">{{ $offset }}</a></li>
      <li><a href="#" id="journal-pagination-{{ $offset+1 }}">{{ $offset+1 }}</a></li>
      @if($offset+2 <= $pages)
        <li><a href="#" id="journal-pagination-{{ $offset+2 }}">{{ $offset+2 }}</a></li>
      @endif
    @endif
    <li><a href="#" id="journal-pagination-last">»</a></li>
  </ul>
</div>
