/*
  Accounts Object.
*/
function Account() {
  view_account = {};
  report_account = {};
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
      var menu_content = $.post('/swift/accounting/create_account', { account: account_data, _token: swift_utils.swift_token() });
      menu_content.done(function(data) {
        if(data.state != 'Success') {
          swift_utils.display_error(data.error);
        }
        swift_utils.display_success(data.message);
        swift_utils.free(e.target);
        $('#create-account').modal('hide');
      });
      menu_content.fail(function(ev) {
        swift_utils.free(e.target);
        swift_utils.ajax_fail(ev);
      });
    } else {
      swift_utils.free(e.target);
    }
  },
  load_accounts: function() {

  },
  load_ledger: function() {

  },
  download_ledger: function() {

  },
  print_ledger: function() {

  },
}

var accounts_js = new Account();

// Define Feedback Messages.
swift_language.add_sentence('create_account_blank_code', {
                            'en': 'Account Code can\'t be left blank!',
                            'es': 'Codigo de Cuenta no puede dejarse en blanco!'
                          });
swift_language.add_sentence('create_account_blank_name', {
                            'en': 'Account Name can\'t be left blank!',
                            'es': 'Nombre de Cuenta no puede dejarse en blanco!'
                          });
swift_language.add_sentence('create_account_amount_error', {
                            'en': 'Amount in Account can\'t be blank and must be a numeric value!',
                            'es': 'Saldo de Cuenta no puede dejarse en blanco y debe ser un valor numerico!'
                          });

// Define Modal Event Listeners.
swift_event_tracker.register_swift_event(
  '#create-account-create',
  'click',
  accounts_js,
  'create_account');

$(document).on('click', '#create-account-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-account-create');
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
