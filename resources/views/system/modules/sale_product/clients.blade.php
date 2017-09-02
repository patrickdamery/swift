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
  swift_menu.get_language().add_sentence('clients-view-clients-tab', {
                                        'en': 'View Clients',
                                        'es': 'Ver Clientes',
                                      });
  swift_menu.get_language().add_sentence('clients-view-debts-tab', {
                                        'en': 'View Debts',
                                        'es': 'Ver Deudas',
                                      });
  swift_menu.get_language().add_sentence('clients-view-purchases-tab', {
                                        'en': 'View Purchase History',
                                        'es': 'Ver Historial de Compras',
                                      });
  swift_menu.get_language().add_sentence('clients-view-discounts-tab', {
                                        'en': 'View Discounts',
                                        'es': 'Ver Descuentos',
                                                });

swift_event_tracker.register_swift_event('#clients-view-clients-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#clients-view-clients-tab', function(e) {
  swift_event_tracker.fire_event(e, '#clients-view-clients-tab');
});

swift_event_tracker.register_swift_event('#clients-view-debts-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#clients-view-debts-tab', function(e) {
  swift_event_tracker.fire_event(e, '#clients-view-debts-tab');
});

swift_event_tracker.register_swift_event('#clients-view-purchases-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#clients-view-purchases-tab', function(e) {
  swift_event_tracker.fire_event(e, '#clients-view-purchases-tab');
});

swift_event_tracker.register_swift_event('#clients-view-discounts-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#clients-view-discounts-tab', function(e) {
  swift_event_tracker.fire_event(e, '#clients-view-discounts-tab');
});
</script>
<script>
  function initMap() {
    var uluru = {lat: -25.363, lng: 131.044};
    var map = new google.maps.Map(document.getElementById('clients-view-map'), {
      zoom: 4,
      center: uluru
    });
    var marker = new google.maps.Marker({
      position: uluru,
      map: map
    });
  }
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXap_tqT_ErXCLLlmvc2RQFemtAJcDtCo&callback=initMap">
</script>
<section class="content-header">
  <h1>
    @lang('clients.title')
    <small class="crumb">@lang('clients.view_clients')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-user"></i> @lang('clients.title')</li>
    <li class="active crumb">@lang('clients.view_clients')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#clients-view-clients" id="clients-view-clients-tab" data-toggle="tab" aria-expanded="true">@lang('clients.view_clients')</a></li>
      <li><a href="#clients-view-debt" id="clients-view-debts-tab" data-toggle="tab" aria-expanded="true">@lang('clients.view_debt')</a></li>
      <li><a href="#clients-view-purchases" id="clients-view-purchases-tab" data-toggle="tab" aria-expanded="true">@lang('clients.view_purchases')</a></li>
      <li><a href="#clients-view-discounts" id="clients-view-discounts-tab" data-toggle="tab" aria-expanded="true">@lang('clients.view_discounts')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="clients-view-clients">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="clients-view-code" class="control-label">@lang('clients.client')</label>
              <input type="text" class="form-control" id="clients-view-code">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="clients-view-search">
                <i class="fa fa-search"></i> @lang('clients.search')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="clients-view-search">
                <i class="fa fa-plus"></i> @lang('clients.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="clients-view-name" class="control-label">@lang('clients.name')</label>
              <input type="text" class="form-control" id="clients-view-name">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="clients-view-id" class="control-label">@lang('clients.id')</label>
              <input type="text" class="form-control" id="clients-view-id">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="clients-view-company" class="control-label">@lang('clients.company_name')</label>
              <input type="text" class="form-control" id="clients-view-company">
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="clients-view-phone" class="control-label">@lang('clients.phone')</label>
              <input type="text" class="form-control" id="clients-view-phone">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="clients-view-email" class="control-label">@lang('clients.email')</label>
              <input type="email" class="form-control" id="clients-view-email">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="clients-view-address" class="control-label">@lang('clients.address')</label>
              <textarea row="5" cols="25" class="form-control" id="clients-view-address">
              </textarea>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="clients-view-has-credit" class="control-label">@lang('clients.has_credit')</label>
              <select class="form-control" id="clients-view-has-credit">
                <option value="1">@lang('clients.yes')</option>
                <option value="0">@lang('clients.no')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 lg-top-space md-top-space sm-top-space">
            <div class="form-group">
              <label for="clients-view-credit-limit" class="control-label">@lang('clients.credit_limit')</label>
              <input type="text" class="form-control" id="clients-view-credit-limit">
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block">
            <div id="clients-view-map" class="map">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
          </div>
          <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 xs-top-space sm-top-space md-top-space lg-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="clients-view-save">
                <i class="fa fa-save"></i> @lang('clients.save')
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="clients-view-debt">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="clients-debt-client" class="control-label">@lang('clients.client')</label>
              <input type="text" class="form-control" id="clients-debt-client">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="clients-debt-search">
                <i class="fa fa-search"></i> @lang('clients.search')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="clients-debt-print">
                <i class="fa fa-print"></i> @lang('clients.print')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:15px;">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('clients.date')</th>
                      <th>@lang('clients.bill')</th>
                      <th>@lang('clients.total_bill')</th>
                      <th>@lang('clients.due_days')</th>
                      <th>@lang('clients.total_due')</th>
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
      <div class="tab-pane" id="clients-view-purchases">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="clients-debt-client" class="control-label">@lang('clients.client')</label>
              <input type="text" class="form-control" id="clients-debt-client">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="clients-debt-search">
                <i class="fa fa-search"></i> @lang('clients.search')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="clients-debt-print">
                <i class="fa fa-print"></i> @lang('clients.print')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">@lang('clients.purchases')</h3>
              </div>
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('clients.date')</th>
                      <th>@lang('clients.bill')</th>
                      <th>@lang('clients.total')</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">@lang('clients.bill')</h3>
              </div>
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('clients.code')</th>
                      <th>@lang('clients.description')</th>
                      <th>@lang('clients.quantity')</th>
                      <th>@lang('clients.price')</th>
                      <th>@lang('clients.discount')</th>
                      <th>@lang('clients.total')</th>
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
          <div class="col-lg-4 col-md-3 col-sm-2 hidden-xs">
          </div>
          <div class="col-lg-8 col-md-9 col-sm-10 col-xs-12">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 hidden-xs">

              </div>
              <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 form-inline">
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="sales-subtotal" class="control-label">@lang('clients.subtotal')</label>
                      <input type="text" class="form-control" id="sales-subtotal">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="sales-discount" class="control-label">@lang('clients.discount')</label>
                      <input type="text" class="form-control" id="sales-discount">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="sales-tax" class="control-label">@lang('clients.tax')</label>
                      <input type="text" class="form-control" id="sales-tax">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="sales-total" class="control-label">@lang('clients.total')</label>
                      <input type="text" class="form-control" id="sales-total">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="clients-view-discounts">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="clients-discounts-client" class="control-label">@lang('clients.client')</label>
              <input type="text" class="form-control" id="clients-discounts-client">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="clients-discounts-search">
                <i class="fa fa-search"></i> @lang('clients.search')
              </button>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="clients-discounts-save">
                <i class="fa fa-save"></i> @lang('clients.save')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:15px;">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('clients.code')</th>
                      <th>@lang('clients.name')</th>
                      <th>@lang('clients.rules')</th>
                      <th>@lang('clients.state')</th>
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
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
