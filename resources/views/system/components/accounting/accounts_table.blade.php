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
        $accounts = \App\Account::where('code', '!=', '0');
      } else {
        $accounts = \App\Account::where('type', $account_data['type']);
      }
    } else {
      if($account_data['type'] == 'all') {
        $accounts = \App\Account::where('code', $account_data['code']);
      } else {
        $accounts = \App\Account::where('code', $account_data['code'])
        ->where('type', $account_data['type']);
      }
    }
  } else {
    $accounts = \App\Account::where('code', '!=', '0');
  }



  $records = $accounts->count();
  $pages = ceil($records/50);

  $offset = $account_data['offset'];

  if($offset == 'first') {
    $offset = 0;
  } else if ($offset == 'last') {
    $offset = $pages-1;
  } else {
    $offset--;
  }
  $accounts = $accounts->offset($offset*50)
    ->limit(50)
    ->orderBy('code')
    ->get();
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('accounting/accounts.accounts')</h3>
</div>
<div class="box-body table-responsive no-padding swift-table">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>@lang('accounting/accounts.code')</th>
        <th>@lang('accounting/accounts.type')</th>
        <th>@lang('accounting/accounts.increases')</th>
        <th>@lang('accounting/accounts.name')</th>
        <th>@lang('accounting/accounts.value')</th>
      </tr>
    </thead>
    <tbody>
      @foreach($accounts as $account)
        <tr id="account-{{ $account->code }}">
          <td>{{ $account->code }}</td>
          <td>{{ get_type($account->type) }}</td>
          <td>{{ increase_type($account->type) }}</td>
          <td class="editable account-name">{{ $account->name }}</td>
          <td>{{ $account->amount }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>


<div class="box-footer clearfix">
  <ul class="pagination pagination-sm no-margin pull-right accounts-pagination">
    <li><a href="#" id="accounts-pagination-first">«</a></li>
    @if($offset+1 == 1)
      <li><a href="#" id="accounts-pagination-1">1</a></li>
      @for($i = 2; $i <= $pages; $i++)
        @if($i < 4)
          <li><a href="#" id="accounts-pagination-{{ $i }}">{{ $i }}</a></li>
        @endif
      @endfor
    @else
      <li><a href="#" id="accounts-pagination-{{ $offset }}">{{ $offset }}</a></li>
      <li><a href="#" id="accounts-pagination-{{ $offset+1 }}">{{ $offset+1 }}</a></li>
      @if($offset+2 <= $pages)
        <li><a href="#" id="accounts-pagination-{{ $offset+2 }}">{{ $offset+2 }}</a></li>
      @endif
    @endif
    <li><a href="#" id="accounts-pagination-last">»</a></li>
  </ul>
</div>
