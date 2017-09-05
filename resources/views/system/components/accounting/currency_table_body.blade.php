@foreach(\App\Currency::all() as $currency)
  <tr id="currency-{{ $currency->code }}">
    <td>{{ $currency->code }}</td>
    <td>{{ $currency->description }}</td>
    <td class="exchange-rate">{{ round($currency->exchange_rate, 4) }}</td>
    <td class="buy-rate">{{ round($currency->buy_rate, 4) }}</td>
  </tr>
@endforeach
