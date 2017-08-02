<!DOCTYPE html>
  <html>
  <head>
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
      <section class="content hide" id="landing">
        <div class="row">
          <div class="col-lg-12 col-xs-12">
            <img src="{{ URL::to('/') }}/images/bg-swift-logo.png" class="img-responsive center-block" alt="Swift Logo">
          </div>
        </div>
        <div class="row">
          <button type="button" class="btn btn-lg btn-info center-block" id="configure">
            @lang('install.configure-button')
          </button>
        </div>
      </section>
      <section class="content" id="business">
        <div class="row">
          <div class="col-lg-2">
          </div>
          <div class="col-lg-6 col-xs-12">
            <div class="form-group form-inline">
              <label>@lang('install.ruc')</label>
              <input type="text" class="form-control">
            </div>
          </div>
          <div class="col-lg-4 col-xs-12">
            <div class="btn-group">
              <button type="button" class="btn btn-default">
                @lang('install.check-ruc')
              </button>
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- JS Files -->
    <script src="js/base.js"></script>
    <script src="js/swift/install.js"></script>
  </body>
</html>
