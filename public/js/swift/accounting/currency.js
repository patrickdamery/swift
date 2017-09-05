function Currency() {}

Currency.prototype = {
  constructor: Currency,
  create_currency: function(e) {
    // Make target busy and get relevant data.
    swift_utils.busy(e.target);
    var currency_data = {
        'code': $('#create-currency-code').val(),
        'description': $('#create-currency-description').val(),
        'exchange': $('#create-currency-exchange').val(),
        'buy_rate': $('#create-currency-buy-rate').val(),
      };

    // Check if data is correct and create it if it is.
    if(this.verify_currency_data(currency_data)) {
      var currency_ref = this;
      var request = $.post('/swift/accounting/create_currency', { currency_data: currency_data, _token: swift_utils.swift_token() });
      request.done(function(data) {
        swift_utils.free(e.target);
        if(data.state != 'Success') {
          swift_utils.display_error(data.error);
          return;
        }
        // Clear modal and hide it.
        $('#create-currency-code').val('');
        $('#create-currency-description').val('');
        $('#create-currency-exchange').val('');
        $('#create-currency-buy-rate').val('');
        $('#create-currency').modal('hide');

        currency_ref.load_currency_table();
        swift_utils.display_success(data.message);
      });
      request.fail(function(ev) {
        swift_utils.free(e.target);
        swift_utils.ajax_fail(ev);
      });
    } else {
      swift_utils.free(e.target);
    }
  },
  verify_currency_data: function(data) {
    if(data.code == '') {
      swift_utils.display_error(swift_language.get_sentence('create_currency_blank_code'));
      return false;
    }
    if(data.description == '') {
      swift_utils.display_error(swift_language.get_sentence('create_currency_blank_description'));
      return false;
    }
    if(data.exchange == '' || !$.isNumeric(data.exchange)) {
      swift_utils.display_error(swift_language.get_sentence('create_currency_exchange_error'));
      return false;
    }
    if(data.buy_rate == '' || !$.isNumeric(data.buy_rate)) {
      swift_utils.display_error(swift_language.get_sentence('create_currency_buy_rate_error'));
      return false;
    }
    return true;
  },
  load_currency_table: function() {
    var request = $.post('/swift/accounting/currency_table', { _token: swift_utils.swift_token() });
    request.done(function(data) {
      $('#currency-table').empty();
      $('#currency-table').append(data);
    });
    request.fail(function(ev) {
      swift_utils.ajax_fail(ev);
    });
  },
  save_local_currency: function(e) {
    swift_utils.busy(e.target);
    var local_currency = $('#currency-main').val();
    var currency_ref = this;
    var request = $.post('/swift/accounting/save_local_currency', { local_currency: local_currency, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      currency_ref.load_currency_table();
      swift_utils.display_success(data.message);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });

  },
  get_exchange_variation: function(e) {

  },
}

var currency_js = new Currency();

// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '#create-currency-create',
  'click',
  currency_js,
  'create_currency');

$(document).on('click', '#create-currency-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-currency-create');
});

swift_event_tracker.register_swift_event(
  '#currency-save-main',
  'click',
  currency_js,
  'save_local_currency');

$(document).on('click', '#currency-save-main', function(e) {
  swift_event_tracker.fire_event(e, '#currency-save-main');
});



// Define Menu Tab Events.
swift_event_tracker.register_swift_event('#currency-view-currency-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#currency-view-currency-tab', function(e) {
  swift_event_tracker.fire_event(e, '#currency-view-currency-tab');
});

swift_event_tracker.register_swift_event('#currency-view-time-variation-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#currency-view-time-variation-tab', function(e) {
  swift_event_tracker.fire_event(e, '#currency-view-time-variation-tab');
});
