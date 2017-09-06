@php
// Get variations.
$currency_variations = \App\CurrencyExchange::whereBetween('exchange_date', $date_range)
  ->where('currency_code', $code);
$records = $currency_variations->count();

$pages = ceil($records/100);

if($offset == 'first') {
  $offset = 0;
} else if ($offset == 'last') {
  $offset = $pages-1;
} else {
  $offset--;
}

$currency_variations = $currency_variations->offset($offset*100)
  ->limit(100)
  ->get();
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('accounting/currency.variations')</h3>
</div>
<div class="box-body table-responsive no-padding swift-table">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>@lang('accounting/currency.date')</th>
        <th>@lang('accounting/currency.exchange_rate')</th>
        <th>@lang('accounting/currency.buy_rate')</th>
      </tr>
    </thead>
    <tbody>
      @foreach($currency_variations as $variation)
        <tr id="variation-{{ $variation->code }}">
          <td>{{ date('d/m/Y', strtotime($variation->exchange_date)) }}</td>
          <td class="exchange-rate editable">{{ $variation->exchange_rate }}</td>
          <td class="buy-rate editable">{{ $variation->buy_rate }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="box-footer clearfix">
  <ul class="pagination pagination-sm no-margin pull-right variation-pagination">
    <li><a href="#" id="variation-pagination-first">«</a></li>
    @if($offset+1 == 1)
      <li><a href="#" id="variation-pagination-1">1</a></li>
      @for($i = 2; $i <= $pages; $i++)
        @if($i < 4)
          <li><a href="#" id="variation-pagination-{{ $i }}">{{ $i }}</a></li>
        @endif
      @endfor
    @else
      <li><a href="#" id="variation-pagination-{{ $offset }}">{{ $offset }}</a></li>
      <li><a href="#" id="variation-pagination-{{ $offset+1 }}">{{ $offset+1 }}</a></li>
      @if($offset+2 <= $pages)
        <li><a href="#" id="variation-pagination-{{ $offset+2 }}">{{ $offset+2 }}</a></li>
      @endif
    @endif
    <li><a href="#" id="variation-pagination-last">»</a></li>
  </ul>
</div>
