function DepreciatingAssets() {
  code = '';
}

DepreciatingAssets.prototype = {
  constructor: DepreciatingAssets,
  create_depreciating_account: function(e) {
    var name = $('#create-depreciating-asset-name').val();
    var depreciation = $('#create-depreciating-asset-depreciation').val();
    var description = $('#create-depreciating-asset-description').val();
    var asset_account = $('#create-depreciating-asset-account').val();
    var expense_account = $('#create-depreciating-expense-account').val();
    var depreciation_account = $('#create-depreciating-depreciation-account').val();

    swift_utils.busy(e.target);
    var request = $.post('/swift/accounting/create_depreciating_account', { name: name,
      depreciation: depreciation, description: description, asset_account: asset_account,
      depreciation_account: depreciation_account, expense_account: expense_account, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      swift_utils.display_success(data.message);
      var option = $([
          '<option value="'+data.asset.code+'">',
          data.asset.name,
          '</option>'].join("\n"));
      $('#depreciating-assets-code').append(option);
      $('#create-depreciating-assets').modal('hide');
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  save_depreciating_account: function(e) {
    var name = $('#depreciating-assets-name').val();
    var depreciation = $('#depreciating-assets-depreciation').val();
    var description = $('#depreciating-assets-description').val();
    var asset_account = $('#depreciating-assets-asset-account').val();
    var depreciation_account = $('#depreciating-assets-depreciation-account').val();
    var expense_account = $('#depreciating-assets-depreciation-expense-account').val();

    swift_utils.busy(e.target);
    var request = $.post('/swift/accounting/save_depreciating_account', { code: code,
      name: name, description: description, depreciation: depreciation, asset_account: asset_account,
      depreciation_account: depreciation_account, expense_account: expense_account, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      swift_utils.display_success(data.message);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  search_depreciating_accounts: function(e) {
    code = $('#depreciating-assets-code').val();
    swift_utils.busy(e.target);
    var request = $.post('/swift/accounting/search_depreciating_account', { code: code,
      _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $('#depreciating-assets-name').val(data.asset.name);
      $('#depreciating-assets-depreciation').val(data.asset.depreciation);
      $('#depreciating-assets-description').val(data.asset.description);
      $('#depreciating-assets-asset-account').val(data.asset.asset_code);
      $('#depreciating-assets-depreciation-account').val(data.asset.depreciation_code);
      $('#depreciating-assets-depreciation-expense-account').val(data.asset.expense_code);

    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  clear_create_form: function(e) {
    $('#create-depreciating-asset-name').val('');
    $('#create-depreciating-asset-depreciation').val('');
    $('#create-depreciating-asset-description').val('');
    $('#create-depreciating-asset-account').val('');
    $('#create-depreciating-depreciation-account').val('');
    $('#depreciating-assets-depreciation-expense-account').val('');
  },
}

var depreciating_assets_js = new DepreciatingAssets();

// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '#depreciating-assets-save',
  'click',
  depreciating_assets_js,
  'save_depreciating_account');

$(document).on('click', '#depreciating-assets-save', function(e) {
  swift_event_tracker.fire_event(e, '#depreciating-assets-save');
});

swift_event_tracker.register_swift_event(
  '#depreciating-assets-search',
  'click',
  depreciating_assets_js,
  'search_depreciating_accounts');

$(document).on('click', '#depreciating-assets-search', function(e) {
  swift_event_tracker.fire_event(e, '#depreciating-assets-search');
});

swift_event_tracker.register_swift_event(
  '#create-depreciating-asset-button',
  'click',
  depreciating_assets_js,
  'clear_create_form');

$(document).on('click', '#create-depreciating-asset-button', function(e) {
  swift_event_tracker.fire_event(e, '#create-depreciating-asset-button');
});

swift_event_tracker.register_swift_event(
  '#create-depreciating-asset-create',
  'click',
  depreciating_assets_js,
  'create_depreciating_account');

$(document).on('click', '#create-depreciating-asset-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-depreciating-asset-create');
});

$(document).on('focus', '#create-depreciating-asset-account', function(e) {
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

$(document).on('focus', '#create-depreciating-depreciation-account', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_contra_asset',
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

$(document).on('focus', '#create-depreciating-expense-account', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_expense',
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

$(document).on('focus', '#depreciating-assets-asset-account', function(e) {
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

$(document).on('focus', '#depreciating-assets-depreciation-account', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_contra_asset',
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

$(document).on('focus', '#depreciating-assets-depreciation-expense-account', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_expense',
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
