@php
  use App\User;
  use App\UserAccess;

  $access = json_decode(UserAccess::where('code', Auth::user()->user_access_code)->first()->access);
@endphp
<script>
  var option = {};
  @if($access->vehicles->view_vehicle->has)
    option = {
      'vehicles': '/swift/system/vehicles'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#vehicles', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#vehicles', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#vehicles');
    });
  @endif
  @if($access->vehicles->view_journeys->has)
    option = {
      'journeys': '/swift/system/journeys'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#journeys', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#journeys', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#journeys');
    });
  @endif
  @if($access->vehicles->view_routes->has)
    option = {
      'routes': '/swift/system/routes'
    };
    swift_menu.register_menu_option(option);
    swift_event_tracker.register_swift_event('#routes', 'click', swift_menu, 'select_menu_option');
    $(document).on('click', '#routes', function(e) {
      e.preventDefault();
      swift_event_tracker.fire_event(e, '#routes');
    });
  @endif
</script>
<li class="treeview">
  <a href="">
    <i class="fa fa-truck"></i>
    <span>@lang('swift_menu.vehicles')</span>
  </a>
  <ul class="treeview-menu">
    @if($access->vehicles->view_vehicle->has)
      <li><a href="#view_vehicles" id="vehicles"><i class="fa fa-car"></i> @lang('swift_menu.view_vehicles')</a></li>
    @endif
    @if($access->vehicles->view_journeys->has)
      <li><a href="#view_trips" id="journeys"><i class="fa fa-map"></i> @lang('swift_menu.view_trips')</a></li>
    @endif
    @if($access->vehicles->view_routes->has)
      <li><a href="#routes" id="routes"><i class="fa fa-map-signs"></i> @lang('swift_menu.routes')</a></li>
    @endif
  </ul>
</li>
