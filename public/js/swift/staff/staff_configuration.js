/*
  Staff Configuration Object.
*/
function StaffConfiguration() {
  staff_code = '';
}

StaffConfiguration.prototype = {
  constructor: StaffConfiguration,
  load_config: function(e) {

  },
}

var staff_configuration_js = new StaffConfiguration();


// Define Menu Tab Events.
swift_event_tracker.register_swift_event('#staff-configuration-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#staff-configuration-tab', function(e) {
  swift_event_tracker.fire_event(e, '#staff-configuration-tab');
});

swift_event_tracker.register_swift_event('#staff-configuration-view-access-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#staff-configuration-view-access-tab', function(e) {
  swift_event_tracker.fire_event(e, '#staff-configuration-view-access-tab');
});
