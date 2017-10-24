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
  });
  swift_menu.new_submenu();
  swift_menu.get_language().add_sentence('journal-view-entries-tab', {
                                        'en': 'View Journal Entries',
                                        'es': 'Ver Entradas a Diario',
                                      });
  swift_menu.get_language().add_sentence('journal-reports-tab', {
                                        'en': 'Reports',
                                        'es': 'Reportes',
                                      });
  swift_menu.get_language().add_sentence('journal-graphs-tab', {
                                        'en': 'Graphs',
                                        'es': 'Graficos',
                                      });
  swift_menu.get_language().add_sentence('journal-configuration-tab', {
                                        'en': 'Configuration',
                                        'es': 'Configuracion',
                                      });
  swift_utils.register_ajax_fail();
  swift_language.add_sentence('blank_account', {
    'en': 'Account can\'t be left blank!',
    'es': 'Cuenta no se puede dejar en blanco!',
  });
  swift_language.add_sentence('blank_amount', {
    'en': 'Amount can\'t be left blank and must be a numeric value!',
    'es': 'Monto no se puede dejar en blanco y debe ser un valor numerico!',
  });
  swift_language.add_sentence('blank_description', {
    'en': 'Description can\'t be left blank!',
    'es': 'Descripcion no se puede dejar en blanco!',
  });
  swift_language.add_sentence('delete', {
    'en': 'Delete',
    'es': 'Eliminar',
  });
  swift_language.add_sentence('no_entries', {
    'en': 'No entries have been added!',
    'es': 'No se han agregado entradas!',
  });
  swift_language.add_sentence('entry_sums_not_equal', {
    'en': 'Sum of credit an debit entries is not equal!',
    'es': 'Suma de entradas de credito y debito no es igual!',
  });
  swift_language.add_sentence('must_start_calc', {
    'en': 'The content of the variable must start with a call to a calc() function!',
    'es': 'El contenido de la variable debe comenzar con un llamado a la funcion calc()!',
  });
  swift_language.add_sentence('malformed_function', {
    'en': 'There is at least one malformed function in the content of the variable!',
    'es': 'Hay al menos una funcion mal formada en el contenido de la variable!',
  });
  swift_language.add_sentence('malformed_object', {
    'en': 'There is at least one malformed object in the content of the variable!',
    'es': 'Hay al menos un objecto mal formado en el contenido de la variable!',
  });
  swift_language.add_sentence('unrecognized_function', {
    'en': 'Could not recognize the function ',
    'es': 'No se pudo reconocer la funcion ',
  });
  swift_language.add_sentence('unrecognized_operation', {
    'en': 'Could not recognize the operation ',
    'es': 'No se pudo reconocer la operacion ',
  });
  swift_language.add_sentence('object_malformed', {
    'en': 'An error exists in the following object ',
    'es': 'Existe un error en el siguente objeto ',
  });
  swift_language.add_sentence('unexistent_variable', {
    'en': 'Could not find the following variable: ',
    'es': 'No se pudo encontrar la siguiente variable: ',
  });
  swift_language.add_sentence('unrecognized_type', {
    'en': 'Could not recognize the following account type: ',
    'es': 'No se pudo reconocer el siguiente tipo de cuenta: ',
  });
  swift_language.add_sentence('unrecognized_group', {
    'en': 'Could not recognize the option for grouping!',
    'es': 'No se pudo reconocer la opcion para agrupar!',
  });
  swift_language.add_sentence('no_variable_name', {
    'en': 'Variable needs to have a name!',
    'es': 'La variable debe tener un nombre!',
  });
  swift_language.add_sentence('blank_columns', {
    'en': 'Columns can\'t be left blank and must be a numeric value not greater than 4!',
    'es': 'Columnas no puede dejarse en blanco y debe ser un valor numerico no mayor que 4!',
  });
  swift_language.add_sentence('add_row', {
    'en': 'Add Rows',
    'es': 'Agregar Filas',
  });
  swift_language.add_sentence('remove_row', {
    'en': 'Remove Row',
    'es': 'Remover Fila',
  });
  swift_language.add_sentence('add_sub_row', {
    'en': 'Add Sub Rows',
    'es': 'Agregar Sub Filas',
  });
  swift_language.add_sentence('max_sub_row', {
    'en': 'Can\'t add any more sub rows here!',
    'es': 'No se pueden agregar aqui mas sub filas!',
  });
  swift_language.add_sentence('reserved_period', {
    'en': 'The variable name periodo is a reserved name. It makes reference to the period of time selected by'+
      ' the user when generating a report!',
    'es': 'El nombre periodo es un nombre de variable reservado. Hace referencia al periodo de tiempo seleccionado'+
      ' por el usuario cuando genera un reporte!',
  });
  swift_language.add_sentence('calc_period', {
    'en': 'The variable name periodo refers to the period of time selected by the user when making a report.'+
      ' It cannot be used for a calculation, it can only be used in the report layout!',
    'es': 'El nombre de la variable periodo se refiere al periodo de tiempo seleccionado por el usuario cuando genera un reporte'+
      ' No puede ser utilizado para una calculacion, solo puede ser utilizado en el diseño del reporte!',
  });
  swift_language.add_sentence('create_report', {
    'en': 'Create Report',
    'es': 'Crear Reporte',
  });
  swift_language.add_sentence('create_report_button', {
    'en': '<i class="fa fa-plus"></i> Create Report',
    'es': '<i class="fa fa-plus"></i> Crear Reporte',
  });
  swift_language.add_sentence('edit_report', {
    'en': 'Edit Report',
    'es': 'Editar Reporte',
  });
  swift_language.add_sentence('edit_report_button', {
    'en': '<i class="fa fa-edit"></i> Edit Report',
    'es': '<i class="fa fa-edit"></i> Editar Reporte',
  });
  swift_language.add_sentence('blank_retained_vat', {
    'en': 'Retained VAT Account can\'t be left blank!',
    'es': 'Cuenta de IVA Retenido no puede dejarse en blanco!',
  });
  swift_language.add_sentence('blank_advanced_vat', {
    'en': 'Advanced VAT Account can\'t be left blank!',
    'es': 'Cuenta de IVA Adelantado no puede dejarse en blanco!',
  });
  swift_language.add_sentence('blank_vat_percentage', {
    'en': 'VAT Percentage can\'t be left blank and must be a numeric value!',
    'es': 'Porcentaje IVA no puede dejarse en blanco y debe ser un valor numerico!',
  });
  swift_language.add_sentence('blank_retained_it', {
    'en': 'Retained IT Account can\'t be left blank!',
    'es': 'Cuenta de IR Retenido no puede dejarse en blanco!',
  });
  swift_language.add_sentence('blank_advanced_it', {
    'en': 'Advanced IT Account can\'t be left blank!',
    'es': 'Cuenta de IR Adelantado no puede dejarse en blanco!',
  });
  swift_language.add_sentence('blank_it_percentage', {
    'en': 'IT Percentage can\'t be left blank and must be a numeric value!',
    'es': 'Porcentaje IR no puede dejarse en blanco y debe ser un valor numerico!',
  });
  swift_language.add_sentence('blank_isc', {
    'en': 'Excise Tax Account can\'t be left blank!',
    'es': 'Cuenta de Impuesto Selectivo al Consumo no puede dejarse en blanco!',
  });
  swift_language.add_sentence('create_graph', {
    'en': 'Create Graph',
    'es': 'Crear Grafico',
  });
  swift_language.add_sentence('create_graph_button', {
    'en': '<i class="fa fa-plus"></i> Create Graph',
    'es': '<i class="fa fa-plus"></i> Crear Grafico',
  });
  swift_language.add_sentence('edit_graph', {
    'en': 'Edit Graph',
    'es': 'Editar Grafico',
  });
  swift_language.add_sentence('edit_graph_button', {
    'en': '<i class="fa fa-edit"></i> Edit Graph',
    'es': '<i class="fa fa-edit"></i> Editar Grafico',
  });

  // Check if we have already loaded the staff configuration JS file.
  if(typeof journal_js === 'undefined') {
    $.getScript('{{ URL::to('/') }}/js/swift/accounting/journal.js');
  }
</script>
@include('system.components.accounting.create_entry')
@include('system.components.accounting.create_report_row')
@include('system.components.accounting.add_configuration_rule')
<section class="content-header">
  <h1>
    @lang('accounting/journal.title')
    <small class="crumb">@lang('accounting/journal.view_entries')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-book"></i> @lang('accounting/journal.title')</li>
    <li class="active crumb">@lang('accounting/journal.view_entries')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#journal-view-entries" id="journal-view-entries-tab" data-toggle="tab" aria-expanded="true">@lang('accounting/journal.view_entries')</a></li>
      <li><a href="#journal-reports" id="journal-reports-tab" data-toggle="tab" aria-expanded="true">@lang('accounting/journal.reports')</a></li>
      <li><a href="#journal-graphs" id="journal-graphs-tab" data-toggle="tab" aria-expanded="true">@lang('accounting/journal.graphs')</a></li>
      <li><a href="#journal-configuration" id="journal-configuration-tab" data-toggle="tab" aria-expanded="true">@lang('accounting/journal.configuration')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="journal-view-entries">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-date-range" class="control-label">@lang('accounting/journal.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="journal-date-range">
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-group-entry" class="control-label">@lang('accounting/journal.group_entry')</label>
              <select class="form-control" id="journal-group-entry">
                <option value="summary">@lang('accounting/journal.summary')</option>
                <option value="detail">@lang('accounting/journal.detail')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space xs-top-space">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="journal-search">
                <i class="fa fa-search"></i> @lang('accounting/journal.search')
              </button>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="journal-download">
                <i class="fa fa-file-excel-o"></i> @lang('accounting/journal.descargar')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
            <div class="box" id="journal-entries-table">
              @include('system.components.accounting.journal_table',
                [
                  'type' => 'summary',
                  'date_range' => array(
                    date('Y-m-d', strtotime('7 days ago')).' 00:00:00',
                    date('Y-m-d').' 23:59:59',
                  ),
                  'offset' => 1,
                ]
              )
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
          </div>
          <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="journal-create-entry" data-toggle="modal" data-target="#create-entry">
                <i class="fa fa-edit"></i> @lang('accounting/journal.create_entry')
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="journal-reports">
        <div class="hideable hide" id="journal-create-report">
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <h3 id="create-report-title">@lang('accounting/journal.create_report')</h3>
            </div>
          </div>
          <div class="row form-inline lg-top-space md-top-space sm-top-space">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-create-report-variable" class="control-label">@lang('accounting/journal.variable')</label>
                <input type="text" class="form-control" id="journal-create-report-variable">
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-create-report-content" class="control-label">@lang('accounting/journal.content')</label>
                <input type="text" class="form-control" id="journal-create-report-content">
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
              <div class="form-group">
                <button type="button" class="btn btn-success" id="journal-create-report-add">
                  <i class="fa fa-plus"></i> @lang('accounting/journal.add')
                </button>
              </div>
            </div>
          </div>
          <div class="row form-inline lg-top-space md-top-space sm-top-space">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-create-report-group" class="control-label">@lang('accounting/journal.group_by')</label>
                <select class="form-control" id="journal-create-report-group">
                  <option value="summary">@lang('accounting/journal.summary')</option>
                  <option value="day">@lang('accounting/journal.day')</option>
                  <option value="week">@lang('accounting/journal.week')</option>
                  <option value="month">@lang('accounting/journal.month')</option>
                  <option value="year">@lang('accounting/journal.year')</option>
                </select>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-create-report-title" class="control-label">@lang('accounting/journal.report_title')</label>
                <input type="text" class="form-control" id="journal-create-report-title">
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
              <div>
                <label class="control-label">@lang('accounting/journal.variables')</label>
                <div id="journal-create-report-variables">
                </div>
              </div>
            </div>
          </div>
          <div class="row form-inline" style="padding-top: 15px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">@lang('accounting/journal.report')</h3>
                </div>
                <div class="box-body table-responsive no-padding swift-table">
                  <div class="table table-hover">
                    <div id="report-layout">

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row lg-top-space md-top-space sm-top-space">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <button type="button" class="btn btn-success" id="journal-create-report-create">
                  <i class="fa fa-plus"></i> @lang('accounting/journal.create_report')
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="showable">
          <div class="row form-inline">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-reports-date-range" class="control-label">@lang('accounting/journal.date_range')</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control daterangepicker-sel" id="journal-reports-date-range">
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-reports-report" class="control-label">@lang('accounting/journal.report')</label>
                <select class="form-control" id="journal-reports-report">
                  @foreach(\App\Report::all() as $report)
                    <option value="{{ $report->id }}">{{ $report->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
              <div class="form-group">
                <button type="button" class="btn btn-success" id="journal-reports-generate">
                  <i class="fa fa-cogs"></i> @lang('accounting/journal.generate')
                </button>
              </div>
            </div>
          </div>
          <div class="row form-inline lg-top-space md-top-space sm-top-space xs-top-space">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <div class="form-group">
                <button type="button" class="btn btn-info" id="journal-reports-print">
                  <i class="fa fa-print"></i> @lang('accounting/journal.print')
                </button>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
              <div class="form-group">
                <button type="button" class="btn btn-info" id="journal-reports-download">
                  <i class="fa fa-file-excel-o"></i> @lang('accounting/journal.descargar')
                </button>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 sm-top-space xs-top-space">
              <div class="form-group">
                <button type="button" class="btn btn-success" id="journal-reports-create">
                  <i class="fa fa-plus"></i> @lang('accounting/journal.create')
                </button>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6  sm-top-space xs-top-space">
              <div class="form-group">
                <button type="button" class="btn btn-info" id="journal-reports-edit">
                  <i class="fa fa-edit"></i> @lang('accounting/journal.edit')
                </button>
              </div>
            </div>
          </div>
          <div class="row" style="padding-top:15px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
              <div class="box" id="report-box">
                <div class="box-body table-responsive no-padding swift-table">
                  <div class="table table-hover">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="journal-graphs">
        <script>
          $(document).ready(function(){
              journal_js.paint_graph();
              /*var ctx = document.getElementById("graph-layout").getContext('2d');
              var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                      datasets: [{
                          label: '# of Votes',
                          data: [12, 19, 3, 5, 2, 3],
                          backgroundColor: [
                              'rgba(255, 99, 132, 0.2)',
                              'rgba(54, 162, 235, 0.2)',
                              'rgba(255, 206, 86, 0.2)',
                              'rgba(75, 192, 192, 0.2)',
                              'rgba(153, 102, 255, 0.2)',
                              'rgba(255, 159, 64, 0.2)'
                          ],
                          borderColor: [
                              'rgba(255,99,132,1)',
                              'rgba(54, 162, 235, 1)',
                              'rgba(255, 206, 86, 1)',
                              'rgba(75, 192, 192, 1)',
                              'rgba(153, 102, 255, 1)',
                              'rgba(255, 159, 64, 1)'
                          ],
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });*/
          });
        </script>
        <div class="hideable hide" id="journal-create-graph">
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <h3 id="create-graph-title">@lang('accounting/journal.create_graph')</h3>
            </div>
          </div>
          <div class="row form-inline lg-top-space md-top-space sm-top-space">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-create-graph-variable" class="control-label">@lang('accounting/journal.variable')</label>
                <input type="text" class="form-control" id="journal-create-graph-variable">
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-create-graph-content" class="control-label">@lang('accounting/journal.content')</label>
                <input type="text" class="form-control" id="journal-create-graph-content">
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
              <div class="form-group">
                <button type="button" class="btn btn-success" id="journal-create-graph-add">
                  <i class="fa fa-plus"></i> @lang('accounting/journal.add')
                </button>
              </div>
            </div>
          </div>
          <div class="row form-inline lg-top-space md-top-space sm-top-space">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-create-graph-group" class="control-label">@lang('accounting/journal.group_by')</label>
                <select class="form-control" id="journal-create-graph-group">
                  <option value="summary">@lang('accounting/journal.summary')</option>
                  <option value="day">@lang('accounting/journal.day')</option>
                  <option value="week">@lang('accounting/journal.week')</option>
                  <option value="month">@lang('accounting/journal.month')</option>
                  <option value="year">@lang('accounting/journal.year')</option>
                </select>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-create-graph-type" class="control-label">@lang('accounting/journal.graph_type')</label>
                <select class="form-control" id="journal-create-graph-type">
                  <option value="line">@lang('accounting/journal.line_graph')</option>
                  <option value="bar">@lang('accounting/journal.bar_graph')</option>
                  <option value="pie">@lang('accounting/journal.pie_chart')</option>
                </select>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space xs-top-space">
              <div>
                <label class="control-label">@lang('accounting/journal.variables')</label>
                <div id="journal-create-graph-variables">
                </div>
              </div>
            </div>
          </div>
          <div class="row form-inline lg-top-space md-top-space sm-top-space">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-create-graph-title" class="control-label">@lang('accounting/journal.graph_title')</label>
                <input type="text" class="form-control" id="journal-create-graph-title">
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-create-graph-graphed-variables" class="control-label">@lang('accounting/journal.graphed_variables')</label>
                <select class="form-control" id="journal-create-graph-graphed-variables" multiple>
                </select>
              </div>
            </div>
          </div>
          <div class="row form-inline" style="padding-top: 15px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">@lang('accounting/journal.graph')</h3>
                </div>
                <div class="box-body table-responsive no-padding swift-table" id="graph-layout-container">
                  <canvas id="graph-layout">
                  </canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="row lg-top-space md-top-space sm-top-space">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <button type="button" class="btn btn-success" id="journal-create-graph-create">
                  <i class="fa fa-plus"></i> @lang('accounting/journal.create_graph')
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="showable">
          <div class="row form-inline">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-reports-date-range" class="control-label">@lang('accounting/journal.date_range')</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control daterangepicker-sel" id="journal-graphs-date-range">
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <label for="journal-graphs-graph" class="control-label">@lang('accounting/journal.graph')</label>
                <select class="form-control" id="journal-graphs-graph">
                  @foreach(\App\Graph::all() as $graph)
                    <option value="{{ $graph->id }}">{{ $graph->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
              <div class="form-group">
                <button type="button" class="btn btn-success" id="journal-graphs-generate">
                  <i class="fa fa-cogs"></i> @lang('accounting/journal.generate')
                </button>
              </div>
            </div>
          </div>
          <div class="row form-inline lg-top-space md-top-space sm-top-space xs-top-space">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <button type="button" class="btn btn-success" id="journal-graphs-create">
                  <i class="fa fa-plus"></i> @lang('accounting/journal.create')
                </button>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <button type="button" class="btn btn-info" id="journal-graphs-edit">
                  <i class="fa fa-edit"></i> @lang('accounting/journal.edit')
                </button>
              </div>
            </div>
          </div>
          <div class="row" style="padding-top:15px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
              <div class="box">
                <div class="box-body table-responsive no-padding swift-table" id="generated-graph-container">
                  <canvas id="generated-graph">
                  </canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="journal-configuration">
        @php
          $accounting_accounts = \App\AccountingAccount::where('id', 1)->first();
        @endphp
        <script>
          $(document).ready(function(){
              journal_js.set_it_rules({!! $accounting_accounts->IT_rules !!});
              journal_js.display_it_rules();
          });
        </script>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-configuration-entity_type" class="control-label">@lang('accounting/journal.entity_type')</label>
              <select class="form-control" id="journal-configuration-entity-type">
                <option value="natural" {{ ($accounting_accounts->entity_type == 'natural') ? 'selected' : '' }}>@lang('accounting/journal.natural')</option>
                <option value="legal" {{ ($accounting_accounts->entity_type == 'legal') ? 'selected' : '' }}>@lang('accounting/journal.legal')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-configuration-retained-vat" class="control-label">@lang('accounting/journal.retained_vat')</label>
              <input type="text" class="form-control" id="journal-configuration-retained-vat" value="{{ $accounting_accounts->retained_VAT_account }}">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-configuration-advanced-vat" class="control-label">@lang('accounting/journal.advanced_vat')</label>
              <input type="text" class="form-control" id="journal-configuration-advanced-vat" value="{{ $accounting_accounts->advanced_VAT_account }}">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space {{ ($accounting_accounts->entity_type == 'natural') ? 'hide' : '' }}" id="vat-percentage-div">
            <div class="form-group">
              <label for="journal-configuration-vat-percentage" class="control-label">@lang('accounting/journal.vat_percentage')</label>
              <div class="input-group">
                <input type="text" class="form-control" id="journal-configuration-vat-percentage" value="{{ $accounting_accounts->VAT_percentage }}">
                <span class="input-group-addon">%</span>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space {{ ($accounting_accounts->entity_type != 'natural') ? 'hide' : '' }}" id="fixed-fee-div">
            <div class="form-group">
              <label for="journal-configuration-fixed-fee" class="control-label">@lang('accounting/journal.fixed_fee')</label>
              <input type="text" class="form-control" id="journal-configuration-fixed-fee" value="{{ $accounting_accounts->fixed_fee }}">
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-configuration-retained-it" class="control-label">@lang('accounting/journal.retained_it')</label>
              <input type="text" class="form-control" id="journal-configuration-retained-it" value="{{ $accounting_accounts->retained_IT_account }}">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-configuration-advanced-it" class="control-label">@lang('accounting/journal.advanced_it')</label>
              <input type="text" class="form-control" id="journal-configuration-advanced-it" value="{{ $accounting_accounts->advanced_IT_account }}">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space {{ ($accounting_accounts->entity_type == 'natural') ? 'hide' : '' }}" id="it-percentage-div">
            <div class="form-group">
              <label for="journal-configuration-it-percentage" class="control-label">@lang('accounting/journal.it_percentage')</label>
              <div class="input-group">
                <input type="text" class="form-control" id="journal-configuration-it-percentage" value="{{ $accounting_accounts->IT_percentage }}">
                <span class="input-group-addon">%</span>
              </div>
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space {{ ($accounting_accounts->entity_type != 'natural') ? 'hide' : '' }}" id="it-rules-div">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label class="control-label">@lang('accounting/journal.rules')</label>
              <div id="journal-create-it-rules">
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="journal-configuration-add-rule" data-toggle="modal" data-target="#add-configuration-rule">
                <i class="fa fa-plus"></i> @lang('accounting/journal.add_rule')
              </button>
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-configuration-isc" class="control-label">@lang('accounting/journal.isc')</label>
              <input type="text" class="form-control" id="journal-configuration-isc" value="{{ $accounting_accounts->ISC_account }}">
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="journal-configuration-save">
                <i class="fa fa-save"></i> @lang('accounting/journal.save')
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
