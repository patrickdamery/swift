@php

  function sum_children($journal, $code) {
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
              $sums = sum_children($journal, $entry_code);
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

  $journal = array();
  $entries = array();
  $max = 50;
  switch($type) {
    case 'detail':
      $journal = DB::table('journal_entries')
        ->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
        ->select('journal_entries.*', 'journal_entries_breakdown.*')
        ->whereBetween('journal_entries.entry_date', $date_range);
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
          $sums = sum_children($journal, $code);
          $journal[$code]['initial'] += $sums['initial'];
          $journal[$code]['final'] += $sums['final'];
          $journal[$code]['credit'] += $sums['credit'];
          $journal[$code]['debit'] += $sums['debit'];
        }
      }
      break;
  }

  $records = count($journal);
  $pages = ceil($records/$max);

  if($offset == 'first') {
    $offset = 0;
  } else if ($offset == 'last') {
    $offset = $pages-1;
  } else {
    $offset--;
  }
  if($type == 'detail') {
    $journal = $journal->offset($offset*$max)
    ->limit($max)
    ->get();
  }
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('accounting/journal.entries')</h3>
  <br>
  @if($type == 'detail')
    <span>@lang('accounting/journal.detailed_period')
  @else
    <span>@lang('accounting/journal.summary_period')
  @endif
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
            <th>@lang('accounting/journal.balance')</th>
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
      @php
        $count = 0;
      @endphp
      @switch($type)
        @case('detail')
          @foreach($journal as $entry)
            <tr class="journal-entry-row" id="entry-{{ $entry->code }}">
              <td>{{ date('d/m/Y h:i:s a', strtotime($entry->entry_date)) }}</td>
              <td>{{ $entry->account_code }}</td>
              <td>{{ $entry->description }}</td>
              <td>{{ ($entry->debit) ? $entry->amount : '' }}</td>
              <td>{{ (!$entry->debit) ? $entry->amount : '' }}</td>
              <td>{{ $entry->balance }}</td>
            </tr>
          @endforeach
          @break
        @case('summary')
          @foreach($journal as $code => $entry)
            @if($count > $offset*$max && $count < $max+($offset*$max))
              <tr class="journal-entry-row">
                <td>{{ $code }}</td>
                <td>{{ $entry['name'] }}</td>
                <td>{{ $entry['initial'] }}</td>
                <td>{{ $entry['debit'] }}</td>
                <td>{{ $entry['credit'] }}</td>
                <td>{{ $entry['final'] }}</td>
              </tr>
            @endif
            @php
              $count++;
            @endphp
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
