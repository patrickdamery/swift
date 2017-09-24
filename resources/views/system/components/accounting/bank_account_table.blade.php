@php
  $bank_accounts = array();
  if($code != '') {
    $bank_accounts = \App\BankAccount::where('code', $code)->get();
  } else {
    $bank_accounts = \App\BankAccount::all();
  }
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('accounting/bank_accounts.title')</h3>
</div>
<div class="box-body table-responsive no-padding swift-table">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>@lang('accounting/bank_accounts.account_number')</th>
        <th>@lang('accounting/bank_accounts.pos')</th>
        <th>@lang('accounting/bank_accounts.cheques')</th>
        <th>@lang('accounting/bank_accounts.loans')</th>
      </tr>
    </thead>
    <tbody>
      @foreach($bank_accounts as $bank_account)
        <tr id="bank-account-{{ $bank_account->code }}">
          <td>{{ $bank_account->account_number }}</td>
          <td>
            @foreach(\App\POS::where('bank_account_code', $bank_account->code)->get() as $pos)
              <div class="row">
                <div class="col-xs-4">
                  <div class="form-group">
                    <label class="control-label">{{ $pos->name }}</label>
                  </div>
                </div>
                <div class="col-xs-8">
                  <div class="form-group">
                    <button type="button" class="btn btn-info view-pos" id="view-pos-{{ $pos->code }}">
                      <i class="fa fa-search"></i> @lang('accounting/bank_accounts.view')
                    </button>
                  </div>
                </div>
              </div>
            @endforeach
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <button type="button" class="btn btn-success create-pos" data-toggle="modal" data-target="#create-pos">
                    <i class="fa fa-plus"></i> @lang('accounting/bank_accounts.create')
                  </button>
                </div>
              </div>
            </div>
          </td>
          <td>
            @foreach(\App\ChequeBook::where('bank_account_code', $bank_account->code)->get() as $cheque_book)
              <div class="row">
                <div class="col-xs-4">
                  <div class="form-group">
                    <label class="control-label">{{ $cheque_book->name }}</label>
                  </div>
                </div>
                <div class="col-xs-8">
                  <div class="form-group">
                    <button type="button" class="btn btn-info view-cheque-book" id="view-cheque-{{ $cheque_book->code }}">
                      <i class="fa fa-search"></i> @lang('accounting/bank_accounts.view')
                    </button>
                  </div>
                </div>
              </div>
            @endforeach
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <button type="button" class="btn btn-success create-cheque" data-toggle="modal" data-target="#create-cheque-book">
                    <i class="fa fa-plus"></i> @lang('accounting/bank_accounts.create')
                  </button>
                </div>
              </div>
            </div>
          </td>
          <td>
            @foreach(\App\BankLoan::where('bank_account_code', $bank_account->code)->get() as $loan)
              <div class="row">
                <div class="col-xs-4">
                  <div class="form-group">
                    <label class="control-label">{{ \App\Account::where('code', $loan->account_code)->first()->name }}</label>
                  </div>
                </div>
                <div class="col-xs-8">
                  <div class="form-group">
                    <button type="button" class="btn btn-info view-loan" id="view-loan-{{ $loan->code }}">
                      <i class="fa fa-search"></i> @lang('accounting/bank_accounts.view')
                    </button>
                  </div>
                </div>
              </div>
            @endforeach
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <button type="button" class="btn btn-success create-loan" data-toggle="modal" data-target="#create-loan">
                    <i class="fa fa-plus"></i> @lang('accounting/bank_accounts.create')
                  </button>
                </div>
              </div>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
