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
  swift_utils.register_ajax_fail();

// Check if we have already loaded the bank accounts JS file.
if(typeof bank_accounts_js === 'undefined') {
  $.getScript('{{ URL::to('/') }}/js/swift/accounting/bank_accounts.js');
}
</script>
@include('system.components.accounting.create_bank_account')
@include('system.components.accounting.create_loan')
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
      <li class=""><a href="#bank-loans" id="bank-loans-tab" data-toggle="tab" aria-expanded="false">@lang('accounting/bank_accounts.loans')</a></li>
      <li class=""><a href="#bank-accounts-pos" id="bank-accounts-pos-tab" data-toggle="tab" aria-expanded="false">@lang('accounting/bank_accounts.pos')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="bank-accounts-view-accounts">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="bank-account-code" class="control-label">@lang('accounting/bank_accounts.code')</label>
              <select class="form-control" id="bank-account-code">
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="bank-accounts-search">
                <i class="fa fa-search"></i> @lang('accounting/bank_accounts.search')
              </button>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info"  data-toggle="modal" data-target="#create-bank-account">
                <i class="fa fa-plus"></i> @lang('accounting/bank_accounts.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
            <div class="box" id="bank-account-table">
              @include('system.components.accounting.bank_account_table',
                [
                  'account_search' => array(
                    'code' => '',
                    'offset' => 1
                  )
                ]
              );
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.tab-content -->
  </div>
</section>
