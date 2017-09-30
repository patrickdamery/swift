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

  // Check if we have already loaded the staff configuration JS file.
  if(typeof journal_js === 'undefined') {
    $.getScript('{{ URL::to('/') }}/js/swift/accounting/journal.js');
  }
</script>
@include('system.components.accounting.create_entry')
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
                <option value="detail">@lang('accounting/journal.detail')</option>
                <option value="summary">@lang('accounting/journal.summary')</option>
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
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('accounting/journal.date')</th>
                      <th>@lang('accounting/journal.account_name')</th>
                      <th>@lang('accounting/journal.debit')</th>
                      <th>@lang('accounting/journal.credit')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="journal-graphs">
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
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="journal-graphs-print">
                <i class="fa fa-print"></i> @lang('accounting/journal.print')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="journal-graphs-download">
                <i class="fa fa-file-excel-o"></i> @lang('accounting/journal.descargar')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 sm-top-space xs-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="journal-graphs-create">
                <i class="fa fa-plus"></i> @lang('accounting/journal.create')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6  sm-top-space xs-top-space">
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
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('accounting/journal.date')</th>
                      <th>@lang('accounting/journal.account_name')</th>
                      <th>@lang('accounting/journal.debit')</th>
                      <th>@lang('accounting/journal.credit')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="journal-configuration">
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-configuration-retained-vat" class="control-label">@lang('accounting/journal.retained_vat')</label>
              <input type="text" class="form-control" id="journal-configuration-retained-vat">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-configuration-advanced-vat" class="control-label">@lang('accounting/journal.advanced_vat')</label>
              <input type="text" class="form-control" id="journal-configuration-advanced-vat">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="journal-configuration-vat-percentage" class="control-label">@lang('accounting/journal.vat_percentage')</label>
              <div class="input-group">
                <input type="text" class="form-control" id="journal-configuration-vat-percentage">
                <span class="input-group-addon">%</span>
              </div>
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-configuration-retained-it" class="control-label">@lang('accounting/journal.retained_it')</label>
              <input type="text" class="form-control" id="journal-configuration-retained-it">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-configuration-advanced-it" class="control-label">@lang('accounting/journal.advanced_it')</label>
              <input type="text" class="form-control" id="journal-configuration-advanced-it">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="journal-configuration-it-percentage" class="control-label">@lang('accounting/journal.it_percentage')</label>
              <div class="input-group">
                <input type="text" class="form-control" id="journal-configuration-it-percentage">
                <span class="input-group-addon">%</span>
              </div>
            </div>
          </div>
        </div>
        <div class="row lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-configuration-isc" class="control-label">@lang('accounting/journal.isc')</label>
              <input type="text" class="form-control" id="journal-configuration-isc">
            </div>
          </div>
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
