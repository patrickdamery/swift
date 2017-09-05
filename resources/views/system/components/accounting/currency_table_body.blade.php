@foreach(\App\Currency::all() as $currency)
  <tr id="currency-{{ $currency->code }}">
    <td>{{ $currency->code }}</td>
    <td>{{ $currency->description }}</td>
    <td>{{ $currency->exchange_rate }}</td>
    <td>{{ $currency->buy_rate }}</td>
  </tr>
@endforeach
