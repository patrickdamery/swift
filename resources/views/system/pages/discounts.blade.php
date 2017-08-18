<?php
  // Get data we need to display.
  use App\Configuration;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
 ?>
<script>
  swift_menu.new_submenu();
  swift_menu.get_language().add_sentence('discounts-view-discounts-tab', {
                                        'en': 'View Discounts',
                                        'es': 'Ver Descuentos',
                                      });

swift_event_tracker.register_swift_event('#discounts-view-discounts-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#discounts-view-discounts-tab', function(e) {
  swift_event_tracker.fire_event(e, '#discounts-view-discounts-tab');
});
</script>
<section class="content-header">
  <h1>
    @lang('discounts.title')
    <small class="crumb">@lang('discounts.view_discounts')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-tag"></i> @lang('discounts.title')</li>
    <li class="active crumb">@lang('discounts.view_discounts')</li>
  </ol>
</section>
<section class="content">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#discounts-view-discounts" id="discounts-view-discounts-tab" data-toggle="tab" aria-expanded="true">@lang('discounts.view_discounts')</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="discounts-view-discounts">
        <div class="row form-inline">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
              <label for="discounts-view-code" class="control-label">@lang('discounts.discount')</label>
              <input type="text" class="form-control" id="discounts-view-code">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
              <button type="button" class="btn btn-success" id="discounts-view-create">
                <i class="fa fa-plus"></i> @lang('discounts.create')
              </button>
            </div>
          </div>
        </div>
        <div class="row form-inline">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:15px;">
            <div class="box">
              <div class="box-body table-responsive no-padding swift-table">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>@lang('discounts.code')</th>
                      <th>@lang('discounts.name')</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
</section>
