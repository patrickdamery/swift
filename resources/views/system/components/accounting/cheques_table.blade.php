@php

  $cheques = array();
  $pages = 1;
  if(isset($code)) {
    $cheques = DB::table('journal_entries')
      ->join('cheques', 'journal_entries.code', 'cheques.journal_entry_code')
      ->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
      ->select('journal_entries.*', 'cheques.*', 'journal_entries_breakdown.*')
      ->where('cheques.cheque_book_code', $code)
      ->where('journal_entries_breakdown.debit', 0)
      ->whereBetween('journal_entries.entry_date', $date_range);
    $records = $cheques->count();
    $pages = ceil($records/20);
  }

  $offset = (isset($offset)) ? $offset : 0;

  if($offset == 'first') {
    $offset = 0;
  } else if ($offset == 'last') {
    $offset = $pages-1;
  } else {
    $offset--;
  }
  if(isset($code)) {
    $cheques = $cheques->offset($offset*20)
      ->limit(20)
      ->get();
  }
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('accounting/create_cheque_book.cheques')</h3>
</div>
<div class="box-body table-responsive no-padding swift-table">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>@lang('accounting/create_cheque_book.date')</th>
        <th>@lang('accounting/create_cheque_book.cheque_number')</th>
        <th>@lang('accounting/create_cheque_book.reason')</th>
        <th>@lang('accounting/create_cheque_book.amount')</th>
      </tr>
    </thead>
    <tbody>
      @foreach($cheques as $cheque)
        <tr class="cheque-row" id="cheque-{{ $cheque->code }}">
          <td>{{ date('d-m-Y', strtotime($cheque->entry_date)) }}</td>
          <td>{{ $cheque->cheque_number }}</td>
          <td>{{ $cheque->description }}</td>
          <td>{{ $cheque->amount }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="box-footer clearfix">
  <ul class="pagination pagination-sm no-margin pull-right cheque-pagination">
    <li><a href="#" id="cheque-pagination-first">«</a></li>
    @if($offset+1 == 1)
      <li><a href="#" id="cheque-pagination-1">1</a></li>
      @for($i = 2; $i <= $pages; $i++)
        @if($i < 4)
          <li><a href="#" id="cheque-pagination-{{ $i }}">{{ $i }}</a></li>
        @endif
      @endfor
    @else
      <li><a href="#" id="cheque-pagination-{{ $offset }}">{{ $offset }}</a></li>
      <li><a href="#" id="cheque-pagination-{{ $offset+1 }}">{{ $offset+1 }}</a></li>
      @if($offset+2 <= $pages)
        <li><a href="#" id="cheque-pagination-{{ $offset+2 }}">{{ $offset+2 }}</a></li>
      @endif
    @endif
    <li><a href="#" id="cheque-pagination-last">»</a></li>
  </ul>
</div>
