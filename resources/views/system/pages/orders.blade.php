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
              <label for="orders-make-client" class="control-label">@lang('orders.client')</label>
              <input type="text" class="form-control" id="orders-make-client">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="orders-credit" class="control-label">@lang('orders.available_credit')</label>
              <input type="text" class="form-control" id="orders-credit">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="orders-type" class="control-label">@lang('orders.type')</label>
              <select class="form-control" id="orders-type">
                <option value="credit">@lang('orders.credit')</option>
                <option value="cash">@lang('orders.cash')</option>
              </select>
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
              <label for="view-orders-client" class="control-label">@lang('orders.view_client')</label>
              <input type="text" class="form-control" id="view-orders-client">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="view-orders" class="control-label">@lang('orders.view_orders')</label>
              <select class="form-control" id="view-orders">
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sm-top-space">
            <div class="form-group">
              <button type="button" class="btn btn-info" id="load-orders">
                <i class="fa fa-download"></i> @lang('orders.load_orders')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 center-block">
            <div class="row form-inline">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:35px;">
                <div class="form-group">
                  <label for="order-state" class="control-label">@lang('orders.state')</label>
                  <select class="form-control" id="order-state">
                    <option value="queued">@lang('orders.queued')</option>
                    <option value="loading">@lang('orders.loading')</option>
                    <option value="enroute">@lang('orders.enroute')</option>
                    <option value="delivered">@lang('orders.delivered')</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row form-inline center-block" style="padding-top:15px;">
              <div class="col-lg-7 col-md-12 col-sm-6 col-xs-12">
                <div class="form-group">
                  <button type="button" class="btn btn-info" id="view-order-print">
                    <i class="fa fa-print"></i> @lang('orders.print')
                  </button>
                </div>
              </div>
              <div class="col-lg-5 col-md-12 col-sm-6 col-xs-12 md-top-space">
                <div class="form-group">
                  <button type="button" class="btn btn-success" id="order-sale">
                    <i class="fa fa-money"></i> @lang('orders.sale')
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
                      <th>@lang('orders.code')</th>
                      <th>@lang('orders.description')</th>
                      <th>@lang('orders.quantity')</th>
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
      <div class="tab-pane" id="orders-load-order">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
            <div class="form-group">
              <label for="load-order-code" class="control-label">@lang('orders.order_code')</label>
              <input type="text" class="form-control" id="load-order-code">
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-7 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="load-orders-load">
                <i class="fa fa-download"></i> @lang('orders.load_orders')
              </button>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:15px;">
          <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 center-block">
            <div class="row form-inline">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:35px;">
                <div class="form-group">
                  <label for="load-orders-code" class="control-label">@lang('orders.code')</label>
                  <input type="text" class="form-control" id="load-orders-code">
                </div>
              </div>
            </div>
            <div class="row form-inline" style="padding-top15px">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:35px;">
                <div class="form-group">
                  <label for="load-orders-driver" class="control-label">@lang('orders.driver')</label>
                  <select class="form-control" id="load-orders-driver">
                  </select>
                </div>
              </div>
            </div>
            <div class="row form-inline">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="load-orders-vehicle" class="control-label">@lang('orders.vehicle')</label>
                  <select class="form-control" id="load-orders-vehicle">
                  </select>
                </div>
              </div>
            </div>
            <div class="row form-inline">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="load-orders-state" class="control-label">@lang('orders.state')</label>
                  <select class="form-control" id="load-orders-state">
                    <option value="queued">@lang('orders.queued')</option>
                    <option value="loading">@lang('orders.loading')</option>
                    <option value="enroute">@lang('orders.enroute')</option>
                    <option value="delivered">@lang('orders.delivered')</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row form-inline">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <button type="button" class="btn btn-info" id="load-orders-save">
                    <i class="fa fa-save"></i> @lang('orders.save')
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
                      <th>@lang('orders.code')</th>
                      <th>@lang('orders.description')</th>
                      <th>@lang('orders.quantity')</th>
                      <th>@lang('orders.scanned')</th>
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
