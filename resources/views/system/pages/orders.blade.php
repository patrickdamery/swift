<?php
  // Get data we need to display.
  use App\Configuration;
  use App\User;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<script>
  swift_menu.new_submenu();
  swift_menu.get_language().add_sentence('orders-make-order-tab', {
                                        'en': 'Make Order',
                                        'es': 'Realizar Pedido'
                                      });
  swift_menu.get_language().add_sentence('orders-view-order-tab', {
                                      'en': 'View Order',
                                      'es': 'Ver Pedido'
                                    });
  swift_menu.get_language().add_sentence('orders-load-order-tab', {
                                      'en': 'Load Order',
                                      'es': 'Cargar Pedido'
                                    });

swift_event_tracker.register_swift_event('#orders-make-order-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#orders-make-order-tab', function(e) {
  swift_event_tracker.fire_event(e, '#orders-make-order-tab');
});

swift_event_tracker.register_swift_event('#orders-view-order-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#orders-view-order-tab', function(e) {
  swift_event_tracker.fire_event(e, '#orders-view-order-tab');
});

swift_event_tracker.register_swift_event('#orders-load-order-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#orders-load-order-tab', function(e) {
  swift_event_tracker.fire_event(e, '#orders-load-order-tab');
});
</script>
<section class="content-header">
  <h1>
    @lang('orders.title')
    <small class="crumb">@lang('orders.make_order')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-cube"></i> @lang('orders.title')</li>
    <li class="active crumb">@lang('orders.make_order')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#orders-make-order" id="orders-make-order-tab" data-toggle="tab" aria-expanded="true">@lang('orders.make_order')</a></li>
      <li class=""><a href="#orders-view-order" id="orders-view-order-tab" data-toggle="tab" aria-expanded="false">@lang('orders.view_order')</a></li>
      <li class=""><a href="#orders-load-order" id="orders-load-order-tab" data-toggle="tab" aria-expanded="false">@lang('orders.load_order')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="orders-make-order">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="orders-client" class="control-label">@lang('orders.client')</label>
              <input type="text" class="form-control" id="orders-client">
            </div>
          </div>
          <div class="col-lg-5 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="orders-credit" class="control-label">@lang('orders.available_credit')</label>
              <input type="text" class="form-control" id="orders-credit">
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 center-block">
            <div class="row form-inline">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:35px;">
                <div class="form-group">
                  <label for="orders-code" class="control-label">@lang('orders.code')</label>
                  <input type="text" class="form-control" id="orders-code">
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('orders.code')</th>
                      <th>@lang('orders.description')</th>
                      <th>@lang('orders.quantity')</th>
                      <th>@lang('orders.price')</th>
                      <th>@lang('orders.discount')</th>
                      <th>@lang('orders.total')</th>
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
          <div class="col-lg-4 col-md-3 col-sm-2 xs-hidden">
          </div>
          <div class="col-lg-8 col-md-9 col-sm-10 col-xs-12">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 hidden-xs">
                <div class="form-group">
                  <button type="button" class="btn btn-success" class="orders-send">
                    <i class="fa fa-send"></i> @lang('orders.send')
                  </button>
                </div>
              </div>
              <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 form-inline">
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="orders-subtotal" class="control-label">@lang('orders.subtotal')</label>
                      <input type="text" class="form-control" id="orders-subtotal">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="orders-discount" class="control-label">@lang('orders.discount')</label>
                      <input type="text" class="form-control" id="orders-discount">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="orders-tax" class="control-label">@lang('orders.tax')</label>
                      <input type="text" class="form-control" id="orders-tax">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="orders-total" class="control-label">@lang('orders.total')</label>
                      <input type="text" class="form-control" id="orders-total">
                    </div>
                  </div>
                </div>
              </div>
              <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                <div class="form-group">
                  <button type="button" class="btn btn-success" class="orders-send">
                    <i class="fa fa-send"></i> @lang('orders.send')
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="orders-view-order">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="reservation-client" class="control-label">@lang('orders.client')</label>
              <input type="text" class="form-control" id="reservation-client">
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 center-block">
            <div class="row form-inline">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:35px;">
                <div class="form-group">
                  <label for="reservation-code" class="control-label">@lang('orders.code')</label>
                  <input type="text" class="form-control" id="reservation-code">
                </div>
              </div>
            </div>
            <div class="row form-inline center-block" style="padding-top:15px;">
              <div class="col-lg-7 col-md-12 col-sm-6 col-xs-12">
                <div class="form-group">
                  <button type="button" class="btn btn-info" id="reservation-print-reservation">
                    <i class="fa fa-print"></i> @lang('orders.print_reservation')
                  </button>
                </div>
              </div>
              <div class="col-lg-5 col-md-12 col-sm-6 col-xs-12 md-top-space">
                <div class="form-group">
                  <button type="button" class="btn btn-success" id="reservation-load-reservation">
                    <i class="fa fa-download"></i> @lang('sales.load_reservation')
                  </button>
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 sm-top-space md-top-space lg-top-space">
                <div class="form-group">
                  <button type="button" class="btn btn-success" id="reservation-send-cashbox">
                    <i class="fa fa-send"></i> @lang('sales.send_cashbox')
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('sales.code')</th>
                      <th>@lang('sales.description')</th>
                      <th>@lang('sales.quantity')</th>
                      <th>@lang('sales.price')</th>
                      <th>@lang('sales.discount')</th>
                      <th>@lang('sales.total')</th>
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
          <div class="col-lg-4 col-md-3 col-sm-2 xs-hidden">
          </div>
          <div class="col-lg-8 col-md-9 col-sm-10 col-xs-12">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 hidden-xs">
                <div class="form-group">
                  <button type="button" class="btn btn-success" id="reservation-pay">
                    <i class="fa fa-money"></i> @lang('sales.pay')
                  </button>
                </div>
                <div class="form-group">
                  <button type="button" class="btn btn-info" id="reservation-credit-sale">
                    <i class="fa fa-book"></i> @lang('sales.credit_sale')
                  </button>
                </div>
              </div>
              <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 form-inline">
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="reservation-subtotal" class="control-label">@lang('sales.subtotal')</label>
                      <input type="text" class="form-control" id="reservation-subtotal">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="reservation-discount" class="control-label">@lang('sales.discount')</label>
                      <input type="text" class="form-control" id="reservation-discount">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="reservation-tax" class="control-label">@lang('sales.tax')</label>
                      <input type="text" class="form-control" id="reservation-tax">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="reservation-total" class="control-label">@lang('sales.total')</label>
                      <input type="text" class="form-control" id="reservation-total">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="reservation-total" class="control-label">@lang('sales.deposit')</label>
                      <input type="text" class="form-control" id="reservation-deposit">
                    </div>
                  </div>
                </div>
              </div>
              <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                <div class="form-group">
                  <button type="button" class="btn btn-success" id="reservation-pay">
                    <i class="fa fa-money"></i> @lang('sales.pay')
                  </button>
                </div>
                <div class="form-group">
                  <button type="button" class="btn btn-info" id="reservation-credit-sale">
                    <i class="fa fa-book"></i> @lang('sales.credit_sale')
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="orders-load-order">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
            <div class="form-group">
              <label for="subscription-client" class="control-label">@lang('sales.client')</label>
              <input type="text" class="form-control" id="subscription-client">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-7 col-xs-12">
            <div class="form-group">
              <label for="subscription-interval" class="control-label">@lang('sales.billing_interval')</label>
              <select id="subscription-interval" class="form-control">
                <option value="weekly">@lang('sales.weekly')</option>
                <option value="biweekly">@lang('sales.biweekly')</option>
                <option value="monthly">@lang('sales.monthly')</option>
                <option value="bimester">@lang('sales.bimester')</option>
                <option value="trimester">@lang('sales.trimester')</option>
                <option value="semester">@lang('sales.semester')</option>
                <option value="annualy">@lang('sales.annually')</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-7 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="subscription-interval-type" class="control-label">@lang('sales.interval_type')</label>
              <select id="subscription-interval-type" class="form-control">
                <option value="every">@lang('sales.every')</option>
                <option value="over">@lang('sales.over')</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row form-inline lg-top-space md-top-space sm-top-space">
          <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
            <div class="form-group">
              <label for="subscription-start-date" class="control-label">@lang('sales.start_date')</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control datepicker" id="subscription-start-date">
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-7 col-xs-12">
            <div class="form-group">
              <label for="subscription-interval-number" class="control-label">@lang('sales.interval_number')</label>
              <input type="number" class="form-control" id="subscription-start-number">
            </div>
          </div>
          <div class="col-lg-3 col-md-4 col-sm-7 col-xs-12 sm-top-space">
            <div class="form-group">
              <label for="subscription-contract" class="control-label">@lang('sales.contract')</label>
              <input type="text" class="form-control" id="subscription-contract">
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 center-block">
            <div class="row form-inline">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:35px;">
                <div class="form-group">
                  <label for="subscription-code" class="control-label">@lang('sales.code')</label>
                  <input type="text" class="form-control" id="subscription-code">
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('sales.code')</th>
                      <th>@lang('sales.description')</th>
                      <th>@lang('sales.quantity')</th>
                      <th>@lang('sales.price')</th>
                      <th>@lang('sales.discount')</th>
                      <th>@lang('sales.total')</th>
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
          <div class="col-lg-4 col-md-3 col-sm-2 xs-hidden">
          </div>
          <div class="col-lg-8 col-md-9 col-sm-10 col-xs-12">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 hidden-xs">
                <div class="form-group">
                  <button type="button" class="btn btn-success" id="subscription-pay">
                    <i class="fa fa-plus-square-o"></i> @lang('sales.subscribe')
                  </button>
                </div>
              </div>
              <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 form-inline">
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="subscription-subtotal" class="control-label">@lang('sales.subtotal')</label>
                      <input type="text" class="form-control" id="subscription-subtotal">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="subscription-discount" class="control-label">@lang('sales.discount')</label>
                      <input type="text" class="form-control" id="subscription-discount">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="subscription-tax" class="control-label">@lang('sales.tax')</label>
                      <input type="text" class="form-control" id="subscription-tax">
                    </div>
                  </div>
                </div>
                <div class="row pull-right">
                  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 lg-top-space">
                    <div class="form-group">
                      <label for="subscription-total" class="control-label">@lang('sales.total')</label>
                      <input type="text" class="form-control" id="subscription-total">
                    </div>
                  </div>
                </div>
              </div>
              <div class="hidden-lg hidden-md hidden-sm col-xs-12">
                <div class="form-group">
                  <button type="button" class="btn btn-success" id="subscription-pay">
                    <i class="fa fa-plus-square-o"></i> @lang('sales.subscribe')
                  </button>
                </div>
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
