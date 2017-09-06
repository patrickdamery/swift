/*
  Accounts Object.
*/
function Account() {
  accounts_code = '';
  accounts_type = 'all';
  ledger_code = '';
  ledger_date_range = '';
  accounts_offset = 1;
  ledger_offset = 1;
  edit_type = '';
  edit_code = '';
  edit_value = '';
}

Account.prototype = {
  constructor: Account,
  verify_account_data: function(a) {
    if(a.code == '') {
      swift_utils.display_error(swift_language.get_sentence('create_account_blank_code'));
      return false;
    }
    if(a.name == '') {
      swift_utils.display_error(swift_language.get_sentence('create_account_blank_name'));
      return false;
    }
    if(a.amount == '' || !$.isNumeric(a.amount)) {
      swift_utils.display_error(swift_language.get_sentence('create_account_amount_error'));
      return false;
    }
    return true;
  },
  create_account: function(e) {
    // TODO: Accounts should include currency code.

    // Make target busy and get relevant data.
    swift_utils.busy(e.target);
    var account_data = {
        'code': $('#create-account-code').val(),
        'name': $('#create-account-name').val(),
        'type': $('#create-account-type').val(),
        'children': $('#create-account-children').val(),
        'parent': $('#create-account-parent').val(),
        'amount': $('#create-account-amount').val(),
      };

    // Check if data is correct and create it if it is.
    if(this.verify_account_data(account_data)) {
      var request = $.post('/swift/accounting/create_account', { account: account_data, _token: swift_utils.swift_token() });
      request.done(function(data) {
        swift_utils.free(e.target);
        if(data.state != 'Success') {
          swift_utils.display_error(data.error);
          return;
        }

        // Clear modal and hide it.
        $('#create-account-code').val('');
        $('#create-account-name').val('');
        $('#create-account-type').val('as');
        $('#create-account-children').val('1');
        $('#create-account-parent').val('');
        $('#create-account-amount').val('');
        $('#create-account').modal('hide');

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
  change_code: function(e) {
    accounts_code = $('#account-code').val();
    accounts_type = $('#account-type').val();
    accounts_offset = 1;
    this.load_accounts({
      'code': code,
      'type': type,
      'offset': accounts_offset,
    }, e);
  },
  change_type: function(e) {
    // Clear code and get type.
    accounts_offset = 1;
    accounts_code = '';
    $('#account-code').val('');
    accounts_type = $('#account-type').val();
    this.load_accounts({
      'code': accounts_code,
      'type': accounts_type,
      'offset': accounts_offset
    }, e);
  },
  load_accounts: function(a, e) {
    var request = $.post('/swift/accounting/load_accounts', { account_data: a, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      $('#accounts-table').empty();
      $('#accounts-table').append(data);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  load_ledger: function(e) {
    if($('#account-ledger-code').val() == '') {
      swift_utils.display_error(swift_language.get_sentence('create_account_blank_code'));
      return;
    }
    ledger_code = $('#account-ledger-code').val();
    var ledger_data = {
      'code': ledger_code,
      'date_range': $('#account-ledger-date-range').val(),
      'offset': ledger_offset,
    }
    var request = $.post('/swift/accounting/load_ledger', { ledger_data: ledger_data, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      $('#ledger-table').empty();
      $('#ledger-table').append(data);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  ledger_paginate: function(e) {
    ledger_offset = $(e.target).attr('id').split('-')[2];
    var ledger_data = {
      'code': ledger_code,
      'date_range': $('#account-ledger-date-range').val(),
      'offset': ledger_offset,
    }
    var request = $.post('/swift/accounting/load_ledger', { ledger_data: ledger_data, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      $('#ledger-table').empty();
      $('#ledger-table').append(data);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  download_ledger: function() {
    if($('#account-ledger-code').val() == '') {
      swift_utils.display_error(swift_language.get_sentence('create_account_blank_code'));
      return;
    }
    var ledger_data = {
      'code': $('#account-ledger-code').val(),
      'date_range': $('#account-ledger-date-range').val()
    }
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host
    window.open(baseUrl+'/swift/accounting/download_ledger?ledger_data='+JSON.stringify(ledger_data), '_blank')
  },
  print_ledger: function(e) {
    if($('#account-ledger-code').val() == '') {
      swift_utils.display_error(swift_language.get_sentence('create_account_blank_code'));
      return;
    }
    var ledger_data = {
      'code': $('#account-ledger-code').val(),
      'date_range': $('#account-ledger-date-range').val()
    }
    var request = $.post('/swift/accounting/print_ledger', { ledger_data: ledger_data, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      $('.print_area').empty();
      $('.print_area').append(data);
      window.print();
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  accounts_paginate: function(e) {
    accounts_offset = $(e.target).attr('id').split('-')[2];
    this.load_accounts({
      'code': accounts_code,
      'type': accounts_type,
      'offset': accounts_offset
    }, e);
  },
  ledger_description_edit: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');

    edit_code = row.attr('id').split('-')[2];
    edit_value = cell.text();
    edit_type = 'ledger';

    cell.replaceWith('<td><input type="text" class="change-ledger" value="'+edit_value+'"></td>')
    $('.change-ledger').focus();
  },
  account_name_edit: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');

    edit_code = row.attr('id').split('-')[1];
    edit_value = cell.text();
    edit_type = 'account';

    cell.replaceWith('<td><input type="text" class="change-account" value="'+edit_value+'"></td>')
    $('.change-account').focus();
  },
  account_name_change: function(e) {
    // Get new value.
    var value = $(e.target).val();
    if(value == edit_value) {
      $(e.target).parent('td')
        .replaceWith('<td class="account-name">'+edit_value+'</td>');
      return;
    }

    var change_data = {
      'edit_value': value,
      'edit_type': edit_type,
      'edit_code': edit_code,
    };
    var request = $.post('/swift/accounting/change_account_name', { change_data: change_data, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $(e.target).parent('td')
        .replaceWith('<td class="account-name">'+value+'</td>');
      swift_utils.display_success(data.message);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  ledger_description_change: function(e) {
    // Get new value.
    var value = $(e.target).val();
    if(value == edit_value) {
      $(e.target).parent('td')
        .replaceWith('<td class="ledger-description">'+edit_value+'</td>');
      return;
    }

    var change_data = {
      'edit_value': value,
      'edit_type': edit_type,
      'edit_code': edit_code,
    };
    var request = $.post('/swift/accounting/change_ledger_description', { change_data: change_data, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $(e.target).parent('td')
        .replaceWith('<td class="ledger-description">'+value+'</td>');
      swift_utils.display_success(data.message);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
}

var accounts_js = new Account();

// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '#create-account-create',
  'click',
  accounts_js,
  'create_account');

$(document).on('click', '#create-account-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-account-create');
});

swift_event_tracker.register_swift_event(
  '#account-type',
  'change',
  accounts_js,
  'change_type');

$(document).on('change', '#account-type', function(e) {
  swift_event_tracker.fire_event(e, '#account-type');
});

swift_event_tracker.register_swift_event(
  '#account-code',
  'change',
  accounts_js,
  'change_code');

$(document).on('change', '#account-code', function(e) {
  swift_event_tracker.fire_event(e, '#account-code');
});

swift_event_tracker.register_swift_event(
  '#account-ledger-search',
  'click',
  accounts_js,
  'load_ledger');

$(document).on('click', '#account-ledger-search', function(e) {
  swift_event_tracker.fire_event(e, '#account-ledger-search');
});

swift_event_tracker.register_swift_event(
  '#ledger-print',
  'click',
  accounts_js,
  'print_ledger');

$(document).on('click', '#ledger-print', function(e) {
  swift_event_tracker.fire_event(e, '#ledger-print');
});

swift_event_tracker.register_swift_event(
  '#ledger-download',
  'click',
  accounts_js,
  'download_ledger');

$(document).on('click', '#ledger-download', function(e) {
  swift_event_tracker.fire_event(e, '#ledger-download');
});

swift_event_tracker.register_swift_event(
  '.accounts-pagination > li > a',
  'click',
  accounts_js,
  'accounts_paginate');

$(document).on('click', '.accounts-pagination > li > a', function(e) {
  e.preventDefault();
  swift_event_tracker.fire_event(e, '.accounts-pagination > li > a');
});

swift_event_tracker.register_swift_event(
  '.ledger-pagination > li > a',
  'click',
  accounts_js,
  'ledger_paginate');

$(document).on('click', '.ledger-pagination > li > a', function(e) {
  e.preventDefault();
  swift_event_tracker.fire_event(e, '.ledger-pagination > li > a');
});

swift_event_tracker.register_swift_event(
  '.account-name',
  'click',
  accounts_js,
  'account_name_edit');

$(document).on('click', '.account-name', function(e) {
  swift_event_tracker.fire_event(e, '.account-name');
});

swift_event_tracker.register_swift_event(
  '.ledger-description',
  'click',
  accounts_js,
  'ledger_description_edit');

$(document).on('click', '.ledger-description', function(e) {
  swift_event_tracker.fire_event(e, '.ledger-description');
});

swift_event_tracker.register_swift_event(
  '.change-account',
  'focusout',
  accounts_js,
  'account_name_change');

$(document).on('focusout', '.change-account', function(e) {
  swift_event_tracker.fire_event(e, '.change-account');
});

swift_event_tracker.register_swift_event(
  '.change-ledger',
  'focusout',
  accounts_js,
  'ledger_description_change');

$(document).on('focusout', '.change-ledger', function(e) {
  swift_event_tracker.fire_event(e, '.change-ledger');
});

$(function() {
  $('#account-code').autocomplete({
    // Get the suggestions.
    source: function (request, response) {
      $.post('/swift/accounting/suggest_accounts',
      { code: request.term,
        type: $('#account-type').val(),
        _token: swift_utils.swift_token()
      },
      function (data) {
          response(data);
      });
    },
    minLength: 2
  });
  $('#account-ledger-code').autocomplete({
    // Get the suggestions.
    source: function (request, response) {
      $.post('/swift/accounting/suggest_accounts',
      { code: request.term,
        type: 'all',
        _token: swift_utils.swift_token()
      },
      function (data) {
          response(data);
      });
    },
    minLength: 2
  });
});
// Define Menu Tab Events.
swift_event_tracker.register_swift_event('#accounts-view-accounts-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#accounts-view-accounts-tab', function(e) {
  swift_event_tracker.fire_event(e, '#accounts-view-accounts-tab');
});

swift_event_tracker.register_swift_event('#accounts-ledger-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#accounts-ledger-tab', function(e) {
  swift_event_tracker.fire_event(e, '#accounts-ledger-tab');
});
