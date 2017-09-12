/*
  Staff Configuration Object.
*/
function StaffConfiguration() {
  staff_code = '';
}

StaffConfiguration.prototype = {
  constructor: StaffConfiguration,
  search_config: function(e) {
    var code = $('#staff-configuration-code').val()
    var request = $.post('/swift/staff/search_config', { code: code, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        swift_utils.free(e.target);
        return;
      }

      // Check response and populate fields accordingly.
      if(data.settings != '') {
        $('#staff-configuration-hourly-rate').val(data.settings.hourly_rate);
        $('#staff-configuration-schedule').val(data.settings.schedule_code);
        $('#staff-configuration-vehicle').val(data.settings.vehicle_code);
        $('#staff-configuration-self-print').val(data.settings.self_print);
        $('#staff-configuration-print-group').val(data.settings.print_group);
        $('#staff-configuration-notification-group').val(data.settings.notification_group);
        $('#staff-configuration-commission').val(data.settings.commission_group);
        $('#staff-configuration-discounts').val(data.settings.discount_group);
        $('#staff-configuration-branch').val(data.settings.branches_group);
        $('#staff-configuration-pos').val(data.settings.pos_group);
        $('#staff-configuration-access').val(data.access);
      }
      if(data.accounts != '') {
        $('#staff-configuration-cashbox').val(data.accounts.cashbox_account);
        $('#staff-configuration-stock').val(data.accounts.stock_account);
        $('#staff-configuration-loan').val(data.accounts.loan_account);
        $('#staff-configuration-long-loan').val(data.accounts.long_loan_account);
        $('#staff-configuration-salary').val(data.accounts.salary_account);
        $('#staff-configuration-commission-account').val(data.accounts.commission_account);
        $('#staff-configuration-bonus').val(data.accounts.bonus_account);
        $('#staff-configuration-antiquity').val(data.accounts.antiquity_account);
        $('#staff-configuration-holidays').val(data.accounts.holidays_account);
        $('#staff-configuration-savings').val(data.accounts.savings_account);
        $('#staff-configuration-insurance').val(data.accounts.insurance_account);

        $('#staff-configuration-reimbursement').empty();
        $.each(data.accounts.reimbursement_accounts, function(code, account) {
          var option = '<option value="'+code+'">'+account+'</option>';
          $('#staff-configuration-reimbursement').append(option);
        });

        $('#staff-configuration-draw').empty();
        $.each(data.accounts.draw_accounts, function(code, account) {
          var option = '<option value="'+code+'">'+account+'</option>';
          $('#staff-configuration-draw').append(option);
        });

        $('#staff-configuration-bank').empty();
        $.each(data.accounts.bank_accounts, function(code, account) {
          var option = '<option value="'+code+'">'+account+'</option>';
          $('#staff-configuration-bank').append(option);
        });
      }
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  save_config: function(e) {
    var code = $('#staff-configuration-code').val();
    if(code == '') {
      swift_utils.display_error(swift_language.get_sentence('save_config_error'));
      return;
    }

    if($('#staff-configuration-hourly-rate').length) {
      var settings = {
        'hourly_rate': $('#staff-configuration-hourly-rate').val(),
        'schedule_code': $('#staff-configuration-schedule').val(),
        'vehicle_code': $('#staff-configuration-vehicle').val(),
        'self_print': $('#staff-configuration-self-print').val(),
        'print_group': $('#staff-configuration-print-group').val(),
        'notification_group': $('#staff-configuration-notification-group').val(),
        'commission_group': $('#staff-configuration-commission').val(),
        'discount_group': $('#staff-configuration-discounts').val(),
        'branches_group': $('#staff-configuration-branch').val(),
        'pos_group': $('#staff-configuration-pos').val(),
      }
      if(!this.check_settings(settings)) {
        return;
      }
      var access = $('#staff-configuration-access').val();
      if(access == '') {
        swift_utils.display_error(swift_language.get_sentence('access_error'));
        return;
      }
    }
    if($('#staff-configuration-cashbox').length) {
      $('#staff-configuration-reimbursement option').prop('selected', true);
      $('#staff-configuration-draw option').prop('selected', true);
      $('#staff-configuration-bank option').prop('selected', true);
      var accounts = {
        'cashbox_account': $('#staff-configuration-cashbox').val(),
        'stock_account': $('#staff-configuration-stock').val(),
        'loan_account': $('#staff-configuration-loan').val(),
        'long_loan_account': $('#staff-configuration-long-loan').val(),
        'salary_account': $('#staff-configuration-salary').val(),
        'commission_account': $('#staff-configuration-commission-account').val(),
        'bonus_account': $('#staff-configuration-bonus').val(),
        'antiquity_account': $('#staff-configuration-antiquity').val(),
        'holidays_account': $('#staff-configuration-holidays').val(),
        'savings_account': $('#staff-configuration-savings').val(),
        'insurance_account': $('#staff-configuration-insurance').val(),
        'reimbursement_accounts': $('#staff-configuration-reimbursement').val(),
        'draw_accounts':  $('#staff-configuration-draw').val(),
        'bank_accounts':  $('#staff-configuration-bank').val()
      }
      if(!this.check_accounts(accounts)) {
        return;
      }
    }

    swift_utils.busy(e.target);
    var request = $.post('/swift/staff/save_config', { code: code, settings: settings,
        access: access, accounts: accounts, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      console.log('moo')
      swift_utils.display_success(data.message);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  check_settings: function(settings) {
    if(settings.hourly_rate == '') {
      swift_utils.display_error(swift_language.get_sentence('hourly_rate_error'));
      return false;
    }
    if(settings.schedule_code == '') {
      swift_utils.display_error(swift_language.get_sentence('schedule_code_error'));
      return false;
    }
    if(settings.vehicle_code == '') {
      swift_utils.display_error(swift_language.get_sentence('vehicle_code_error'));
      return false;
    }
    if(settings.print_group == '') {
      swift_utils.display_error(swift_language.get_sentence('print_group_error'));
      return false;
    }
    if(settings.notification_group == '') {
      swift_utils.display_error(swift_language.get_sentence('notification_group_error'));
      return false;
    }
    if(settings.commission_group == '') {
      swift_utils.display_error(swift_language.get_sentence('commission_group_error'));
      return false;
    }
    if(settings.discount_group == '') {
      swift_utils.display_error(swift_language.get_sentence('discount_group_error'));
      return false;
    }
    if(settings.branches_group == '') {
      swift_utils.display_error(swift_language.get_sentence('branches_group_error'));
      return false;
    }
    if(settings.pos_group == '') {
      swift_utils.display_error(swift_language.get_sentence('pos_group_error'));
      return false;
    }
    return true;
  },
  check_accounts: function(accounts) {
    // TODO: Check accounts if required, might just make them 0 by default.
    return true;
  },
}

var staff_configuration_js = new StaffConfiguration();

// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '#staff-configuration-code',
  'change',
  staff_configuration_js,
  'search_config');

$(document).on('change', '#staff-configuration-code', function(e) {
  swift_event_tracker.fire_event(e, '#staff-configuration-code');
});

swift_event_tracker.register_swift_event(
  '#staff-configuration-save',
  'click',
  staff_configuration_js,
  'save_config');

$(document).on('click', '#staff-configuration-save', function(e) {
  swift_event_tracker.fire_event(e, '#staff-configuration-save');
});

$(document).on('focus', '#staff-configuration-code', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/staff/suggest_staff',
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

$(document).on('focus', '#staff-configuration-vehicle', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/vehicle/suggest_vehicle',
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

$(document).on('focus', '#staff-configuration-print-group', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/group/suggest_print',
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

$(document).on('focus', '#staff-configuration-notification-group', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/group/suggest_notification',
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

$(document).on('focus', '#staff-configuration-commission', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/group/suggest_commission',
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

$(document).on('focus', '#staff-configuration-discounts', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/group/suggest_discount',
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

$(document).on('focus', '#staff-configuration-branch', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/group/suggest_branch',
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

$(document).on('focus', '#staff-configuration-pos', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/group/suggest_pos',
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

$(document).on('focus', '#staff-configuration-cashbox', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_asset',
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

$(document).on('focus', '#staff-configuration-stock', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_asset',
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

$(document).on('focus', '#staff-configuration-loan', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_asset',
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

$(document).on('focus', '#staff-configuration-loan-loan', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_asset',
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

$(document).on('focus', '#staff-configuration-salary', function(e) {
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

$(document).on('focus', '#staff-configuration-commission-account', function(e) {
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

$(document).on('focus', '#staff-configuration-bonus', function(e) {
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

$(document).on('focus', '#staff-configuration-antiquity', function(e) {
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

$(document).on('focus', '#staff-configuration-holidays', function(e) {
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

$(document).on('focus', '#staff-configuration-savings', function(e) {
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

$(document).on('focus', '#staff-configuration-insurance', function(e) {
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

$(document).on('focus', '#staff-configuration-reimbursement-code', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_asset',
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

$(document).on('focus', '#staff-configuration-draw-code', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_asset',
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

$(document).on('focus', '#staff-configuration-bank-code', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_asset',
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
swift_event_tracker.register_swift_event('#staff-configuration-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#staff-configuration-tab', function(e) {
  swift_event_tracker.fire_event(e, '#staff-configuration-tab');
});

swift_event_tracker.register_swift_event('#staff-configuration-view-access-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#staff-configuration-view-access-tab', function(e) {
  swift_event_tracker.fire_event(e, '#staff-configuration-view-access-tab');
});
