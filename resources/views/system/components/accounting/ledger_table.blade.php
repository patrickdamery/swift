@php
  // Get the journal entries.
  $ledger = DB::table('journal_entries')
    ->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
    ->select('journal_entries.*', 'journal_entries_breakdown.*')
    ->where('journal_entries_breakdown.account_code', $code)
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
        <tr id="entry-code-{{ $entry->code }}">
          <td>{{ $entry->entry_date }}</td>
          <td class="editable ledger-description">{{ $entry->description }}</td>
          <td>{{ ($entry->debit == 1) ? $entry->amount : '' }}</td>
          <td>{{ ($entry->debit == 0) ? $entry->amount : '' }}</td>
          <td>{{ $entry->balance }}</td>
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
