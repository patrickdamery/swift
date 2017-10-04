function Journal() {
  entry_offset = 1;
  entries = [];
}

Journal.prototype = {
  constructor: Journal,
  search_entries: function(e) {
    entry_offset = 1;
    this.load_entries(e);
  },
  load_entries: function(e) {
    var date_range = $('#journal-date-range').val();
    var type = $('#journal-group-entry').val();

    swift_utils.busy(e.target);
    var journal_ref = this;
    var request = $.post('/swift/accounting/search_entries', { date_range: date_range,
      type: type, offset: entry_offset, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);

      $('#journal-entries-table').empty();
      $('#journal-entries-table').append(data);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  download_entries: function(e) {
    var entries_data = {
      'date_range': $('#journal-date-range').val(),
      'type': $('#journal-group-entry').val()
    }
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host
    window.open(baseUrl+'/swift/accounting/download_entries?entries_data='+JSON.stringify(entries_data), '_blank');
  },
  paginate_entries: function(e) {
    entry_offset = $(e.target).attr('id').split('-')[2];
    this.load_entries(e);
  },
  show_create_entry: function() {
    entries = [];
    $('#create-entry-account').val('');
    $('#create-entry-amount').val('');
    $('#create-entry-type').val('debit');
    $('#create-entry-description').val('');
    $('#journal-entry-table-body').empty();
  },
  add_entry: function() {
    var account = $('#create-entry-account').val();
    var amount = $('#create-entry-amount').val();
    var type = $('#create-entry-type').val();
    var description = $('#create-entry-description').val();
    if(account == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_account'));
      return;
    }
    if(amount == '' || !$.isNumeric(amount)) {
      swift_utils.display_error(swift_language.get_sentence('blank_amount'));
      return;
    }
    if(description == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_description'));
      return;
    }
    entries.push({
      'account': account,
      'amount': amount,
      'type': type,
      'description': description,
    });
    var row = $([
        '<tr class="create-entry-row" id="create-entry-'+(entries.length-1)+'">',
        '<td>'+account+'</td>',
        '<td>'+description+'</td>',
        '<td>'+((type == 'debit') ? amount : '')+'</td>',
        '<td>'+((type == 'credit') ? amount : '')+'</td>',
        '</tr>'].join("\n"));
    $('#journal-entry-table-body').append(row);
  },
  create_entry: function(e) {
    if(entries.length == 0) {
      swift_utils.display_error(swift_language.get_sentence('no_entries'));
      return;
    }
    var credit = 0;
    var debit = 0;
    $.each(entries, function(key, data) {
      debit += ((data.type == 'debit') ? parseFloat(data.amount) : 0);
      credit += ((data.type == 'credit') ? parseFloat(data.amount) : 0);
    });
    if(credit != debit) {
      swift_utils.display_error(swift_language.get_sentence('entry_sums_not_equal'));
      return;
    }
    swift_utils.busy(e.target);
    var journal_ref = this;
    var request = $.post('/swift/accounting/create_entries', { entries: entries, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      swift_utils.display_success(data.message);
      $('#create-entry').modal('hide');
      journal_ref.load_entries(e);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  remove_entry: function(e) {
    var index = e.trigger[0].id.split('-')[2];
    entries.splice(index, 1);
    $('#journal-entry-table-body').empty();
    $.each(entries, function(key, data) {
      var row = $([
          '<tr class="create-entry-row" id="create-entry-'+key+'">',
          '<td>'+data.account+'</td>',
          '<td>'+data.description+'</td>',
          '<td>'+((data.type == 'debit') ? data.amount : '')+'</td>',
          '<td>'+((data.type == 'credit') ? data.amount : '')+'</td>',
          '</tr>'].join("\n"));
      $('#journal-entry-table-body').append(row);
    });
  },
}

var journal_js = new Journal();

// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '#create-entry-create',
  'click',
  journal_js,
  'create_entry');

$(document).on('click', '#create-entry-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-entry-create');
});

swift_event_tracker.register_swift_event(
  '#journal-create-entry',
  'click',
  journal_js,
  'show_create_entry');

$(document).on('click', '#journal-create-entry', function(e) {
  swift_event_tracker.fire_event(e, '#journal-create-entry');
});

swift_event_tracker.register_swift_event(
  '#journal-create-add',
  'click',
  journal_js,
  'add_entry');

$(document).on('click', '#journal-create-add', function(e) {
  swift_event_tracker.fire_event(e, '#journal-create-add');
});

swift_event_tracker.register_swift_event(
  '.journal-pagination > li > a',
  'click',
  journal_js,
  'paginate_entries');

$(document).on('click', '.journal-pagination > li > a', function(e) {
  e.preventDefault();
  swift_event_tracker.fire_event(e, '.journal-pagination > li > a');
});

swift_event_tracker.register_swift_event(
  '#journal-download',
  'click',
  journal_js,
  'download_entries');

$(document).on('click', '#journal-download', function(e) {
  swift_event_tracker.fire_event(e, '#journal-download');
});

swift_event_tracker.register_swift_event(
  '#journal-search',
  'click',
  journal_js,
  'search_entries');

$(document).on('click', '#journal-search', function(e) {
  swift_event_tracker.fire_event(e, '#journal-search');
});

$(document).on('focus', '#create-entry-account', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/accounting/suggest_accounts',
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

$(function() {
  $.contextMenu({
    selector: '.create-entry-row',
    callback: function(key, options) {
      if(key == 'delete') {
        var e = { 'type': 'context_option', 'trigger': options.$trigger};
        swift_event_tracker.fire_event(e, '.create-entry-row');
      }
    },
    items: {
      'delete': {name: swift_language.get_sentence('delete'), icon: 'fa-trash'},
    }
  });
});

swift_event_tracker.register_swift_event(
  '.create-entry-row',
  'context_option',
  journal_js,
  'remove_entry');

swift_event_tracker.register_swift_event('#journal-view-entries-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-view-entries-tab', function(e) {
  swift_event_tracker.fire_event(e, '#journal-view-entries-tab');
});
swift_event_tracker.register_swift_event('#journal-reports-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-reports-tab', function(e) {
  swift_event_tracker.fire_event(e, '#journal-reports-tab');
});
swift_event_tracker.register_swift_event('#journal-graphs-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-graphs-tab', function(e) {
  swift_event_tracker.fire_event(e, '#journal-graphs-tab');
});
swift_event_tracker.register_swift_event('#journal-configuration-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-configuration-tab', function(e) {
  swift_event_tracker.fire_event(e, '#journal-configuration-tab');
});
