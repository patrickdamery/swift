<!DOCTYPE html>
  <html>
  <head>
    <link rel="shortcut icon" href="{{ URL::to('/') }}/images/swift.ico" type="image/x-icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@lang('install.title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/swift/install.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      <aside class="main-sidebar hide">
        <section class="sidebar" style="height: auto;">
          <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">@lang('install.steps')</li>
            <li class="treeview a_controller">
              <a href="#">
                <span class="ruc">@lang('install.sidebar-ruc')</span>
              </a>
            </li>
            <li class="active treeview menu-open">
              <a href="#">
                <span>@lang('install.sidebar-business')</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu a_controller">
                <li class="branches"><a href="#">@lang('install.sidebar-branches')</a></li>
                <li class="staff"><a href="#">@lang('install.sidebar-staff')</a></li>
                <li class="clients"><a href="#">@lang('install.sidebar-clients')</a></li>
                <li class="warehouses"><a href="#">@lang('install.sidebar-warehouses')</a></li>
                <li class="products"><a href="#">@lang('install.sidebar-products')</a></li>
                <li class="accounting"><a href="#">@lang('install.sidebar-accounting')</a></li>
                <li class="vehicles"><a href="#">@lang('install.sidebar-vehicles')</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <span>@lang('install.sidebar-launch')</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
        <div>
          <div class="content-wrapper">
            <div id="alerts-area" style="position:fixed;width:80%;z-index:9999"></div>
          </div>
        </div>
        <div class="content" id="landing">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
              <img src="{{ URL::to('/') }}/images/bg-swift-logo.png" class="img-responsive center-block" alt="Swift Logo">
            </div>
          </div>
          <div class="row">
            <button type="button" class="btn btn-lg btn-info center-block" id="configure">
              @lang('install.configure-button')
            </button>
          </div>
        </div>
        <div class="hideables hide" id="business" style="height:100%;width:auto;">
          <div class="content-wrapper">
            <section class="content-header">
                <h1> @lang('install.sidebar-business') </h1>
            </section>
            <section class="content">
              <div class="row">
                <div class="col-xs-12 top-space">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                  <div class="form-group form-inline">
                    <label>@lang('install.ruc')</label>
                    <input type="text" class="form-control" id="ruc">
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="btn-group">
                    <button type="button" class="btn btn-default" id="check-ruc">
                      @lang('install.check-ruc')
                    </button>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="box box-default box-solid" id="module-selection" style="display:none;">
                  <div class="box-header with-border">
                    <h3 class="box-title">@lang('install.modules')</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body">
                    The body of the box
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
    <!-- JS Files -->
    <script src="{{ URL::to('/') }}/js/base.js"></script>
    <script src="{{ URL::to('/') }}/js/swift/event_tracker.js"></script>
    <script src="{{ URL::to('/') }}/js/swift/utils.js"></script>
    <script src="{{ URL::to('/') }}/js/swift/language.js"></script>
    <script src="{{ URL::to('/') }}/js/swift/install.js"></script>
  </body>
</html>
