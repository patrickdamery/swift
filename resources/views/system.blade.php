@php
  // Get data we need to display.
  use App\Configuration;
  use App\Branch;
  use App\User;
  use App\Worker;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
  $worker = Worker::where('code', Auth::user()->worker_code)->first();
@endphp
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ Session::token() }}">
    <link rel="shortcut icon" href="{{ URL::to('/') }}/images/swift.ico" type="image/x-icon">
    <title>Swift</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/base.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/swift/swift.css">
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/swift/print/a4.css">

    <!-- JS Files -->
    <script src="{{ URL::to('/') }}/js/all.js"></script>
    <script src="{{ URL::to('/') }}/js/swift/language.js"></script>
    <script src="{{ URL::to('/') }}/js/swift/utils.js"></script>
    <script src="{{ URL::to('/') }}/js/swift/event_tracker.js"></script>
    <script src="{{ URL::to('/') }}/js/swift/menu.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
  <div class="print_area">
  </div>
  <div class="wrapper">
    <div>
      <div class="wrapper">
        <div id="alerts-area" style="position:fixed;width:100%;z-index:9999"></div>
      </div>
    </div>

    <header class="main-header">
      <!-- Logo -->
      <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{{ $config->shortname }}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{ $config->name }}</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">10</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 10 notifications</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li>
                      <a href="#">
                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                        page and may cause design problems
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-users text-red"></i> 5 new members joined
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-user text-red"></i> You changed your username
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer"><a href="#">View all</a></li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-success">4</span>
              </a>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ URL::to('/') }}/images/default-profile.png" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ $worker->name }}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle" alt="User Image">

                  <p>
                    {{ $worker->name }} - {{ $worker->job_title }}
                  </p>
                </li>
                <!-- Menu Footer-->
                <script>
                  var option = {
                    'profile-top': '/swift/system/profile'
                  };
                  swift_menu.register_menu_option(option);
                  swift_event_tracker.register_swift_event('#profile-top', 'click', swift_menu, 'select_menu_option');
                  $(document).on('click', '#profile-top', function(e) {
                    e.preventDefault();
                    swift_event_tracker.fire_event(e, '#profile-top');
                  });
                </script>
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="#profile" id="profile-top" class="btn btn-default btn-flat">@lang('swift_menu.profile')</a>
                  </div>
                  <div class="pull-right">
                    <a href="{{ URL::to('/') }}/logout" class="btn btn-default btn-flat">@lang('swift_menu.logout')</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle">
          </div>
          <div class="pull-left info">
            <p>{{ $worker->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> @lang('swift_menu.online')</a>
          </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="@lang('swift_menu.search')">
            <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                  </button>
                </span>
          </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">@lang('swift_menu.main_menu')</li>
          @if($modules->sales_stock == 1)
            <script>
              var option = {
                'sales': '/swift/system/sales'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#sales', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#sales', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#sales');
              });

              option = {
                'orders': '/swift/system/orders'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#orders', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#orders', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#orders');
              });

              option = {
                'cashbox': '/swift/system/cashbox'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#cashbox', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#cashbox', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#cashbox');
              });

              option = {
                'clients': '/swift/system/clients'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#clients', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#clients', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#clients');
              });

              option = {
                'discounts': '/swift/system/discounts'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#discounts', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#discounts', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#discounts');
              });

              option = {
                'sales_analytics': '/swift/system/sales_analytics'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#sales_analytics', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#sales_analytics', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#sales_analytics');
              });
            </script>
            <li class="treeview">
              <a href="">
                <i class="fa fa-shopping-cart"></i>
                <span>@lang('swift_menu.sales')</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#sales" id="sales"><i class="fa fa-money"></i> @lang('swift_menu.sales')</a></li>
                <li><a href="#orders" id="orders"><i class="fa fa-cubes"></i> @lang('swift_menu.orders')</a></li>
                <li><a href="#cashbox" id="cashbox"><i class="fa fa-money"></i> @lang('swift_menu.cashbox')</a></li>
                <li><a href="#clients" id="clients"><i class="fa fa-group"></i> @lang('swift_menu.clients')</a></li>
                <li><a href="#discounts" id="discounts"><i class="fa fa-tag"></i> @lang('swift_menu.discounts')</a></li>
                <li><a href="#sales_analytics" id="sales_analytics"><i class="fa fa-line-chart"></i> @lang('swift_menu.sales_analysis')</a></li>
              </ul>
            </li>
            <script>
              var option = {
                'products': '/swift/system/products'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#products', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#products', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#products');
              });
              option = {
                'providers': '/swift/system/providers'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#providers', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#providers', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#providers');
              });
              option = {
                'categories': '/swift/system/categories'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#categories', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#categories', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#categories');
              });
              option = {
                'measurement_units': '/swift/system/measurement_units'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#measurement_units', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#measurement_units', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#measurement_units');
              });
              option = {
                'purchases': '/swift/system/purchases'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#purchases', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#purchases', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#purchases');
              });
              option = {
                'local_purchases': '/swift/system/local_purchases'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#local_purchases', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#local_purchases', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#local_purchases');
              });
              option = {
                'suggestions': '/swift/system/suggestions'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#suggestions', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#suggestions', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#suggestions');
              });
            </script>
            <li class="treeview">
              <a href="">
                <i class="fa fa-cubes"></i>
                <span>@lang('swift_menu.products')</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#products" id="products"><i class="fa fa-cube"></i> @lang('swift_menu.view_products')</a></li>
                <li><a href="#providers" id="providers"><i class="fa fa-industry"></i> @lang('swift_menu.view_providers')</a></li>
                <li><a href="#categories" id="categories"><i class="fa fa-list"></i> @lang('swift_menu.view_categories')</a></li>
                <li><a href="#measurement_units" id="measurement_units"><i class="fa fa-list"></i> @lang('swift_menu.measurement_units')</a></li>
                <li><a href="#purchases" id="purchases"><i class="fa fa-shopping-cart"></i> @lang('swift_menu.view_purchases')</a></li>
                <li><a href="#local_purchases" id="local_purchases"><i class="fa fa-truck"></i> @lang('swift_menu.local_purchase')</a></li>
                <li class="treeview">
                  <a href=""><i class="fa fa-ship"></i> @lang('swift_menu.international_purchase')</a>
                  <ul class="treeview-menu">
                    <li><a href="#importation_order"><i class="fa fa-envelope"></i> @lang('swift_menu.importation_order')</a></li>
                    <li><a href="#importation_costs"><i class="fa fa-money"></i> @lang('swift_menu.importation_costs')</a></li>
                    <li><a href="#importation_bill"><i class="fa fa-file-text-o"></i> @lang('swift_menu.importation_bill')</a></li>
                  </ul>
                </li>
                <li><a href="#suggestions" id="suggestions"><i class="fa fa-sitemap"></i> @lang('swift_menu.purchase_suggestion')</a></li>
              </ul>
            </li>
          @endif
          @if($modules->warehouses == 1)
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
          @endif
          @if($modules->staff == 1)
            <script>
              var option = {
                'staff': '/swift/system/staff'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#staff', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#staff', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#staff');
              });
              option = {
                'staff_configuration': '/swift/system/staff_configuration'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#staff_configuration', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#staff_configuration', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#staff_configuration');
              });
              option = {
                'staff_analytics': '/swift/system/staff_analytics'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#staff_analytics', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#staff_analytics', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#staff_analytics');
              });
              option = {
                'staff_payments': '/swift/system/staff_payments'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#staff_payments', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#staff_payments', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#staff_payments');
              });
              option = {
                'staff_assistance': '/swift/system/staff_assistance'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#staff_assistance', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#staff_assistance', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#staff_assistance');
              });
            </script>
            <li class="treeview">
              <a href="">
                <i class="fa fa-users"></i>
                <span>@lang('swift_menu.staff')</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#staff" id="staff"><i class="fa fa-user"></i> @lang('swift_menu.view_staff')</a></li>
                <li><a href="#staff_config" id="staff_configuration"><i class="fa fa-cogs"></i> @lang('swift_menu.staff_config')</a></li>
                <li><a href="#staff_analytics" id="staff_analytics"><i class="fa fa-pie-chart"></i> @lang('swift_menu.staff_analysis')</a></li>
                <li><a href="#staff_payments" id="staff_payments"><i class="fa fa-money"></i> @lang('swift_menu.staff_payments')</a></li>
                <li><a href="#staff_assistance" id="staff_assistance"><i class="fa fa-calendar-check-o"></i> @lang('swift_menu.staff_assistance')</a></li>
              </ul>
            </li>
          @endif
          @if($modules->vehicles == 1)
            <script>
              var option = {
                'vehicles': '/swift/system/vehicles'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#vehicles', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#vehicles', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#vehicles');
              });

              option = {
                'journeys': '/swift/system/journeys'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#journeys', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#journeys', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#journeys');
              });

              option = {
                'routes': '/swift/system/routes'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#routes', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#routes', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#routes');
              });
            </script>
            <li class="treeview">
              <a href="">
                <i class="fa fa-truck"></i>
                <span>@lang('swift_menu.vehicles')</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#view_vehicles" id="vehicles"><i class="fa fa-car"></i> @lang('swift_menu.view_vehicles')</a></li>
                <li><a href="#view_trips" id="journeys"><i class="fa fa-map"></i> @lang('swift_menu.view_trips')</a></li>
                <li><a href="#routes" id="routes"><i class="fa fa-map-signs"></i> @lang('swift_menu.routes')</a></li>
              </ul>
            </li>
          @endif
          @if($modules->accounting == 1)
            <script>
              var option = {
                'bank_accounts': '/swift/system/bank_accounts'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#bank_accounts', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#bank_accounts', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#bank_accounts');
              });

              option = {
                'currency': '/swift/system/currency'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#currency', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#currency', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#currency');
              });

              option = {
                'accounts': '/swift/system/accounts'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#accounts', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#accounts', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#accounts');
              });

              option = {
                'journal': '/swift/system/journal'
              };
              swift_menu.register_menu_option(option);
              swift_event_tracker.register_swift_event('#journal', 'click', swift_menu, 'select_menu_option');
              $(document).on('click', '#journal', function(e) {
                e.preventDefault();
                swift_event_tracker.fire_event(e, '#journal');
              });
            </script>
            <li class="treeview">
              <a href="">
                <i class="fa fa-book"></i>
                <span>@lang('swift_menu.accountancy')</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#bank_accounts" id="bank_accounts"><i class="fa fa-bank"></i> @lang('swift_menu.bank_accounts')</a></li>
                <li><a href="#currency" id="currency"><i class="fa fa-money"></i> @lang('swift_menu.currency')</a></li>
                <li><a href="#accounts" id="accounts"><i class="fa fa-square"></i> @lang('swift_menu.accounts')</a></li>
                <li><a href="#journal" id="journal"><i class="fa fa-book"></i> @lang('swift_menu.journal')</a></li>
              </ul>
            </li>
          @endif
          <script>
            var option = {
              'branch': '/swift/system/branch'
            };
            swift_menu.register_menu_option(option);
            swift_event_tracker.register_swift_event('#branch', 'click', swift_menu, 'select_menu_option');
            $(document).on('click', '#branch', function(e) {
              e.preventDefault();
              swift_event_tracker.fire_event(e, '#branch');
            });
            option = {
              'group': '/swift/system/group'
            };
            swift_menu.register_menu_option(option);
            swift_event_tracker.register_swift_event('#group', 'click', swift_menu, 'select_menu_option');
            $(document).on('click', '#group', function(e) {
              e.preventDefault();
              swift_event_tracker.fire_event(e, '#group');
            });
            option = {
              'configuration': '/swift/system/configuration'
            };
            swift_menu.register_menu_option(option);
            swift_event_tracker.register_swift_event('#configuration', 'click', swift_menu, 'select_menu_option');
            $(document).on('click', '#configuration', function(e) {
              e.preventDefault();
              swift_event_tracker.fire_event(e, '#configuration');
            });
          </script>
          <li class="treeview">
            <a href="">
              <i class="fa fa-cogs"></i>
              <span>@lang('swift_menu.general_config')</span>
            </a>
            <ul class="treeview-menu">
              <li><a href="#branch" id="branch"><i class="fa fa-building"></i> @lang('swift_menu.branches')</a></li>
              <li><a href="#group" id="group"><i class="fa fa-users"></i> @lang('swift_menu.groups')</a></li>
              <li><a href="#configuration" id="configuration"><i class="fa fa-cogs"></i> @lang('swift_menu.config')</a></li>
            </ul>
          </li>
        </ul>
      </section>
    </aside>
    <div class="content-wrapper" id="main-content">
      @include('system.modules.accounting.currency')
    </div>
    <footer class="main-footer">
      <strong>Copyright &copy; {{ date('Y') }} <a href="http://alonica.net">Alonica S.A</a>.</strong> All rights
      reserved.
    </footer>

    <aside class="control-sidebar control-sidebar-dark">
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-contacts-tab" data-toggle="tab"><i class="fa fa-users"></i></a></li>
        <li><a href="#control-sidebar-chat-tab" data-toggle="tab"><i class="fa fa-envelope-o"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="control-sidebar-contacts-tab">
          <div class="contacts-search">
            <input type="text" placeholder="@lang('swift_menu.search')" class="form-control">
          </div>
          <ul class="contact-menu">
            <li class="contact-block"><!-- start message -->
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Informatica <span class="label label-success">2</span>
                  <small><i class="fa fa-clock-o"></i> 5 mins</small>
                </h4>
                <p>Ya se resolvio el problema de la impresora.</p>
              </a>
            </li>
            <!-- end message -->
            <li class="contact-block">
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Jose Ramos <span class="label label-success">1</span>
                  <small><i class="fa fa-clock-o"></i> 2 hours</small>
                </h4>
                <p>Ok</p>
              </a>
            </li>
            <li class="contact-block">
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Swift Support
                  <small><i class="fa fa-clock-o"></i> Hoy</small>
                </h4>
                <p><span class="received"><i class="fa fa-check"></i></span>  Ok, ahora si entiendo!</p>
              </a>
            </li>
            <li class="contact-block">
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Contabilidad <span class="label label-success">1</span>
                  <small><i class="fa fa-clock-o"></i> Ayer</small>
                </h4>
                <p>Ya se genero el cheque.</p>
              </a>
            </li>
            <li class="contact-block">
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Maria Jose
                  <small><i class="fa fa-clock-o"></i> 2 days</small>
                </h4>
                <p>Ok</p>
              </a>
            </li>
            <li class="contact-block"><!-- start message -->
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Informatica
                  <small><i class="fa fa-clock-o"></i> 5 mins</small>
                </h4>
                <p>Ya se resolvio el problema de la impresora.</p>
              </a>
            </li>
            <!-- end message -->
            <li class="contact-block">
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Jose Ramos
                  <small><i class="fa fa-clock-o"></i> 2 hours</small>
                </h4>
                <p>Ok</p>
              </a>
            </li>
            <li class="contact-block">
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Swift Support
                  <small><i class="fa fa-clock-o"></i> Hoy</small>
                </h4>
                <p><span class="received"><i class="fa fa-check"></i></span>  Ok, ahora si entiendo!</p>
              </a>
            </li>
            <li class="contact-block">
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Contabilidad
                  <small><i class="fa fa-clock-o"></i> Ayer</small>
                </h4>
                <p>Ya se genero el cheque.</p>
              </a>
            </li>
            <li class="contact-block">
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Maria Jose
                  <small><i class="fa fa-clock-o"></i> 2 days</small>
                </h4>
                <p>Ok</p>
              </a>
            </li>
            <li class="contact-block"><!-- start message -->
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Informatica
                  <small><i class="fa fa-clock-o"></i> 5 mins</small>
                </h4>
                <p>Ya se resolvio el problema de la impresora.</p>
              </a>
            </li>
            <!-- end message -->
            <li class="contact-block">
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Jose Ramos
                  <small><i class="fa fa-clock-o"></i> 2 hours</small>
                </h4>
                <p>Ok</p>
              </a>
            </li>
            <li class="contact-block">
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Swift Support
                  <small><i class="fa fa-clock-o"></i> Hoy</small>
                </h4>
                <p><span class="received"><i class="fa fa-check"></i></span>  Ok, ahora si entiendo!</p>
              </a>
            </li>
            <li class="contact-block">
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Contabilidad
                  <small><i class="fa fa-clock-o"></i> Ayer</small>
                </h4>
                <p>Ya se genero el cheque.</p>
              </a>
            </li>
            <li class="contact-block">
              <a href="#">
                <div class="pull-left">
                  <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle img-contact" alt="User Image">
                </div>
                <h4>
                  Maria Jose
                  <small><i class="fa fa-clock-o"></i> 2 days</small>
                </h4>
                <p>Ok</p>
              </a>
            </li>
          </ul>
        </div>
        <div class="tab-pane" id="control-sidebar-chat-tab">
          <div class="direct-chat-messages">
            <!-- Message. Default to the left -->
            <div class="direct-chat-msg">
              <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-left">Swift Support</span>
                <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
              </div>
              <!-- /.direct-chat-info -->
              <img class="direct-chat-img" src="{{ URL::to('/') }}/images/default-profile.png" alt="Message User Image"><!-- /.direct-chat-img -->
              <div class="direct-chat-text">
                Para realizar una venta de primero abris el menu, despues seleccionas el menu Ventas.
                Una vez ahi te van a salir las opciones que tenes disponible, si te sale la opcion Ventas
                seleccionala, de ahi llenas la informacion de la factura y le das pagar y ya. Algo mas en que
                te podamos ayudar?
              </div>
              <!-- /.direct-chat-text -->
            </div>
            <!-- /.direct-chat-msg -->

            <!-- Message to the right -->
            <div class="direct-chat-msg right">
              <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-right">{{ $worker->name }}</span>
                <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
              </div>
              <!-- /.direct-chat-info -->
              <img class="direct-chat-img" src="{{ URL::to('/') }}/images/default-profile.png" alt="Message User Image"><!-- /.direct-chat-img -->
              <div class="direct-chat-text">
                Ok, ahora si entiendo!
              </div>
              <!-- /.direct-chat-text -->
            </div>
            <!-- /.direct-chat-msg -->
          </div>
          <div>
            <div class="input-group">
              <input type="text" name="message" placeholder="@lang('swift_menu.type_message')" class="form-control">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary btn-flat">@lang('swift_menu.send')</button>
                  </span>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="control-sidebar-settings-tab">
          <h4 class="control-sidebar-heading">@lang('swift_menu.themes')</h4>
          <ul class="list-unstyled clearfix">
            <li style="float:left; width: 33.33333%; padding: 5px;">
              <a href="javascript:void(0)" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                  <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span>
                  <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                  <span style="display:block; width: 20%; float: left; height: 40px; background: #222d32"></span>
                  <span style="display:block; width: 80%; float: left; height: 40px; background: #f4f5f7"></span>
                </div>
              </a>
              <p class="text-center no-margin">@lang('swift_menu.blue')</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;">
              <a href="javascript:void(0)" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                  <span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span>
                  <span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span>
                </div>
                <div>
                  <span style="display:block; width: 20%; float: left; height: 40px; background: #222"></span>
                  <span style="display:block; width: 80%; float: left; height: 40px; background: #f4f5f7"></span>
                </div>
              </a>
              <p class="text-center no-margin">@lang('swift_menu.black')</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;">
              <a href="javascript:void(0)" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                  <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                  <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                  <span style="display:block; width: 20%; float: left; height: 40px; background: #222d32"></span>
                  <span style="display:block; width: 80%; float: left; height: 40px; background: #f4f5f7"></span>
                </div>
              </a>
              <p class="text-center no-margin">@lang('swift_menu.purple')</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;">
              <a href="javascript:void(0)" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                  <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                  <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                  <span style="display:block; width: 20%; float: left; height: 40px; background: #222d32"></span>
                  <span style="display:block; width: 80%; float: left; height: 40px; background: #f4f5f7"></span>
                </div>
              </a>
              <p class="text-center no-margin">@lang('swift_menu.green')</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;">
              <a href="javascript:void(0)" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                  <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                  <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                  <span style="display:block; width: 20%; float: left; height: 40px; background: #222d32"></span>
                  <span style="display:block; width: 80%; float: left; height: 40px; background: #f4f5f7"></span>
                </div>
              </a>
              <p class="text-center no-margin">@lang('swift_menu.red')</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;">
              <a href="javascript:void(0)" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                <div>
                  <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                  <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                </div>
                <div>
                  <span style="display:block; width: 20%; float: left; height: 40px; background: #222d32"></span>
                  <span style="display:block; width: 80%; float: left; height: 40px; background: #f4f5f7"></span>
                </div>
              </a>
              <p class="text-center no-margin">@lang('swift_menu.yellow')</p>
            </li>
          </ul>
          <h3 class="control-sidebar-heading">@lang('swift_menu.chat_settings')</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              @lang('swift_menu.show_online')
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <div class="form-group">
            <label class="control-sidebar-subheading">
              @lang('swift_menu.off_notifications')
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <div class="form-group">
            <label class="control-sidebar-subheading">
              @lang('swift_menu.delete_chat')
              <a href="" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
        </div>
      </div>
    </aside>
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    </div>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
  </body>
</html>
