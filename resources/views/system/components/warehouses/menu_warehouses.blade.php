<script>
  var option = {
    'warehouse': '/swift/system/warehouse'
  };
  swift_menu.register_menu_option(option);
  swift_event_tracker.register_swift_event('#warehouse', 'click', swift_menu, 'select_menu_option');
  $(document).on('click', '#warehouse', function(e) {
    e.preventDefault();
    swift_event_tracker.fire_event(e, '#warehouse');
  });

  option = {
    'receive-products': '/swift/system/receive_products'
  };
  swift_menu.register_menu_option(option);
  swift_event_tracker.register_swift_event('#receive-products', 'click', swift_menu, 'select_menu_option');
  $(document).on('click', '#receive-products', function(e) {
    e.preventDefault();
    swift_event_tracker.fire_event(e, '#receive-products');
  });

  option = {
    'dispatch-products': '/swift/system/dispatch_products'
  };
  swift_menu.register_menu_option(option);
  swift_event_tracker.register_swift_event('#dispatch-products', 'click', swift_menu, 'select_menu_option');
  $(document).on('click', '#dispatch-products', function(e) {
    e.preventDefault();
    swift_event_tracker.fire_event(e, '#dispatch-products');
  });

  option = {
    'stock': '/swift/system/stock'
  };
  swift_menu.register_menu_option(option);
  swift_event_tracker.register_swift_event('#stock', 'click', swift_menu, 'select_menu_option');
  $(document).on('click', '#stock', function(e) {
    e.preventDefault();
    swift_event_tracker.fire_event(e, '#stock');
  });

  option = {
    'stock_movement': '/swift/system/stock_movement'
  };
  swift_menu.register_menu_option(option);
  swift_event_tracker.register_swift_event('#stock_movement', 'click', swift_menu, 'select_menu_option');
  $(document).on('click', '#stock_movement', function(e) {
    e.preventDefault();
    swift_event_tracker.fire_event(e, '#stock_movement');
  });
</script>
<li class="treeview">
  <a href="">
    <i class="fa fa-building"></i>
    <span>@lang('swift_menu.warehouses')</span>
  </a>
  <ul class="treeview-menu">
    <li><a href="#warehouse" id="warehouse"><i class="fa fa-building"></i> @lang('swift_menu.view_warehouse')</a></li>
    <li><a href="#receive_products" id="receive-products"><i class="fa fa-plus"></i> @lang('swift_menu.receive_products')</a></li>
    <li><a href="#dispatch_products" id="dispatch-products"><i class="fa fa-minus"></i> @lang('swift_menu.dispatch_products')</a></li>
    <li><a href="#stock" id="stock"><i class="fa fa-list"></i> @lang('swift_menu.stock')</a></li>
    <li><a href="#stock_movement" id="stock_movement"><i class="fa fa-arrows-h"></i> @lang('swift_menu.stock_movement')</a></li>
  </ul>
</li>
