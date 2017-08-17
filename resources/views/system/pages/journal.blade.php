<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<script>
$(function(){
 $('.daterangepicker-sel').daterangepicker({
        format: 'mm-dd-yyyy'
      });
  });
  swift_menu.new_submenu();
  swift_menu.get_language().add_sentence('journal-view-entries-tab', {
                                        'en': 'View Journal Entries',
                                        'es': 'Ver Entradas a Diario',
                                      });

swift_event_tracker.register_swift_event('#journal-view-entries-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-view-entries-tab', function(e) {
  swift_event_tracker.fire_event(e, '#journal-view-entries-tab');
});

</script>

<section class="content-header">
  <h1>
    @lang('journal.title')
    <small class="crumb">@lang('journal.view_entries')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-money"></i> @lang('journal.title')</li>
    <li class="active crumb">@lang('journal.view_entries')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#journal-view-entries" id="journal-view-entries-tab" data-toggle="tab" aria-expanded="true">@lang('journal.view_entries')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="journal-view-entries">
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="journal-date-range" class="control-label">@lang('journal.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="journal-date-range">
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="journal-search">
                <i class="fa fa-search"></i> @lang('journal.search')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="journal-download">
                <i class="fa fa-file-excel-o"></i> @lang('journal.descargar')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="journal-report-type" class="control-label">@lang('journal.report_type')</label>
              <select class="form-control" id="journal-report-type">
                <option value="income-statement">@lang('journal.income_statement')</option>
                <option value="balance-sheet">@lang('journal.balance_sheet')</option>
                <option value="statement-equity">@lang('journal.statement_equity')</option>
                <option value="statement-cash-flow">@lang('journal.statement_cash_flow')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="journal-generate">
                <i class="fa fa-cogs"></i> @lang('journal.generate')
              </button>
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="journal-print">
                <i class="fa fa-print"></i> @lang('journal.print')
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
                      <th>@lang('journal.date')</th>
                      <th>@lang('journal.account_name')</th>
                      <th>@lang('journal.debit')</th>
                      <th>@lang('journal.credit')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
          </div>
          <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="journal-create-entry">
                <i class="fa fa-edit"></i> @lang('journal.create_entry')
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
