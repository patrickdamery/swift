/*
  Bank Accounts Object.
*/
function BankAccount() {
  account_code = '';
  current_account = '';
  pos_code = '';
  cheque_book_code = '';
  loan_code = '';
  offset = 1;
}

BankAccount.prototype = {
  constructor: BankAccount,
  verify_account_data: function(a) {
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
    return true;
  },
  create_bank_account: function(e) {
    // Make target busy and get relevant data.
    swift_utils.busy(e.target);
    var account_data = {
        'bank_name': $('#create-bank-account-name').val(),
        'number': $('#create-bank-account-number').val(),
        'account': $('#create-bank-account-account').val(),
      };

    // Check if data is correct and create it if it is.
    if(this.verify_account_data(account_data)) {
      var bank_account_ref = this;
      var request = $.post('/swift/accounting/create_bank_account', { account: account_data, _token: swift_utils.swift_token() });
      request.done(function(data) {
        swift_utils.free(e.target);
        if(data.state != 'Success') {
          swift_utils.display_error(data.error);
          return;
        }

        var option = '<option value="'+data.bank_account.code+'">'+data.bank_account.bank_name+' '+data.bank_account.account_number+'</option>';
        $('#bank-account-code').append(option);

        // Clear modal and hide it.
        $('#create-bank-account-name').val('');
        $('#create-bank-account-number').val('');
        $('#create-bank-account-account').val('');
        $('#create-bank-account').modal('hide');

        swift_utils.display_success(data.message);
        bank_account_ref.search_account(e);
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
    var request = $.post('/swift/accounting/search_bank_account', { code: account_code, _token: swift_utils.swift_token() });
    request.done(function(view) {
      swift_utils.free(e.target);
      $('#bank-account-table').empty();
      $('#bank-account-table').append(view);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  show_create_pos: function(e) {
    current_account = $(e.target).parents('tr')
      .attr('id').split('-')[2];
    $('#create-pos-name').val('');
    $('#create-pos-bank-commission').val('');
    $('#create-pos-government-commission').val('');
  },
  show_create_cheque_book: function(e) {
    current_account = $(e.target).parents('tr')
      .attr('id').split('-')[2];
    $('#create-cheque-book-name').val('');
    $('#create-cheque-book-number').val('');
  },
  show_create_loan: function(e) {
    current_account = $(e.target).parents('tr')
      .attr('id').split('-')[2];
    $('#create-loan-account').val('');
    $('#create-loan-amount').val('');
    $('#create-loan-start-date').val('');
    $('#create-loan-interval').val('monthly');
    $('#create-loan-interest').val('');
    $('#create-loan-payment').val('');
  },
  create_pos: function(e) {
    var name = $('#create-pos-name').val();
    var bank_commission = $('#create-pos-bank-commission').val();
    var government_commission = $('#create-pos-government-commission').val();

    if(name == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_pos_name'));
      return;
    }
    if(bank_commission == '' || government_commission == ''
      || !$.isNumeric(bank_commission) || !$.isNumeric(government_commission)) {
        swift_utils.display_error(swift_language.get_sentence('pos_commission_required'));
        return;
      }
    swift_utils.busy(e.target);
    var bank_account_ref = this;
    var request = $.post('/swift/accounting/create_pos', { code: current_account,
      name: name, bank_commission: bank_commission, government_commission: government_commission,
      _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }

      $('#create-pos').modal('hide');
      swift_utils.display_success(data.message);
      bank_account_ref.search_account(e);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  create_cheque_book: function(e) {
    var name = $('#create-cheque-book-name').val();
    var number = $('#create-cheque-book-number').val();

    if(name == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_cheque_book_name'));
      return;
    }
    if(number == '' || !$.isNumeric(number)) {
        swift_utils.display_error(swift_language.get_sentence('cheque_number_required'));
        return;
      }
    swift_utils.busy(e.target);
    var bank_account_ref = this;
    var request = $.post('/swift/accounting/create_cheque_book', { code: current_account,
      name: name, number: number, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }

      swift_utils.display_success(data.message);
      $('#create-cheque-book').modal('hide');
      bank_account_ref.search_account(e);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  create_loan: function(e) {
    var account = $('#create-loan-account').val();
    var amount = $('#create-loan-amount').val();
    var start_date = $('#create-loan-start-date').val();
    var interval = $('#create-loan-interval').val();
    var interest = $('#create-loan-interest').val();
    var payment = $('#create-loan-payment').val();

    if(account == '' || !$.isNumeric(account)) {
      swift_utils.display_error(swift_language.get_sentence('account_required'));
      return;
    }

    if(amount == '' || !$.isNumeric(amount)) {
      swift_utils.display_error(swift_language.get_sentence('amount_required'));
      return;
    }

    if(start_date == '') {
      swift_utils.display_error(swift_language.get_sentence('start_date_required'));
      return;
    }

    if(interest == '' || !$.isNumeric(interest)) {
      swift_utils.display_error(swift_language.get_sentence('interest_required'));
      return;
    }

    if(payment == '' || !$.isNumeric(payment)) {
      swift_utils.display_error(swift_language.get_sentence('payment_required'));
      return;
    }
    swift_utils.busy(e.target);
    var bank_account_ref = this;
    var request = $.post('/swift/accounting/create_loan', { code: current_account,
      account: account, amount: amount, start_date: start_date,
      interval: interval, interest: interest, payment: payment, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      swift_utils.display_success(data.message);
      $('#create-loan').modal('hide');
      bank_account_ref.search_account(e);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  load_pos: function(e) {
    pos_code = $(e.target).attr('id').split('-')[2];
    swift_utils.busy(e.target);
    var request = $.post('/swift/accounting/get_pos', { code: pos_code, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }

      $('#view-pos-name').val(data.pos.name);
      $('#view-pos-bank-commission').val(data.pos.bank_commission);
      $('#view-pos-government-commission').val(data.pos.government_commission);
      $('#view-pos').modal('show');
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  load_cheque_book: function(e) {
    swift_utils.busy(e.target);
    cheque_book_code = $(e.target).attr('id').split('-')[2];
    var bank_account_ref = this;
    var request = $.post('/swift/accounting/get_cheque_book', { code: cheque_book_code, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      offset = 1;
      $('#view-cheque-book-name').val(data.cheque_book.name);
      $('#view-cheque-book-number').val(data.cheque_book.current_number);
      bank_account_ref.load_cheques(e);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  load_cheques: function(e) {
    swift_utils.busy(e.target);
    var date_range = $('#view-cheque-book-date-range').val();
    cheque_book_code = $(e.target).attr('id').split('-')[2];
    var request = $.post('/swift/accounting/load_cheques', { code: cheque_book_code,
      date_range: date_range, offset: offset, _token: swift_utils.swift_token() });
    request.done(function(view) {
      swift_utils.free(e.target);
      $('#cheques_table').empty();
      $('#cheques_table').append(view);
      $('#view-cheque-book').modal('show');
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  load_loan: function(e) {

  },
  edit_pos: function(e) {
    var name = $('#view-pos-name').val();
    var bank_commission = $('#view-pos-bank-commission').val();
    var government_commission = $('#view-pos-government-commission').val();

    if(name == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_pos_name'));
      return;
    }
    if(bank_commission == '' || government_commission == ''
      || !$.isNumeric(bank_commission) || !$.isNumeric(government_commission)) {
        swift_utils.display_error(swift_language.get_sentence('pos_commission_required'));
        return;
      }
    swift_utils.busy(e.target);
    var bank_account_ref = this;
    var request = $.post('/swift/accounting/edit_pos', { code: pos_code,
      name: name, bank_commission: bank_commission, government_commission: government_commission,
      _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }

      $('#view-pos').modal('hide');
      swift_utils.display_success(data.message);
      bank_account_ref.search_account(e);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  edit_cheque_book: function(e) {

  },
  show_create_cheque: function(e) {

  },
  create_cheque: function(e) {

  },
  print_cheque: function(e) {

  },
  edit_loan: function(e) {

  },
}

var bank_accounts_js = new BankAccount();

// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '#view-cheque-book-edit',
  'click',
  bank_accounts_js,
  'edit_cheque_book');

$(document).on('click', '#view-cheque-book-edit', function(e) {
  swift_event_tracker.fire_event(e, '#view-cheque-book-edit');
});

swift_event_tracker.register_swift_event(
  '.view-cheque-book',
  'click',
  bank_accounts_js,
  'load_cheque_book');

$(document).on('click', '.view-cheque-book', function(e) {
  swift_event_tracker.fire_event(e, '.view-cheque-book');
});

swift_event_tracker.register_swift_event(
  '#view-pos-edit',
  'click',
  bank_accounts_js,
  'edit_pos');

$(document).on('click', '#view-pos-edit', function(e) {
  swift_event_tracker.fire_event(e, '#view-pos-edit');
});

swift_event_tracker.register_swift_event(
  '.view-pos',
  'click',
  bank_accounts_js,
  'load_pos');

$(document).on('click', '.view-pos', function(e) {
  swift_event_tracker.fire_event(e, '.view-pos');
});

swift_event_tracker.register_swift_event(
  '#create-loan-create',
  'click',
  bank_accounts_js,
  'create_loan');

$(document).on('click', '#create-loan-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-loan-create');
});

swift_event_tracker.register_swift_event(
  '#create-cheque-book-create',
  'click',
  bank_accounts_js,
  'create_cheque_book');

$(document).on('click', '#create-cheque-book-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-cheque-book-create');
});

swift_event_tracker.register_swift_event(
  '#create-pos-create',
  'click',
  bank_accounts_js,
  'create_pos');

$(document).on('click', '#create-pos-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-pos-create');
});

swift_event_tracker.register_swift_event(
  '.create-pos',
  'click',
  bank_accounts_js,
  'show_create_pos');

$(document).on('click', '.create-pos', function(e) {
  swift_event_tracker.fire_event(e, '.create-pos');
});

swift_event_tracker.register_swift_event(
  '.create-loan',
  'click',
  bank_accounts_js,
  'show_create_loan');

$(document).on('click', '.create-loan', function(e) {
  swift_event_tracker.fire_event(e, '.create-loan');
});

swift_event_tracker.register_swift_event(
  '.create-cheque',
  'click',
  bank_accounts_js,
  'show_create_cheque_book');

$(document).on('click', '.create-cheque', function(e) {
  swift_event_tracker.fire_event(e, '.create-cheque');
});

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

$(document).on('focus', '#create-bank-account-account', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_asset',
        { code: request.term,
          type: 'all',
          _token: swift_utils.swift_token()
        },
        function (data) {
            response(data);
        });
      },
      minLength: 2
    })
  }
});

$(document).on('focus', '#create-loan-account', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_liability',
        { code: request.term,
          _token: swift_utils.swift_token()
        },
        function (data) {
            response(data);
        });
      },
      minLength: 2
    })
  }
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
