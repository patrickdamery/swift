@php
  // Get data we need to display.
  use App\Configuration;
  use App\Branch;
  use App\User;
  use App\UserAccess;
  use App\Worker;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
  $worker = Worker::where('code', Auth::user()->worker_code)->first();
  $access = json_decode(UserAccess::where('code', Auth::user()->user_access_code)->first()->access);
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
    <script src="{{ URL::to('/') }}/js/jquery/jquery.min.js"></script>
    <script>
      $(window).on('load', function() {
        $('.overlay').hide();
      });
    </script>
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
  <div class="overlay">
    <div class="lds-css ng-scope">
      <div class="lds-square">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>
      <h4 style="text-align:center">@lang('login.loading')</h4>
    </div>
  </div>
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
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">@lang('swift_menu.main_menu')</li>
          @if($modules->sales_stock == 1 && ($access->sales->has || $access->products->has))
            @include('system.components.sale_product.menu_sales')
          @endif
          @if($modules->warehouses == 1 && $access->warehouses->has)
            @include('system.components.warehouses.menu_warehouses')
          @endif
          @if($modules->staff == 1 && $access->staff->has)
            @include('system.components.staff.menu_staff')
          @endif
          @if($modules->vehicles == 1 && $access->vehicles->has)
            @include('system.components.vehicles.menu_vehicles')
          @endif
          @if($modules->accounting == 1 && $access->accounting->has)
            @include('system.components.accounting.menu_accounting')
          @endif
          @if($access->configuration->has)
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
          @endif
        </ul>
      </section>
    </aside>
    <div class="content-wrapper" id="main-content">
      @include('system.modules.staff.staff')
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
