/*
  Swift Event Tracker. Fires functions for specified events. Checks if
  a plugin needs to override an event.
*/
function Event_Tracker() {
  swift_events = {};
  plugin_events = {};
}

Event_Tracker.prototype={
  constructor: Event_Tracker,
  get_swift_events: function() {
    return swift_events;
  },
  get_plugin_events: function() {
    return plugin_events;
  },
  register_swift_event: function(c, e, o = window.self, f) {
    swift_events[c] = {
      c: c,
      e: e,
      o: o,
      f: f
    };
  },
  register_plugin_event: function(c, e, o = window.self, f, b = true) {
    plugin_events[c] = {
      c: c,
      e: e,
      o: o,
      f: f,
      b: b
    };
  },
  fire_event: function(e, c) {
    var block = false;
    // First check if we have a plugin override.
    $.each(plugin_events, function(k, d){
      if(d.c == c && d.e == e.type) {
        block = d.b;
        d.o[d.f](e);
      }
    });

    // If there was none then check if we have a native swift event.
    if(!block) {
      $.each(swift_events, function(k, d) {
        if(d.c == c && d.e == e.type) {
          d.o[d.f](e);
        }
      });
    }
  }
}

var swift_event_tracker = new Event_Tracker();
