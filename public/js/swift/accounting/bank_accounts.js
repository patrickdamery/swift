/*
  Bank Accounts Object.
*/
function BankAccount() {
  account_code = '';
  account_date_range = '';
  account_offset = 1;
}

BankAccount.prototype = {
  constructor: BankAccount,
  verify_account_data: function(a) {
    if(a.code == '') {
      swift_utils.display_error(swift_language.get_sentence('create_account_blank_code'));
      return false;
    }
    if(a.bank_name == '') {
      swift_utils.display_error(swift_language.get_sentence('create_account_blank_name'));
      return false;
    }
    if(a.number == '' || !$.isNumeric(a.number)) {
      swift_utils.display_error(swift_language.get_sentence('create_account_number_error'));
      return false;
    }
    if(a.account == '') {
      swift_utils.display_error(swift_language.get_sentence('create_account_blank_account'));
      return false;
    }
    if(a.balance == '' || !$.isNumeric(a.balance)) {
      swift_utils.display_error(swift_language.get_sentence('create_account_balance_error'));
      return false;
    }
    return true;
  },
  create_bank_account: function(e) {
    // Make target busy and get relevant data.
    swift_utils.busy(e.target);
    var account_data = {
        'code': $('#create-bank-account-code').val(),
        'bank_name': $('#create-bank-account-name').val(),
        'number': $('#create-bank-account-number').val(),
        'account': $('#create-bank-account-account').val(),
        'balance': $('#create-bank-account-balance').val(),
        'currency': $('#create-bank-account-currency').val()
      };

    // Check if data is correct and create it if it is.
    if(this.verify_account_data(account_data)) {
      var request = $.post('/swift/accounting/create_bank_account', { account: account_data, _token: swift_utils.swift_token() });
      request.done(function(data) {
        swift_utils.free(e.target);
        if(data.state != 'Success') {
          swift_utils.display_error(data.error);
          return;
        }

        // Clear modal and hide it.
        $('#create-bank-account-code').val('');
        $('#create-bank-account-name').val('');
        $('#create-bank-account-number').val('');
        $('#create-bank-account-account').val('');
        $('#create-bank-account-balance').val('');
        $('#create-bank-account-currency').val('cord');
        $('#create-bank-account').modal('hide');

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
  search_account: function(e) {
    swift_utils.busy(e.target);

    account_code = $('#bank-account-code').val();
    account_date_range = $('#bank-account-date-range').val();
    account_offset = 1;
    var bank_account_ref = this;
    var request = $.post('/swift/accounting/search_bank_account', { code: account_code, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.free(e.target);
        swift_utils.display_error(data.error);
        return;
      }
      $('#bank-account-balance').val(data.balance);
      bank_account_ref.load_transactions(e);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  load_transactions: function(e) {
    var account_search = {
      'code': account_code,
      'date_range': account_date_range,
      'offset': account_offset
    };
    var request = $.post('/swift/accounting/search_bank_transactions', { account_search: account_search, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      $('#bank-account-table').empty();
      $('#bank-account-table').append(data);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  make_transaction: function(e) {
    var transaction = {
      'code': $('#bank-account-transaction-code').val(),
      'reason': $('#bank-account-transaction-reason').val(),
      'type' : $('#bank-account-transaction-type').val(),
      'value': $('#bank-account-transaction-value').val()
    };
    
    var bank_account_ref = this;
    var request = $.post('/swift/accounting/make_bank_transaction', { transaction: transaction_data, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.free(e.target);
        swift_utils.display_error(data.error);
        return;
      }
      if(transaction.code == account_code) {
          $('#bank-account-balance').val(data.balance);
          bank_account_ref.load_transactions(e);
      } else {
        swift_utils.free(e.target);
      }
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
}

var bank_accounts_js = new BankAccount();


// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '#create-bank-account-create',
  'click',
  bank_accounts_js,
  'create_bank_account');

$(document).on('click', '#create-bank-account-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-bank-account-create');
});

swift_event_tracker.register_swift_event(
  '#bank-accounts-search',
  'click',
  bank_accounts_js,
  'search_account');

$(document).on('click', '#bank-accounts-search', function(e) {
  swift_event_tracker.fire_event(e, '#bank-accounts-search');
});

$(function() {
  $('#create-bank-account-account').autocomplete({
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
  $('#bank-account-code').autocomplete({
    // Get the suggestions.
    source: function (request, response) {
      $.post('/swift/accounting/suggest_bank_accounts',
      { code: request.term,
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
swift_event_tracker.register_swift_event('#bank-accounts-view-accounts-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#bank-accounts-view-accounts-tab', function(e) {
  swift_event_tracker.fire_event(e, '#bank-accounts-view-accounts-tab');
});

swift_event_tracker.register_swift_event('#bank-loans-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#bank-loans-tab', function(e) {
  swift_event_tracker.fire_event(e, '#bank-loans-tab');
});

swift_event_tracker.register_swift_event('#bank-accounts-pos-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#bank-accounts-pos-tab', function(e) {
  swift_event_tracker.fire_event(e, '#bank-accounts-pos-tab');
});
