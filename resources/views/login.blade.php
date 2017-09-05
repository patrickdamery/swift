<?php
  $config = \App\Configuration::find(1);
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="{{ URL::to('/') }}/images/swift.ico" type="image/x-icon">
  <title>Swift</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ URL::to('/') }}/css/base.css">

  <!-- JS Files -->
  <script src="{{ URL::to('/') }}/js/all.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page" style="background:url(http://192.168.0.16/eirene/img/body-bg.png)">
<div class="login-box">
  <div class="login-logo">
    <b>{{ $config->name }}</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="padding:25px;">
    <form action="login" method="post">
      <input type="hidden" name="_token" value="{{ Session::token() }}" />
      <div class="form-group has-feedback">
        <input type="text" name='username' class="form-control" placeholder="@lang('login.username')">
        <span class="fa fa-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="@lang('login.password')">
        <span class="fa fa-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <button id="qwerty" type="submit" class="btn btn-primary btn-block btn-flat">@lang('login.signin')</button>
        </div>
        <div class="col-xs-6">
          <a href="forgot">@lang('login.forgot')</a>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
