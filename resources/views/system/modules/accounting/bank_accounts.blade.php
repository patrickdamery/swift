<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<script>
$(function(){
 $('.daterangepicker-sel').daterangepicker({
        format: 'dd-mm-yyyy'
      });
  $('.datepicker-sel').datepicker({
         format: 'dd-mm-yyyy'
       });
  });
  swift_menu.new_submenu();
  swift_menu.get_language().add_sentence('bank-accounts-view-accounts-tab', {
                                        'en': 'View Accounts',
                                        'es': 'Ver Cuentas'
                                      });

  // Define Feedback Messages.
  swift_language.add_sentence('create_account_blank_code', {
                              'en': 'Bank Account Code can\'t be left blank!',
                              'es': 'Codigo de Cuenta de Banco no puede dejarse en blanco!'
                            });
  swift_language.add_sentence('create_account_blank_name', {
                              'en': 'Bank Name can\'t be left blank!',
                              'es': 'Nombre de Banco no puede dejarse en blanco!'
                            });
  swift_language.add_sentence('create_account_blank_account', {
                              'en': 'Accounting Account can\'t be left blank!',
                              'es': 'Cuenta Contable no puede dejarse en blanco!'
                            });
  swift_language.add_sentence('create_account_balance_error', {
                              'en': 'Balance in Bank Account can\'t be blank and must be a numeric value!',
                              'es': 'Balance de Cuenta de Banco no puede dejarse en blanco y debe ser un valor numerico!'
                            });
  swift_language.add_sentence('create_account_number_error', {
                              'en': 'Bank Account Number can\'t be blank and must be a numeric value!',
                              'es': 'Numero de Cuenta de Banco no puede dejarse en blanco y debe ser un valor numerico!'
                            });
  swift_language.add_sentence('blank_pos_name', {
                              'en': 'Name can\'t be blank!',
                              'es': 'Nombre no puede dejarse en blanco!'
                            });
  swift_language.add_sentence('pos_commission_required', {
                              'en': 'Commissions can\'t be blank and must be a numeric value!',
                              'es': 'Comissiones no pueden dejarse en blanco y debe ser un valor numerico!'
                            });
  swift_language.add_sentence('blank_cheque_book_name', {
                              'en': 'Cheque book name can\'t be blank!',
                              'es': 'Nombre de chequera no puede dejarse en blanco!'
                            });
  swift_language.add_sentence('cheque_number_required', {
                              'en': 'Cheque number can\'t be blank and must be a numeric value!',
                              'es': 'Numero de cheque no puede dejarse en blanco y debe ser un valor numerico!'
                            });
  swift_language.add_sentence('account_required', {
                              'en': 'Account can\'t be blank!',
                              'es': 'Cuenta no puede dejarse en blanco!'
                            });
  swift_language.add_sentence('amount_required', {
                              'en': 'Amount can\'t be blank and must be a numeric value!',
                              'es': 'Cantidad no pueden dejarse en blanco y debe ser un valor numerico!'
                            });
  swift_language.add_sentence('start_date_required', {
                              'en': 'Start date can\'t be blank!',
                              'es': 'Fecha inicial puede dejarse en blanco!'
                            });
  swift_language.add_sentence('interest_required', {
                              'en': 'Interest can\'t be blank and must be a numeric value!',
                              'es': 'Tasa de Interes no pueden dejarse en blanco y deben ser un valor numerico!'
                            });
  swift_language.add_sentence('payment_required', {
                              'en': 'Payment rate can\'t be blank and must be a numeric value!',
                              'es': 'Pago por intervalo no puede dejarse en blanco y debe ser un valor numerico!'
                            });
  swift_utils.register_ajax_fail();

// Check if we have already loaded the bank accounts JS file.
if(typeof bank_accounts_js === 'undefined') {
  $.getScript('{{ URL::to('/') }}/js/swift/accounting/bank_accounts.js');
}
</script>
@include('system.components.accounting.create_bank_account')
@include('system.components.accounting.create_loan')
@include('system.components.accounting.create_cheque_book')
@include('system.components.accounting.create_pos')
<section class="content-header">
  <h1>
    @lang('accounting/bank_accounts.title')
    <small class="crumb">@lang('accounting/bank_accounts.view_account')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-money"></i> @lang('accounting/bank_accounts.title')</li>
    <li class="active crumb">@lang('accounting/bank_accounts.view_account')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#bank-accounts-view-accounts" id="bank-accounts-view-accounts-tab" data-toggle="tab" aria-expanded="true">@lang('accounting/bank_accounts.view_account')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="bank-accounts-view-accounts">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
              <label for="bank-account-code" class="control-label">@lang('accounting/bank_accounts.code')</label>
              <select class="form-control" id="bank-account-code">
                @foreach(\App\BankAccount::all() as $bank_account)
                  <option value="{{ $bank_account->code }}">{{ $bank_account->bank_name.' '.$bank_account->account_number }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="bank-accounts-search">
                <i class="fa fa-search"></i> @lang('accounting/bank_accounts.search')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#create-bank-account">
                <i class="fa fa-plus"></i> @lang('accounting/bank_accounts.create_account')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
            <div class="box" id="bank-account-table">
              @include('system.components.accounting.bank_account_table',
                [
                  'code' => ''
                ]
              )
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
