function Currency() {
  view_account = {};
  report_account = {};
}

Currency.prototype = {
  constructor: Currency,
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
        if(data['state'] != 'Success') {
          swift_utils.display_error(data.error);
          return;
        }
        $('#create-account').modal('hide');
        swift_utils.display_success(data['message']);
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
    var code = $('#account-code').val();
    var type = $('#account-type').val();
    this.load_accounts({'code': code, 'type': type}, e);
  },
  change_type: function(e) {
    // Clear code and get type.
    $('#account-code').val('');
    var type = $('#account-type').val();
    this.load_accounts({'code': '', 'type': type}, e);
  },
  load_accounts: function(a, e) {
    var request = $.post('/swift/accounting/load_accounts', { account_data: a, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      $('#accounts-body').empty();
      $('#accounts-body').append(data);
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
    var ledger_data = {
      'code': $('#account-ledger-code').val(),
      'date_range': $('#account-ledger-date-range').val(),
      'offset': 0
    }
    var request = $.post('/swift/accounting/load_ledger', { ledger_data: ledger_data, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      $('#ledger-table-body').empty();
      $('#ledger-table-body').append(data);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  ledger_pagination: function() {
    // TODO: Implement Pagination for ledger.
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
}

var currency_js = new Currency();
