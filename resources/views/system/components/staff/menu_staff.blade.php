@php
  use App\User;
  use App\UserAccess;

  $access = json_decode(UserAccess::where('code', Auth::user()->user_access_code)->first()->access);
@endphp
<script>
  var option = []
  @if($access->staff->view_staff->has)
    option = {
      'staff': '/swift/system/staff'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#staff', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#staff', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#staff');
    });
  @endif
  @if($access->staff->staff_config->has)
    option = {
      'staff_configuration': '/swift/system/staff_configuration'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#staff_configuration', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#staff_configuration', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#staff_configuration');
    });
  @endif
  @if($access->staff->staff_analytics->has)
    option = {
      'staff_analytics': '/swift/system/staff_analytics'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#staff_analytics', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#staff_analytics', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#staff_analytics');
    });
  @endif
  @if($access->staff->staff_payments->has)
    option = {
      'staff_payments': '/swift/system/staff_payments'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#staff_payments', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#staff_payments', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#staff_payments');
    });
  @endif
  @if($access->staff->staff_assistance->has)
    option = {
      'staff_assistance': '/swift/system/staff_assistance'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#staff_assistance', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#staff_assistance', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#staff_assistance');
    });
  @endif
</script>
<li class="treeview">
  <a href="">
    <i class="fa fa-users"></i>
    <span>@lang('swift_menu.staff')</span>
  </a>
  <ul class="treeview-menu">
    @if($access->staff->view_staff->has)
      <li><a href="#staff" id="staff"><i class="fa fa-user"></i> @lang('swift_menu.view_staff')</a></li>
    @endif
    @if($access->staff->staff_config->has)
      <li><a href="#staff_config" id="staff_configuration"><i class="fa fa-cogs"></i> @lang('swift_menu.staff_config')</a></li>
    @endif
    @if($access->staff->staff_analytics->has)
      <li><a href="#staff_analytics" id="staff_analytics"><i class="fa fa-pie-chart"></i> @lang('swift_menu.staff_analysis')</a></li>
    @endif
    @if($access->staff->staff_payments->has)
      <li><a href="#staff_payments" id="staff_payments"><i class="fa fa-money"></i> @lang('swift_menu.staff_payments')</a></li>
    @endif
    @if($access->staff->staff_assistance->has)
      <li><a href="#staff_assistance" id="staff_assistance"><i class="fa fa-calendar-check-o"></i> @lang('swift_menu.staff_assistance')</a></li>
    @endif
  </ul>
</li>
