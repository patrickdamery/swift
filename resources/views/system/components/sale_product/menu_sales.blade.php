@php
  use App\User;
  use App\UserAccess;

  $access = json_decode(UserAccess::where('code', Auth::user()->user_access_code)->first()->access);
@endphp
@if($access->sales->has)
  <script>
    var option = {};
    @if($access->sales->sales->has)
      option = {
        'sales': '/swift/system/sales'
      };
      swift_menu.register_menu_option(option);
      swift_event_tracker.register_swift_event('#sales', 'click', swift_menu, 'select_menu_option');
      $(document).on('click', '#sales', function(e) {
        e.preventDefault();
        swift_event_tracker.fire_event(e, '#sales');
      });
    @endif
    @if($access->sales->orders->has)
      option = {
        'orders': '/swift/system/orders'
      };
      swift_menu.register_menu_option(option);
      swift_event_tracker.register_swift_event('#orders', 'click', swift_menu, 'select_menu_option');
      $(document).on('click', '#orders', function(e) {
        e.preventDefault();
        swift_event_tracker.fire_event(e, '#orders');
      });
    @endif
    @if($access->sales->cashbox->has)
      option = {
        'cashbox': '/swift/system/cashbox'
      };
      swift_menu.register_menu_option(option);
      swift_event_tracker.register_swift_event('#cashbox', 'click', swift_menu, 'select_menu_option');
      $(document).on('click', '#cashbox', function(e) {
        e.preventDefault();
        swift_event_tracker.fire_event(e, '#cashbox');
      });
    @endif
    @if($access->sales->clients->has)
      option = {
        'clients': '/swift/system/clients'
      };
      swift_menu.register_menu_option(option);
      swift_event_tracker.register_swift_event('#clients', 'click', swift_menu, 'select_menu_option');
      $(document).on('click', '#clients', function(e) {
        e.preventDefault();
        swift_event_tracker.fire_event(e, '#clients');
      });
    @endif
    @if($access->sales->discounts->has)
      option = {
        'discounts': '/swift/system/discounts'
      };
      swift_menu.register_menu_option(option);
      swift_event_tracker.register_swift_event('#discounts', 'click', swift_menu, 'select_menu_option');
      $(document).on('click', '#discounts', function(e) {
        e.preventDefault();
        swift_event_tracker.fire_event(e, '#discounts');
      });
    @endif
    @if($access->sales->sales_analytics->has)
      option = {
        'sales_analytics': '/swift/system/sales_analytics'
      };
      swift_menu.register_menu_option(option);
      swift_event_tracker.register_swift_event('#sales_analytics', 'click', swift_menu, 'select_menu_option');
      $(document).on('click', '#sales_analytics', function(e) {
        e.preventDefault();
        swift_event_tracker.fire_event(e, '#sales_analytics');
      });
    @endif
  </script>
  <li class="treeview">
    <a href="">
      <i class="fa fa-shopping-cart"></i>
      <span>@lang('swift_menu.sales')</span>
    </a>
    <ul class="treeview-menu">
      @if($access->sales->sales->has)
        <li><a href="#sales" id="sales"><i class="fa fa-money"></i> @lang('swift_menu.sales')</a></li>
      @endif
      @if($access->sales->orders->has)
        <li><a href="#orders" id="orders"><i class="fa fa-cubes"></i> @lang('swift_menu.orders')</a></li>
      @endif
      @if($access->sales->cashbox->has)
        <li><a href="#cashbox" id="cashbox"><i class="fa fa-money"></i> @lang('swift_menu.cashbox')</a></li>
      @endif
      @if($access->sales->clients->has)
        <li><a href="#clients" id="clients"><i class="fa fa-group"></i> @lang('swift_menu.clients')</a></li>
      @endif
      @if($access->sales->discounts->has)
        <li><a href="#discounts" id="discounts"><i class="fa fa-tag"></i> @lang('swift_menu.discounts')</a></li>
      @endif
      @if($access->sales->sales_analytics->has)
        <li><a href="#sales_analytics" id="sales_analytics"><i class="fa fa-line-chart"></i> @lang('swift_menu.sales_analysis')</a></li>
      @endif
    </ul>
  </li>
@endif
@if($access->products->has)
<script>
  var option = {};
  @if($access->products->view_products->has)
    option = {
      'products': '/swift/system/products'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#products', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#products', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#products');
    });
  @endif
  @if($access->products->providers->has)
    option = {
      'providers': '/swift/system/providers'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#providers', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#providers', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#providers');
    });
  @endif
  @if($access->products->categories->has)
    option = {
      'categories': '/swift/system/categories'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#categories', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#categories', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#categories');
    });
  @endif
  @if($access->products->measurement_units->has)
    option = {
      'measurement_units': '/swift/system/measurement_units'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#measurement_units', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#measurement_units', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#measurement_units');
    });
  @endif
  @if($access->products->purchases->has)
    option = {
      'purchases': '/swift/system/purchases'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#purchases', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#purchases', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#purchases');
    });
  @endif
  @if($access->products->local_purchases->has)
    option = {
      'local_purchases': '/swift/system/local_purchases'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#local_purchases', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#local_purchases', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#local_purchases');
    });
  @endif
  @if($access->products->suggestions->has)
    option = {
      'suggestions': '/swift/system/suggestions'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#suggestions', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#suggestions', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#suggestions');
    });
  @endif
</script>
<li class="treeview">
  <a href="">
    <i class="fa fa-cubes"></i>
    <span>@lang('swift_menu.products')</span>
  </a>
  <ul class="treeview-menu">
    @if($access->products->view_products->has)
      <li><a href="#products" id="products"><i class="fa fa-cube"></i> @lang('swift_menu.view_products')</a></li>
    @endif
    @if($access->products->providers->has)
      <li><a href="#providers" id="providers"><i class="fa fa-industry"></i> @lang('swift_menu.view_providers')</a></li>
    @endif
    @if($access->products->categories->has)
      <li><a href="#categories" id="categories"><i class="fa fa-list"></i> @lang('swift_menu.view_categories')</a></li>
    @endif
    @if($access->products->measurement_units->has)
      <li><a href="#measurement_units" id="measurement_units"><i class="fa fa-list"></i> @lang('swift_menu.measurement_units')</a></li>
    @endif
    @if($access->products->purchases->has)
      <li><a href="#purchases" id="purchases"><i class="fa fa-shopping-cart"></i> @lang('swift_menu.view_purchases')</a></li>
    @endif
    @if($access->products->local_purchases->has)
      <li><a href="#local_purchases" id="local_purchases"><i class="fa fa-truck"></i> @lang('swift_menu.local_purchase')</a></li>
    @endif
    @if($access->products->international_order->has)
      <li class="treeview">
        <a href=""><i class="fa fa-ship"></i> @lang('swift_menu.international_purchase')</a>
        <ul class="treeview-menu">
          <li><a href="#importation_order"><i class="fa fa-envelope"></i> @lang('swift_menu.importation_order')</a></li>
          <li><a href="#importation_costs"><i class="fa fa-money"></i> @lang('swift_menu.importation_costs')</a></li>
          <li><a href="#importation_bill"><i class="fa fa-file-text-o"></i> @lang('swift_menu.importation_bill')</a></li>
        </ul>
      </li>
    @endif
    @if($access->products->suggestions->has)
      <li><a href="#suggestions" id="suggestions"><i class="fa fa-sitemap"></i> @lang('swift_menu.purchase_suggestion')</a></li>
    @endif
  </ul>
</li>
@endif
