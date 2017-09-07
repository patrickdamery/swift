function Currency() {
  edit_code = '';
  edit_value = 0;
  edit_type = '';
  edit_desrciption = '';
  currency_offset = 1;
  variation_offset = 1;
}

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
    currency_offset = 1;
    var request = $.post('/swift/accounting/currency_table', { offset: currency_offset, _token: swift_utils.swift_token() });
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
  variation_search: function(e) {
    swift_utils.busy(e.target);
    offset = 1;
    var variation_search = {
      'date_range': $('#currency-variation-date-range').val(),
      'code': $('#currency-variation-main').val(),
      'offset': offset,
    };
    var request = $.post('/swift/accounting/variation_search', { variation_search: variation_search, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      $('#currency-variation-table').empty();
      $('#currency-variation-table').append(data);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  exchange_change: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');

    edit_code = row.attr('id').split('-')[1];
    edit_value = cell.text();
    edit_type = 'exchange';

    cell.replaceWith('<td><input type="text" class="change-rate" value="'+edit_value+'"></td>')
    $('.change-rate').focus();
  },
  buy_change: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');
    edit_code = row.attr('id').split('-')[1];
    edit_value = cell.text();
    edit_type = 'buy';

    cell.replaceWith('<td><input type="text" class="change-rate" value="'+edit_value+'"></td>')
    $('.change-rate').focus();
  },
  change_rate: function(e) {
    // Get new rate.
    var rate = $(e.target).val();
    if(rate == edit_value || !$.isNumeric(rate)) {
      if(edit_type == 'exchange') {
        $(e.target).parent('td')
          .replaceWith('<td class="exchange-rate">'+edit_value+'</td>');
      } else {
        $(e.target).parent('td')
          .replaceWith('<td class="buy-rate">'+edit_value+'</td>');
      }
      return;
    }
    // Check if we are editing variation or current rate.
    var change_type = 'variation';
    if($(e.target).closest('tr').attr('id').split('-')[0] == 'currency') {
      change_type = 'currency';
    }

    var change_data = {
      'edit_value': rate,
      'edit_type': edit_type,
      'edit_code': edit_code,
      'change_type': change_type
    };
    var request = $.post('/swift/accounting/change_rate', { change_data: change_data, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      if(edit_type == 'exchange') {
        $(e.target).parent('td')
          .replaceWith('<td class="exchange-rate">'+rate+'</td>');
      } else {
        $(e.target).parent('td')
          .replaceWith('<td class="buy-rate">'+rate+'</td>');
      }
      swift_utils.display_success(data.message);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  description_change: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');
    edit_code = row.attr('id').split('-')[1];
    edit_description = cell.text();

    cell.replaceWith('<td><input type="text" class="change-currency-description" value="'+edit_description+'"></td>')
    $('.change-currency-description').focus();
  },
  currency_description_change: function(e) {
    // Get new description.
    var description = $(e.target).val();
    if(description == edit_description) {
      $(e.target).parent('td')
        .replaceWith('<td class="description-rate">'+description+'</td>');
      return;
    }

    var description_data = {
      'edit_description': description,
      'edit_code': edit_code,
    };
    var request = $.post('/swift/accounting/change_currency_description', { description_data: description_data, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $(e.target).parent('td')
        .replaceWith('<td class="description-rate">'+description+'</td>');
      swift_utils.display_success(data.message);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  variation_paginate: function(e) {
    variation_offset = $(e.target).attr('id').split('-')[2];
    swift_utils.busy(e.target);

    var variation_search = {
      'date_range': $('#currency-variation-date-range').val(),
      'code': $('#currency-variation-main').val(),
      'offset': variation_offset,
    };
    var request = $.post('/swift/accounting/variation_search', { variation_search: variation_search, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      $('#currency-variation-table').empty();
      $('#currency-variation-table').append(data);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  currency_paginate: function(e) {
    currency_offset = $(e.target).attr('id').split('-')[2];
    swift_utils.busy(e.target);

    var request = $.post('/swift/accounting/currency_table', { offset: currency_offset, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      $('#currency-table').empty();
      $('#currency-table').append(data);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  }
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

swift_event_tracker.register_swift_event(
  '#currency-variation-search',
  'click',
  currency_js,
  'variation_search');

$(document).on('click', '#currency-variation-search', function(e) {
  swift_event_tracker.fire_event(e, '#currency-variation-search');
});

swift_event_tracker.register_swift_event(
  '.exchange-rate',
  'click',
  currency_js,
  'exchange_change');

$(document).on('click', '.exchange-rate', function(e) {
  swift_event_tracker.fire_event(e, '.exchange-rate');
});

swift_event_tracker.register_swift_event(
  '.buy-rate',
  'click',
  currency_js,
  'buy_change');

$(document).on('click', '.buy-rate', function(e) {
  swift_event_tracker.fire_event(e, '.buy-rate');
});

swift_event_tracker.register_swift_event(
  '.description-rate',
  'click',
  currency_js,
  'description_change');

$(document).on('click', '.description-rate', function(e) {
  swift_event_tracker.fire_event(e, '.description-rate');
});

swift_event_tracker.register_swift_event(
  '.change-rate',
  'focusout',
  currency_js,
  'change_rate');

$(document).on('focusout', '.change-rate', function(e) {
  swift_event_tracker.fire_event(e, '.change-rate');
});

swift_event_tracker.register_swift_event(
  '.change-currency-description',
  'focusout',
  currency_js,
  'currency_description_change');

$(document).on('focusout', '.change-currency-description', function(e) {
  swift_event_tracker.fire_event(e, '.change-currency-description');
});

swift_event_tracker.register_swift_event(
  '.variation-pagination > li > a',
  'click',
  currency_js,
  'variation_paginate');

$(document).on('click', '.variation-pagination > li > a', function(e) {
  e.preventDefault();
  swift_event_tracker.fire_event(e, '.variation-pagination > li > a');
});

swift_event_tracker.register_swift_event(
  '.currency-pagination > li > a',
  'click',
  currency_js,
  'currency_paginate');

$(document).on('click', '.currency-pagination > li > a', function(e) {
  e.preventDefault();
  swift_event_tracker.fire_event(e, '.currency-pagination > li > a');
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
