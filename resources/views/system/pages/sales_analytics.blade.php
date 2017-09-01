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
  swift_menu.get_language().add_sentence('sales-analytics-tab', {
                                        'en': 'View Analytics',
                                        'es': 'Ver Analítica',
                                      });

swift_event_tracker.register_swift_event('#sales-analytics-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#sales-analytics-tab', function(e) {
  swift_event_tracker.fire_event(e, '#sales-analytics-tab');
});
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.min.js"></script>
<script>
$(document).ready(function() {
  var ctx = document.getElementById("sales-analytics-chart-canv").getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ["Juan", "Carlos", "Maria", "Rafael", "Jose", "Josefina"],
          datasets: [{
              label: 'Ventas',
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
  });
});
</script>
<section class="content-header">
  <h1>
    @lang('sales_analytics.title')
    <small class="crumb">@lang('sales_analytics.view_analytics')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-line-chart"></i> @lang('sales_analytics.title')</li>
    <li class="active crumb">@lang('sales_analytics.view_analytics')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#sales-analytics" id="sales-analytics-tab" data-toggle="tab" aria-expanded="true">@lang('sales_analytics.view_analytics')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="sales-analytics">
        <div class="row form-inline">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              <label for="sales-analytics-date-range" class="control-label">@lang('sales_analytics.date_range')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control daterangepicker-sel" id="sales-analytics-date-range">
              </div>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="sales-analytics-filter" class="control-label">@lang('sales_analytics.filter')</label>
              <select class="form-control" id="sales-analytics-filter">
                <option value="provider">@lang('sales_analytics.provider')</option>
                <option value="product">@lang('sales_analytics.product')</option>
                <option value="salesman">@lang('sales_analytics.salesman')</option>
                <option value="client">@lang('sales_analytics.client')</option>
                <option value="client">@lang('sales_analytics.branch')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="sales-analytics-code" class="control-label">@lang('sales_analytics.code')</label>
              <input type="text" class="form-control" id="sales-analytics-code">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="sales-analytics-add">
                <i class="fa fa-plus"></i> @lang('sales_analytics.add')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline  lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="sales-analytics-filter-chart" class="control-label">@lang('sales_analytics.filter_chart')</label>
              <div class="selected-filters" id="sales-analytics-filter-chart">
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="sales-analytics-chart-val" class="control-label">@lang('sales_analytics.chart_val')</label>
              <select class="form-control" id="sales-analytics-chart-val">
                <option value="quantity">@lang('sales_analytics.quantity')</option>
                <option value="value">@lang('sales_analytics.value')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="form-group">
              <label for="sales-analytics-chart-by" class="control-label">@lang('sales_analytics.chart_by')</label>
              <select class="form-control" id="sales-analytics-chart-by">
                <option value="provider">@lang('sales_analytics.provider')</option>
                <option value="product">@lang('sales_analytics.product')</option>
                <option value="salesman">@lang('sales_analytics.salesman')</option>
                <option value="client">@lang('sales_analytics.client')</option>
                <option value="branch">@lang('sales_analytics.branch')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline  lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="sales-analytics-chart" class="control-label">@lang('sales_analytics.chart')</label>
              <select class="form-control" id="sales-analytics-chart">
                <option value="line_chart">@lang('sales_analytics.line_chart')</option>
                <option value="bar_chart">@lang('sales_analytics.bar_chart')</option>
                <option value="pie_chart">@lang('sales_analytics.pie_chart')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="sales-analytics-interval" class="control-label">@lang('sales_analytics.interval')</label>
              <select class="form-control" id="sales-analytics-interval">
                <option value="daily">@lang('sales_analytics.daily')</option>
                <option value="weekly">@lang('sales_analytics.weekly')</option>
                <option value="monthly">@lang('sales_analytics.monthly')</option>
                <option value="annually">@lang('sales_analytics.annually')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="sales-analytics-generate">
                <i class="fa fa-gears"></i> @lang('sales_analytics.generate')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
          </div>
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="padding-top:15px;">
            <canvas id="sales-analytics-chart-canv"></canvas>
          </div>
          <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
