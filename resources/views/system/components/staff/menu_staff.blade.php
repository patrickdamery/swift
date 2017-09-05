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
