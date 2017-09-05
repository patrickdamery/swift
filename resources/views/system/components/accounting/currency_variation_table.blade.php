@php
// Get variations.
$currency_variations = \App\CurrencyExchange::whereBetween('exchange_date', $date_range)
  ->where('currency_code', $code)->get();
@endphp
@foreach($currency_variations as $variation)
  <tr id="variation-{{ $variation->code }}">
    <td>{{ date('d/m/Y', strtotime($variation->exchange_date)) }}</td>
    <td class="exchange-rate">{{ $variation->exchange_rate }}</td>
    <td class="buy-rate">{{ $variation->buy_rate }}</td>
  </tr>
@endforeach
