<?php
  // Get data we need to display.
  use App\Configuration;
  use App\UserAccess;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
  $access = UserAccess::where('code', Auth::user()->user_access_code)->first();
  $access = json_decode($access->access);
 ?>
 <script>
 $(function(){

   // Define Menu Tab Options.
   swift_menu.new_submenu();
   swift_menu.get_language().add_sentence('staff-configuration-tab', {
                                         'en': 'View Configuration',
                                         'es': 'Ver Configuracion'
                                       });
   swift_menu.get_language().add_sentence('staff-configuration-view-access-tab', {
                                         'en': 'Access Configuration',
                                         'es': 'Configuracion de Accesos'
                                       });

   // Define Feedback Messages.
   swift_language.add_sentence('save_config_error', {
                               'en': 'Worker Code is required!',
                               'es': 'Codigo de Trabajador es requerido!'
                             });
   swift_language.add_sentence('access_error', {
                               'en': 'Access code is required!',
                               'es': 'Codigo de Acesso es requerido!'
                             });
   swift_language.add_sentence('hourly_rate_error', {
                               'en': 'Hourly rate is required!',
                               'es': 'Sueldo por hora es requerido!'
                             });
   swift_language.add_sentence('schedule_code_error', {
                               'en': 'Schedule Code is required!',
                               'es': 'Codigo de Horario es requerido!'
                             });
   swift_language.add_sentence('vehicle_code_error', {
                               'en': 'Vehicle code is required!',
                               'es': 'Codigo de Vehiculo es requerido!'
                             });
   swift_language.add_sentence('print_group_error', {
                               'en': 'Print group Code is required!',
                               'es': 'Codigo de Grupo para imprimir es requerido!'
                             });
   swift_language.add_sentence('notification_group_error', {
                               'en': 'Notification Code is required!',
                               'es': 'Codigo de Grupo de Notificacion es requerido!'
                             });
   swift_language.add_sentence('commission_group_error', {
                               'en': 'Commission Group Code is required!',
                               'es': 'Codigo de Grupo de Comisiones es requerido!'
                             });
   swift_language.add_sentence('discount_group_error', {
                               'en': 'Discount Group Code is required!',
                               'es': 'Codigo de Grupo de Descuentos es requerido!'
                             });
   swift_language.add_sentence('branches_group_error', {
                               'en': 'Branch Group Code is required!',
                               'es': 'Codigo de Grupo de Sucursales es requerido!'
                             });
   swift_language.add_sentence('pos_group_error', {
                               'en': 'POS Group Code is required!',
                               'es': 'Codigo de Grupo de POS es requerido!'
                             });
   swift_utils.register_ajax_fail();

   // Check if we have already loaded the staff configuration JS file.
   if(typeof staff_configuration_js === 'undefined') {
     $.getScript('{{ URL::to('/') }}/js/swift/staff/staff_configuration.js');
   }
 });
 </script>
<section class="content-header">
  <h1>
    @lang('staff/staff_configuration.title')
    <small class="crumb">@lang('staff/staff_configuration.view_config')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cogs"></i> @lang('staff/staff_configuration.title')</li>
    <li class="active crumb">@lang('staff/staff_configuration.view_config')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      @if($access->staff->staff_config->view_config->has)
        <li class="active"><a href="#staff-configuration" id="staff-configuration-tab" data-toggle="tab" aria-expanded="true">@lang('staff/staff_configuration.view_config')</a></li>
      @endif
      @if($access->staff->staff_config->access_config->has)
        <li><a href="#staff-configuration-view-access" id="staff-configuration-view-access-tab" data-toggle="tab" aria-expanded="true">@lang('staff/staff_configuration.view_access')</a></li>
      @endif
    </ul>
    <div class="tab-content">
      @if($access->staff->staff_config->view_config->has)
        <div class="tab-pane active" id="staff-configuration">
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="staff-configuration-code" class="control-label">@lang('staff/staff_configuration.code')</label>
                <input type="text" class="form-control" id="staff-configuration-code">
              </div>
            </div>
          </div>
          @if($access->staff->staff_config->view_config->general_config)
            <div class="row lg-top-space md-top-space sm-top-space xs-top-space">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px;">
                <h3>@lang('staff/staff_configuration.general')</h3>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-hourly-rate" class="control-label">@lang('staff/staff_configuration.hourly_rate')</label>
                  <input type="text" class="form-control" id="staff-configuration-hourly-rate">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-schedule" class="control-label">@lang('staff/staff_configuration.schedule')</label>
                  <select class="form-control" id="staff-configuration-schedule">
                    @foreach(\App\Schedule::all() as $schedule)
                      <option value="{{ $schedule->code }}">{{ $schedule->description }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
                <div class="form-group">
                  <label for="staff-configuration-vehicle" class="control-label">@lang('staff/staff_configuration.vehicle')</label>
                  <input type="text" class="form-control" id="staff-configuration-vehicle">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-self-print" class="control-label">@lang('staff/staff_configuration.self_print')</label>
                  <select class="form-control" id="staff-configuration-self-print">
                    <option value="1">@lang('staff/staff_configuration.yes')</option>
                    <option value="0">@lang('staff/staff_configuration.no')</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-print-group" class="control-label">@lang('staff/staff_configuration.print_group')</label>
                  <input type="text" class="form-control" id="staff-configuration-print-group">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
                <div class="form-group">
                  <label for="staff-configuration-notification-group" class="control-label">@lang('staff/staff_configuration.notification_group')</label>
                  <input type="text" class="form-control" id="staff-configuration-notification-group">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-commission" class="control-label">@lang('staff/staff_configuration.commission')</label>
                  <input type="text" class="form-control" id="staff-configuration-commission">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-discounts" class="control-label">@lang('staff/staff_configuration.discounts')</label>
                  <input type="text" class="form-control" id="staff-configuration-discounts">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
                <div class="form-group">
                  <label for="staff-configuration-branch" class="control-label">@lang('staff/staff_configuration.branches')</label>
                  <input type="text" class="form-control" id="staff-configuration-branch">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-pos" class="control-label">@lang('staff/staff_configuration.pos')</label>
                  <input type="text" class="form-control" id="staff-configuration-pos">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-access" class="control-label">@lang('staff/staff_configuration.access')</label>
                  <input type="text" class="form-control" id="staff-configuration-access">
                </div>
              </div>
            </div>
          @endif
          @if($access->staff->staff_config->view_config->accounting_config)
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px;">
                <h3>@lang('staff/staff_configuration.accounting')</h3>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-cashbox" class="control-label">@lang('staff/staff_configuration.cashbox')</label>
                  <input type="text" class="form-control" id="staff-configuration-cashbox">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-stock" class="control-label">@lang('staff/staff_configuration.stock')</label>
                  <input type="text" class="form-control" id="staff-configuration-stock">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
                <div class="form-group">
                  <label for="staff-configuration-loan" class="control-label">@lang('staff/staff_configuration.loan')</label>
                  <input type="text" class="form-control" id="staff-configuration-loan">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-long-loan" class="control-label">@lang('staff/staff_configuration.long_loan')</label>
                  <input type="text" class="form-control" id="staff-configuration-long-loan">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-salary" class="control-label">@lang('staff/staff_configuration.salary')</label>
                  <input type="text" class="form-control" id="staff-configuration-salary">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
                <div class="form-group">
                  <label for="staff-configuration-commission-account" class="control-label">@lang('staff/staff_configuration.commission_account')</label>
                  <input type="text" class="form-control" id="staff-configuration-commission-account">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-bonus" class="control-label">@lang('staff/staff_configuration.bonus')</label>
                  <input type="text" class="form-control" id="staff-configuration-bonus">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-antiquity" class="control-label">@lang('staff/staff_configuration.antiquity')</label>
                  <input type="text" class="form-control" id="staff-configuration-antiquity">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
                <div class="form-group">
                  <label for="staff-configuration-holidays" class="control-label">@lang('staff/staff_configuration.holidays')</label>
                  <input type="text" class="form-control" id="staff-configuration-holidays">
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space">
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-savings" class="control-label">@lang('staff/staff_configuration.savings')</label>
                  <input type="text" class="form-control" id="staff-configuration-savings">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-insurance" class="control-label">@lang('staff/staff_configuration.insurance')</label>
                  <input type="text" class="form-control" id="staff-configuration-insurance">
                </div>
              </div>
            </div>
            <div class="row form-inline lg-top-space md-top-space sm-top-space">
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-reimbursement-code" class="control-label">@lang('staff/staff_configuration.code')</label>
                  <input type="text" class="form-control" id="staff-configuration-reimbursement-code">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-reimbursement" class="control-label">@lang('staff/staff_configuration.reimbursement')</label>
                  <select class="form-control" id="staff-configuration-reimbursement" multiple disabled>
                  </select>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <button type="button" class="btn btn-success" id="staff-configuration-reimbursement-clear">
                    <i class="fa fa-clear"></i> @lang('staff/staff_configuration.clear')
                  </button>
                </div>
              </div>
            </div>
            <div class="row form-inline lg-top-space md-top-space sm-top-space">
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-draw-code" class="control-label">@lang('staff/staff_configuration.code')</label>
                  <input type="text" class="form-control" id="staff-configuration-draw-code">
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="staff-configuration-draw" class="control-label">@lang('staff/staff_configuration.draw')</label>
                  <select class="form-control" id="staff-configuration-draw" multiple disabled>
                  </select>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <button type="button" class="btn btn-success" id="staff-configuration-draw-clear">
                    <i class="fa fa-clear"></i> @lang('staff/staff_configuration.clear')
                  </button>
                </div>
              </div>
            </div>
            <div class="row form-inline lg-top-space md-top-space sm-top-space">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="staff-configuration-bank-code" class="control-label">@lang('staff/staff_configuration.code')</label>
                <input type="text" class="form-control" id="staff-configuration-bank-code">
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="staff-configuration-bank" class="control-label">@lang('staff/staff_configuration.bank')</label>
                <select class="form-control" id="staff-configuration-bank" multiple disabled>
                </select>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <button type="button" class="btn btn-success" id="staff-configuration-bank-clear">
                  <i class="fa fa-clear"></i> @lang('staff/staff_configuration.clear')
                </button>
              </div>
            </div>
          </div>
          @endif
          <div class="row form-inline lg-top-space md-top-space sm-top-space">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
              <div class="form-group">
                <button type="button" class="btn btn-success" id="staff-configuration-save">
                  <i class="fa fa-save"></i> @lang('staff/staff_configuration.save')
                </button>
              </div>
            </div>
          </div>
        </div>
      @endif
      @if($access->staff->staff_config->access_config->has)
        <div class="tab-pane" id="staff-configuration-view-access">
          <div class="row form-inline">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="staff-configuration-access-code" class="control-label">@lang('staff/staff_configuration.code')</label>
                <select class="form-control" id="staff-configuration-access-code">
                  @foreach(\App\UserAccess::all() as $access)
                    <option value="{{ $access->code }}">{{ $access->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <button type="button" class="btn btn-success" id="staff-configuration-access-create">
                  <i class="fa fa-plus"></i> @lang('staff/staff_configuration.create')
                </button>
              </div>
            </div>
          </div>
          <div class="row lg-top-space md-top-space sm-top-space">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="box" id="access-table">
                @include('system.components.staff.access_table', [
                  'code' => '0'
                ])
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
</section>
