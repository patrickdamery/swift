@php
  $transactions = \App\BankAccountTransaction::where('bank_account_code', $account_search['code'])
    ->whereBetween('transaction_date', $account_search['date_range']);
  $records = $transactions->count();
  $pages = ceil($records/50);

  $offset = $account_search['offset'];
  if($offset == 'first') {
    $offset = 0;
  } else if ($offset == 'last') {
    $offset = $pages-1;
  } else {
    $offset--;
  }

  $transactions = $transactions->offset($offset*50)
    ->limit(50)
    ->get();
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('accounting/bank_accounts.transactions')</h3>
</div>
<div class="box-body table-responsive no-padding swift-table">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>@lang('accounting/bank_accounts.date')</th>
        <th>@lang('accounting/bank_accounts.description')</th>
        <th>@lang('accounting/bank_accounts.type')</th>
        <th>@lang('accounting/bank_accounts.value')</th>
      </tr>
    </thead>
    <tbody>
      @foreach($transactions as $transaction)
        <tr id="{{ $transaction->code }}">
          <td>{{ $transaction->transaction_date }}</td>
          <td class="editable bank-account-transaction-reason">{{ $transaction->reason }}</td>
          <td>{{ convert_type($transaction->type) }}</td>
          <td>{{ $transaction->transaction_value }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="box-footer clearfix">
  <ul class="pagination pagination-sm no-margin pull-right bank-accounts-pagination">
    <li><a href="#" id="bank-accounts-pagination-first">«</a></li>
    @if($offset+1 == 1)
      <li><a href="#" id="bank-accounts-pagination-1">1</a></li>
      @for($i = 2; $i <= $pages; $i++)
        @if($i < 4)
          <li><a href="#" id="bank-accounts-pagination-{{ $i }}">{{ $i }}</a></li>
        @endif
      @endfor
    @else
      <li><a href="#" id="bank-accounts-pagination-{{ $offset }}">{{ $offset }}</a></li>
      <li><a href="#" id="bank-accounts-pagination-{{ $offset+1 }}">{{ $offset+1 }}</a></li>
      @if($offset+2 <= $pages)
        <li><a href="#" id="bank-accounts-pagination-{{ $offset+2 }}">{{ $offset+2 }}</a></li>
      @endif
    @endif
    <li><a href="#" id="bank-accounts-pagination-last">»</a></li>
  </ul>
</div>
