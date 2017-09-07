@php
$currencies = \App\Currency::where('id', '>', 0);
$records = $currencies->count();
$pages = ceil($records/10);

if($offset == 'first') {
  $offset = 0;
} else if ($offset == 'last') {
  $offset = $pages-1;
} else {
  $offset--;
}

$currencies = $currencies->offset($offset*10)
  ->limit(10)
  ->get();
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('accounting/currency.title')</h3>
</div>
<div class="box-body table-responsive no-padding swift-table">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>@lang('accounting/currency.code')</th>
        <th>@lang('accounting/currency.description')</th>
        <th>@lang('accounting/currency.exchange_rate')</th>
        <th>@lang('accounting/currency.buy_rate')</th>
      </tr>
    </thead>
    <tbody>
      @foreach($currencies as $currency)
        <tr id="currency-{{ $currency->code }}">
          <td>{{ $currency->code }}</td>
          <td class="description-rate editable">{{ $currency->description }}</td>
          <td class="exchange-rate editable">{{ round($currency->exchange_rate, 4) }}</td>
          <td class="buy-rate editable">{{ round($currency->buy_rate, 4) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="box-footer clearfix">
  <ul class="pagination pagination-sm no-margin pull-right currency-pagination">
    <li><a href="#" id="currency-pagination-first">«</a></li>
    @if($offset+1 == 1)
      <li><a href="#" id="currency-pagination-1">1</a></li>
      @for($i = 2; $i <= $pages; $i++)
        @if($i < 4)
          <li><a href="#" id="currency-pagination-{{ $i }}">{{ $i }}</a></li>
        @endif
      @endfor
    @else
      <li><a href="#" id="currency-pagination-{{ $offset }}">{{ $offset }}</a></li>
      <li><a href="#" id="currency-pagination-{{ $offset+1 }}">{{ $offset+1 }}</a></li>
      @if($offset+2 <= $pages)
        <li><a href="#" id="currency-pagination-{{ $offset+2 }}">{{ $offset+2 }}</a></li>
      @endif
    @endif
    <li><a href="#" id="currency-pagination-last">»</a></li>
  </ul>
</div>
