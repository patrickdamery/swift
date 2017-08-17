<?php
  // Get data we need to display.
  use App\Configuration;
  use App\Branch;
  use App\User;
  use App\Worker;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
  $worker = Worker::where('code', Auth::user()->worker_code)->first();
 ?>
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
            <!-- Messages: style can be found in dropdown.less-->
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-success">4</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 4 messages</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li><!-- start message -->
                      <a href="#">
                        <div class="pull-left">
                          <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          Support Team
                          <small><i class="fa fa-clock-o"></i> 5 mins</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <!-- end message -->
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          AdminLTE Design Team
                          <small><i class="fa fa-clock-o"></i> 2 hours</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          Developers
                          <small><i class="fa fa-clock-o"></i> Today</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          Sales Department
                          <small><i class="fa fa-clock-o"></i> Yesterday</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <img src="{{ URL::to('/') }}/images/default-profile.png" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          Reviewers
                          <small><i class="fa fa-clock-o"></i> 2 days</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer"><a href="#">See All Messages</a></li>
              </ul>
            </li>
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
            <!-- Tasks: style can be found in dropdown.less -->
            <li class="dropdown tasks-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-flag-o"></i>
                <span class="label label-danger">9</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 9 tasks</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li><!-- Task item -->
                      <a href="#">
                        <h3>
                          Design some buttons
                          <small class="pull-right">20%</small>
                        </h3>
                        <div class="progress xs">
                          <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                               aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                            <span class="sr-only">20% Complete</span>
                          </div>
                        </div>
                      </a>
                    </li>
                    <!-- end task item -->
                    <li><!-- Task item -->
                      <a href="#">
                        <h3>
                          Create a nice theme
                          <small class="pull-right">40%</small>
                        </h3>
                        <div class="progress xs">
                          <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                               aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                            <span class="sr-only">40% Complete</span>
                          </div>
                        </div>
                      </a>
                    </li>
                    <!-- end task item -->
                    <li><!-- Task item -->
                      <a href="#">
                        <h3>
                          Some task I need to do
                          <small class="pull-right">60%</small>
                        </h3>
                        <div class="progress xs">
                          <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                               aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                            <span class="sr-only">60% Complete</span>
                          </div>
                        </div>
                      </a>
                    </li>
                    <!-- end task item -->
                    <li><!-- Task item -->
                      <a href="#">
                        <h3>
                          Make beautiful transitions
                          <small class="pull-right">80%</small>
                        </h3>
                        <div class="progress xs">
                          <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                               aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                            <span class="sr-only">80% Complete</span>
                          </div>
                        </div>
                      </a>
                    </li>
                    <!-- end task item -->
                  </ul>
                </li>
                <li class="footer">
                  <a href="#">View all tasks</a>
                </li>
              </ul>
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
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="{{ URL::to('/') }}/profile" class="btn btn-default btn-flat">@lang('swift_menu.profile')</a>
                  </div>
                  <div class="pull-right">
                    <a href="{{ URL::to('/') }}/logout" class="btn btn-default btn-flat">@lang('swift_menu.logout')</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
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
          <li>
            <a href="#dashboard">
              <i class="fa fa-dashboard"></i> <span>@lang('swift_menu.dashboard')</span>
            </a>
          </li>
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
            </script>
            <li class="treeview">
              <a href="">
                <i class="fa fa-shopping-cart"></i>
                <span>@lang('swift_menu.sales')</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#sales" id="sales"><i class="fa fa-money"></i> @lang('swift_menu.sales')</a></li>
                <li><a href="orders" id="orders"><i class="fa fa-cubes"></i> @lang('swift_menu.orders')</a></li>
                <li class="treeview">
                  <a href=""><i class="fa fa-group"></i> @lang('swift_menu.clients')</a>
                  <ul class="treeview-menu">
                    <li><a href="#view_client"><i class="fa fa-user"></i> @lang('swift_menu.view_client')</a></li>
                    <li><a href="#client_credit"><i class="fa fa-book"></i> @lang('swift_menu.credit_client')</a></li>
                    <li><a href="#client_debt"><i class="fa fa-money"></i> @lang('swift_menu.debt_client')</a></li>
                    <li><a href="#client_purchases"><i class="fa fa-shopping-cart"></i> @lang('swift_menu.purchases_client')</a></li>
                    <li><a href="#client_discounts"><i class="fa fa-tag"></i> @lang('swift_menu.discounts_client')</a></li>
                  </ul>
                </li>
                <li><a href="#discounts"><i class="fa fa-tag"></i> @lang('swift_menu.discounts')</a></li>
                <li><a href="#sales_analysis"><i class="fa fa-line-chart"></i> @lang('swift_menu.sales_analysis')</a></li>
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
            </script>
            <li class="treeview">
              <a href="">
                <i class="fa fa-cubes"></i>
                <span>@lang('swift_menu.products')</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#products" id="products"><i class="fa fa-cube"></i> @lang('swift_menu.view_products')</a></li>
                <li><a href="#providers"><i class="fa fa-industry"></i> @lang('swift_menu.view_providers')</a></li>
                <li><a href="#categories"><i class="fa fa-list"></i> @lang('swift_menu.view_categories')</a></li>
                <li><a href="#measurement_units"><i class="fa fa-list"></i> @lang('swift_menu.measurement_units')</a></li>
                <li><a href="#purchases"><i class="fa fa-list"></i> @lang('swift_menu.view_purchases')</a></li>
                <li><a href="#local_purchase"><i class="fa fa-truck"></i> @lang('swift_menu.local_purchase')</a></li>
                <li class="treeview">
                  <a href=""><i class="fa fa-ship"></i> @lang('swift_menu.international_purchase')</a>
                  <ul class="treeview-menu">
                    <li><a href="#importation_order"><i class="fa fa-envelope"></i> @lang('swift_menu.importation_order')</a></li>
                    <li><a href="#importation_costs"><i class="fa fa-money"></i> @lang('swift_menu.importation_costs')</a></li>
                    <li><a href="#importation_bill"><i class="fa fa-file-text-o"></i> @lang('swift_menu.importation_bill')</a></li>
                  </ul>
                </li>
                <li><a href="#suggestions"><i class="fa fa-sitemap"></i> @lang('swift_menu.purchase_suggestion')</a></li>
              </ul>
            </li>
          @endif
          @if($modules->warehouses == 1)
            <li class="treeview">
              <a href="">
                <i class="fa fa-building"></i>
                <span>@lang('swift_menu.warehouses')</span>
              </a>
              <ul class="treeview-menu">
              <li><a href="#warehouse"><i class="fa fa-building"></i> @lang('swift_menu.view_warehouse')</a></li>
              <li><a href="#location"><i class="fa fa-table"></i> @lang('swift_menu.view_location')</a></li>
              <li><a href="#receive_products"><i class="fa fa-plus"></i> @lang('swift_menu.receive_products')</a></li>
              <li><a href="#dispatch_products"><i class="fa fa-minus"></i> @lang('swift_menu.dispatch_products')</a></li>
                <li class="treeview">
                  <a href=""><i class="fa fa-list"></i> @lang('swift_menu.stock')</a>
                  <ul class="treeview-menu">
                    <li><a href="#product_stock"><i class="fa fa-cube"></i> @lang('swift_menu.product_stock')</a></li>
                    <li><a href="#stocktake"><i class="fa fa-list"></i> @lang('swift_menu.stock_take')</a></li>
                    <li><a href="#stocktake_result"><i class="fa fa-file-text-o"></i> @lang('swift_menu.stock_take_result')</a></li>
                  </ul>
                </li>
                <li><a href="#stock_movement"><i class="fa fa-arrows-h"></i> @lang('swift_menu.stock_movement')</a></li>
              </ul>
            </li>
          @endif
          @if($modules->staff == 1)
            <li class="treeview">
              <a href="">
                <i class="fa fa-users"></i>
                <span>@lang('swift_menu.staff')</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#staff"><i class="fa fa-user"></i> @lang('swift_menu.view_staff')</a></li>
                <li><a href="#staff_config"><i class="fa fa-cogs"></i> @lang('swift_menu.staff_config')</a></li>
                <li><a href="#staff_analysis"><i class="fa fa-pie-chart"></i> @lang('swift_menu.staff_analysis')</a></li>
                <li><a href="#staff_payments"><i class="fa fa-money"></i> @lang('swift_menu.staff_payments')</a></li>
                <li><a href="#staff_assistance"><i class="fa fa-calendar-check-o"></i> @lang('swift_menu.staff_assistance')</a></li>
              </ul>
            </li>
          @endif
          @if($modules->vehicles == 1)
            <li class="treeview">
              <a href="">
                <i class="fa fa-truck"></i>
                <span>@lang('swift_menu.vehicles')</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#view_vehicles"><i class="fa fa-car"></i> @lang('swift_menu.view_vehicles')</a></li>
                <li><a href="#view_trips"><i class="fa fa-map"></i> @lang('swift_menu.view_trips')</a></li>
                <li><a href="#routes"><i class="fa fa-map-signs"></i> @lang('swift_menu.routes')</a></li>
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
          <li class="treeview">
            <a href="">
              <i class="fa fa-cogs"></i>
              <span>@lang('swift_menu.general_config')</span>
            </a>
            <ul class="treeview-menu">
              <li><a href="#branches"><i class="fa fa-building"></i> @lang('swift_menu.branches')</a></li>
              <li><a href="#groups"><i class="fa fa-users"></i> @lang('swift_menu.groups')</a></li>
              <li><a href="#configuration"><i class="fa fa-cogs"></i> @lang('swift_menu.config')</a></li>
              <li><a href="#database"><i class="fa fa-database"></i> @lang('swift_menu.database')</a></li>
            </ul>
          </li>
        </ul>
      </section>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="main-content">
      @include('system.pages.journal')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; {{ date('Y') }} <a href="http://alonica.net">Alonica S.A</a>.</strong> All rights
      reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Create the tabs -->
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
          <h3 class="control-sidebar-heading">Recent Activity</h3>
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                  <p>Will be 23 on April 24th</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-user bg-yellow"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                  <p>New phone +1(800)555-1234</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                  <p>nora@example.com</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-file-code-o bg-green"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                  <p>Execution time 5 seconds</p>
                </div>
              </a>
            </li>
          </ul>
          <!-- /.control-sidebar-menu -->

          <h3 class="control-sidebar-heading">Tasks Progress</h3>
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Custom Template Design
                  <span class="label label-danger pull-right">70%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Update Resume
                  <span class="label label-success pull-right">95%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Laravel Integration
                  <span class="label label-warning pull-right">50%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Back End Framework
                  <span class="label label-primary pull-right">68%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                </div>
              </a>
            </li>
          </ul>
          <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
          <form method="post">
            <h3 class="control-sidebar-heading">General Settings</h3>

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Report panel usage
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Some information about this general settings option
              </p>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Allow mail redirect
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Other sets of options are available
              </p>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Expose author name in posts
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Allow the user to show his name in blog posts
              </p>
            </div>
            <!-- /.form-group -->

            <h3 class="control-sidebar-heading">Chat Settings</h3>

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Show me as online
                <input type="checkbox" class="pull-right" checked>
              </label>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Turn off notifications
                <input type="checkbox" class="pull-right">
              </label>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Delete chat history
                <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
              </label>
            </div>
            <!-- /.form-group -->
          </form>
        </div>
        <!-- /.tab-pane -->
      </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
  </body>
</html>
