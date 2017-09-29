function Journal() {
  edit_code = '';
  edit_value = 0;
  edit_type = '';
  edit_desrciption = '';
  currency_offset = 1;
  variation_offset = 1;
}

Journal.prototype = {
  constructor: Journal,
  search_entries: function(e) {

  }
}

var journal_js = new Journal();

// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '#create-currency-create',
  'click',
  journal_js,
  'create_currency');

$(document).on('click', '#create-currency-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-currency-create');
});

swift_event_tracker.register_swift_event('#journal-view-entries-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-view-entries-tab', function(e) {
  swift_event_tracker.fire_event(e, '#journal-view-entries-tab');
});
swift_event_tracker.register_swift_event('#journal-reports-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-reports-tab', function(e) {
  swift_event_tracker.fire_event(e, '#journal-reports-tab');
});
swift_event_tracker.register_swift_event('#journal-graphs-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-graphs-tab', function(e) {
  swift_event_tracker.fire_event(e, '#journal-graphs-tab');
});
swift_event_tracker.register_swift_event('#journal-configuration-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-configuration-tab', function(e) {
  swift_event_tracker.fire_event(e, '#journal-configuration-tab');
});
