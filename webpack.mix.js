let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/*mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');*/
mix.styles([
    'public/css/bootstrap/bootstrap.min.css',
    'public/css/bootstrap/bootstrap-theme.min.css',
    'public/css/font-awesome/font-awesome.min.css',
    'public/css/ionicons/ionicons.min.css',
    'public/css/font-awesome/font-awesome.min.css',
    'public/css/theme/theme.min.css',
    'public/css/theme/skins/_all-skins.min.css',
    'public/css/libs/admin.css',
    'public/css/bootstrap-datepicker/bootstrap-datepicker.min.css',
    'public/css/bootstrap-daterangepicker/daterangepicker.css',
    'public/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
    'public/css/jvectormap/jquery-jvectormap-1.2.2.css',
    'public/css/morris/morris.css',
    'public/css/fonts/fonts.css',
  ], 'public/css/base.css').
  scripts([
    'public/js/jquery/jquery.min.js',
    'public/js/jquery/ui/jquery-ui.min.js',
    'public/js/bootstrap/bootstrap.min.js',
    'public/js/raphael/raphael.min.js',
    'public/js/morris/morris.min.js',
    'public/js/jquery/sparkline/jquery.sparkline.min.js',
    'public/js/jvectormap/jquery-jvectormap-1.2.2.min.js',
    'public/js/jvectormap/jquery-jvectormap-world-mill-en.js',
    'public/js/jquery/knob/jquery.knob.min.js',
    'public/js/moment/moment.min.js',
    'public/js/bootstrap-datepicker/bootstrap-datepicker.js',
    'public/js/bootstrap-daterangepicker/daterangepicker.js',
    'public/js/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
    'public/js/jquery/slimscroll/jquery.slimscroll.min.js',
    'public/js/fastclick/fastclick.js',
    'public/js/libs/admin.min.js',
    'public/js/libs/demo.js',
    'public/js/libs/dashboard.js',
  ], 'public/js/all.js').
  scripts([
    'public/js/jquery/jquery.min.js',
    'public/js/jquery/ui/jquery-ui.min.js',
    'public/js/bootstrap/bootstrap.min.js',
    'public/js/moment/moment.min.js',
    'public/js/bootstrap-datepicker/bootstrap-datepicker.js',
    'public/js/bootstrap-daterangepicker/daterangepicker.js',
    'public/js/jquery/slimscroll/jquery.slimscroll.min.js',
    'public/js/fastclick/fastclick.js'
  ], 'public/js/base.js');;
