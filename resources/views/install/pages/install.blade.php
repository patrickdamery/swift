<?php
  use App\Configuration;
  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<!DOCTYPE html>
  <html>
  <head>
    <link rel="shortcut icon" href="{{ URL::to('/') }}/images/swift.ico" type="image/x-icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ Session::token() }}">
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
        <div>
          <div class="wrapper">
            <div id="alerts-area" style="position:fixed;width:100%;z-index:9999"></div>
          </div>
        </div>
        <div class="content @if($config->auth_key != "") hide @endif" id="landing">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
              <img src="{{ URL::to('/') }}/images/bg-swift-logo.png" class="img-responsive center-block" alt="Swift Logo">
            </div>
          </div>
          <div class="row">
            <textarea cols="30" id="token" class="center-block" placeholder="@lang('install.token')"></textarea>
            <div class="row" style="padding-top:15px;">
              <button type="button" class="btn btn-lg btn-info center-block" id="token-button">
                @lang('install.token-button')
              </button>
            </div>
          </div>
        </div>
        <div class="hideables @if($config->auth_key == "") hide @endif" id="business" style="height:100%;width:auto;">
          <div class="wrapper" style="background:whitesmoke">
            <section class="content-header">
                <h1> @lang('install.sidebar-business') </h1>
            </section>
            <section class="content">
              <div class="row">
                <div class="col-xs-12 top-space">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                  <div class="form-group form-inline">
                    <label>@lang('install.business_name')</label>
                    <input type="text" class="form-control" id="business-name"
                      value="{{ $config->name }}">
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="form-group form-inline">
                    <label>@lang('install.business_ruc')</label>
                    <input type="text" class="form-control" id="business-ruc"
                      value="{{ $config->ruc }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                  <div class="form-group form-inline">
                    <label>@lang('install.dgi_auth')</label>
                    <input type="text" class="form-control" id="dgi-auth"
                      value="{{ $config->dgi_auth }}">
                  </div>
                </div>
              </div>
              <div class="row center-block" style="padding-top: 10px; border-top: 1px solid black">
                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>@lang('install.branches')</label>
                    <input type="file" class="form-control" id="branches">
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <div class="button-group">
                    <button type="button" class="btn btn-lg btn-default center-block"
                      id="branches-template">
                      @lang('install.branches_template')
                    </button>
                  </div>
                </div>
              </div>
              @if($modules->staff)
                <div class="staff-module">
                  <div class="row center-block" style="padding-top: 10px; border-top: 1px solid black">
                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <label>@lang('install.staff')</label>
                        <input type="file" class="form-control" id="staff">
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="button-group">
                        <button type="button" class="btn btn-lg btn-default center-block" id="staff-template">
                          @lang('install.staff_template')
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              @if($modules->sales_stock)
                <div class="sales-stock-module">
                  <div class="row center-block" style="padding-top: 10px; border-top: 1px solid black">
                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <label>@lang('install.clients')</label>
                        <input type="file" class="form-control" id="clients">
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="button-group">
                        <button type="button" class="btn btn-lg btn-default center-block" id="clients-template">
                          @lang('install.clients_template')
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              @if($modules->warehouses)
                <div class="warehouses-module">
                  <div class="row center-block" style="padding-top: 10px; border-top: 1px solid black">
                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <label>@lang('install.warehouses')</label>
                        <input type="file" class="form-control" id="warehouses">
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="button-group">
                        <button type="button" class="btn btn-lg btn-default center-block" id="warehouses-template">
                          @lang('install.warehouses_template')
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="row center-block" style="margin-top: 10px;">
                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <label>@lang('install.warehouse_locations')</label>
                        <input type="file" class="form-control" id="warehouse-locations">
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="button-group">
                        <button type="button" class="btn btn-lg btn-default center-block" id="warehouse-locations-template">
                          @lang('install.warehouse_locations_template')
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              @if($modules->sales_stock)
                <div class="sales-stock-module">
                  <div class="row center-block" style="padding-top: 10px; border-top: 1px solid black">
                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <label>@lang('install.providers')</label>
                        <input type="file" class="form-control" id="providers">
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="button-group">
                        <button type="button" class="btn btn-lg btn-default center-block" id="providers-template">
                          @lang('install.providers_template')
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="row center-block" style="margin-top: 20px;">
                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <label>@lang('install.categories')</label>
                        <input type="file" class="form-control" id="categories">
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="button-group">
                        <button type="button" class="btn btn-lg btn-default center-block" id="categories-template">
                          @lang('install.categories_template')
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="row center-block" style="margin-top: 20px;">
                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <label>@lang('install.measurement_units')</label>
                        <input type="file" class="form-control" id="measurement-units">
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="button-group">
                        <button type="button" class="btn btn-lg btn-default center-block" id="measurement-units-template">
                          @lang('install.measurement_units_template')
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="row center-block" style="margin-top: 20px;">
                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <label>@lang('install.products')</label>
                        <input type="file" class="form-control" id="products">
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="button-group">
                        <button type="button" class="btn btn-lg btn-default center-block" id="products-template">
                          @lang('install.products_template')
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              @if($modules->accounting)
                <div class="accounting-module">
                  <div class="row center-block" style="padding-top: 10px; border-top: 1px solid black">
                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <label>@lang('install.accounting')</label>
                        <input type="file" class="form-control" id="accounting">
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="button-group">
                        <button type="button" class="btn btn-lg btn-default center-block" id="accounting-template">
                          @lang('install.accounting_template')
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              @if($modules->vehicles)
                <div class="vehicles-module">
                  <div class="row center-block" style="padding-top: 10px; border-top: 1px solid black">
                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <label>@lang('install.vehicles')</label>
                        <input type="file" class="form-control" id="vehicles">
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                      <div class="button-group">
                        <button type="button" class="btn btn-lg btn-default center-block" id="vehicles-template">
                          @lang('install.vehicles_template')
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              <div class="row" style="margin-top:20px;">
                <button type="button" class="btn btn-lg btn-default center-block" id="launch-swift">
                  @lang('install.swift_launch')
                </button>
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
