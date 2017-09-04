@php
  function get_type($t) {
    switch($t){
      case 'as':
        return \Lang::get('accounting/accounts.asset');
      break;
      case 'dr':
        return \Lang::get('accounting/accounts.draw');
      break;
      case 'ex':
        return \Lang::get('accounting/accounts.expense');
      break;
      case 'li':
        return \Lang::get('accounting/accounts.liability');
      break;
      case 'eq':
        return \Lang::get('accounting/accounts.equity');
      break;
      case 're':
        return \Lang::get('accounting/accounts.revenue');
      break;
    }
  }
  function increase_type($t) {
    if($t == 'as' || $t == 'dr' || $t == 'ex') {
      return \Lang::get('accounting/accounts.debit');
    } else {
      return \Lang::get('accounting/accounts.credit');
    }
  }

  $accounts = array();
  if(isset($account_data)) {
    if($account_data['code'] == '') {
      if($account_data['type'] == 'all') {
        $accounts = \App\Account::where('code', '!=', '0')->get();
      } else {
        $accounts = \App\Account::where('type', $account_data['type'])->get();
      }
    } else {
      if($account_data['type'] == 'all') {
        $accounts = \App\Account::where('code', $account_data['code'])->get();
      } else {
        $accounts = \App\Account::where('code', $account_data['code'])
        ->where('type', $account_data['type'])->get();
      }
    }
  } else {
    $accounts = \App\Account::where('code', '!=', '0')->get();
  }
@endphp
@foreach($accounts as $account)
  <tr id="account-{{ $account->code }}">
    <td>{{ $account->code }}</td>
    <td>{{ get_type($account->type) }}</td>
    <td>{{ increase_type($account->type) }}</td>
    <td>{{ $account->name }}</td>
    <td>{{ $account->amount }}</td>
  </tr>
@endforeach
