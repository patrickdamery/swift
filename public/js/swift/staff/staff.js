/*
  Staff Object.
*/
function Staff() {
  code = '';
  branch = 'all';
  offset = 1;
  edit_code = '';
  edit_value = '';
}

Staff.prototype = {
  constructor: Staff,
  search_staff: function(e) {
    offset = 1;
    this.search(e);
  },
  search: function(e) {
    swift_utils.busy(e.target);
    code = $('#staff-view-code').val();
    branch = $('#staff-branch').val();
    var request = $.post('/swift/staff/search', { code: code,
      branch: branch, offset: offset, _token: swift_utils.swift_token() });
    request.done(function(view) {
      swift_utils.free(e.target);
      $('#staff-table').empty();
      $('#staff-table').append(view);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  staff_paginate: function(e) {
    offset = $(e.target).attr('id').split('-')[2];
    this.search(e);
  },
  edit_name: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');

    edit_code = row.attr('id').split('-')[1];
    edit_value = cell.text();

    cell.replaceWith('<td><input type="text" class="staff-change-name" value="'+edit_value+'"></td>')
    $('.staff-change-name').focus();
  },
  change_name: function(e) {
    // Get new value.
    var value = $(e.target).val();
    if(value == edit_value) {
      $(e.target).parent('td')
        .replaceWith('<td class="staff-name-edit">'+edit_value+'</td>');
      return;
    }
    var staff_ref = this;
    var request = $.post('/swift/staff/change_name', { code: code, value: value, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $(e.target).parent('td')
        .replaceWith('<td class="staff-name-edit">'+value+'</td>');
      swift_utils.display_success(data.message);
      staff_ref.search(e);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  edit_id: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');

    edit_code = row.attr('id').split('-')[1];
    edit_value = cell.text();

    cell.replaceWith('<td><input type="text" class="staff-change-id" value="'+edit_value+'"></td>')
    $('.staff-change-id').focus();
  },
  change_id: function(e) {

  },
  edit_phone: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');

    edit_code = row.attr('id').split('-')[1];
    edit_value = cell.text();

    cell.replaceWith('<td><input type="text" class="staff-change-phone" value="'+edit_value+'"></td>')
    $('.staff-change-phone').focus();
  },
  change_phone: function(e) {

  },
  edit_state: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');

    edit_code = row.attr('id').split('-')[1];
    edit_value = cell.text();

    cell.replaceWith('<td><select class="staff-change-state">'
      +'<option value="1">'+swift_language.get_sentence('active')+'</option>'
      +'<option value="2">'+swift_language.get_sentence('unactive')+'</option>'
      +'</td>')
    $('.staff-change-state').focus();
  },
  change_state: function(e) {

  },
  create: function(e) {
    swift_utils.busy(e.target);
    var name = $('#create-worker-name').val();
    var id = $('#create-worker-id').val();
    var job_title = $('#create-worker-job-title').val();
    var phone = $('#create-worker-phone').val();
    var branch = $('#create-worker-branch').val();
    var staff_ref = this;
    var request = $.post('/swift/staff/create', { name: name, id: id,
      job_title: job_title, phone: phone, branch: branch, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $('#create-worker-name').val('');
      $('#create-worker-id').val('');
      $('#create-worker-job-title').val('');
      $('#create-worker-phone').val('');
      $('#create-worker-phone').val('');
      $('#create-worker').modal('hide');
      swift_utils.display_success(data.message);
      staff_ref.search(e);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  print: function(e) {

  },
  create_user: function(e) {

  },
  edit_user: function(e) {

  },
}

var staff_js = new Staff();

// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '.staff-state-edit',
  'click',
  staff_js,
  'edit_state');

$(document).on('click', '.staff-state-edit', function(e) {
  swift_event_tracker.fire_event(e, '.staff-state-edit');
});

swift_event_tracker.register_swift_event(
  '.staff-change-state',
  'focusout',
  staff_js,
  'change_state');

$(document).on('focusout', '.staff-change-state', function(e) {
  swift_event_tracker.fire_event(e, '.staff-change-state');
});

swift_event_tracker.register_swift_event(
  '.staff-job-edit',
  'click',
  staff_js,
  'edit_job');

$(document).on('click', '.staff-job-edit', function(e) {
  swift_event_tracker.fire_event(e, '.staff-job-edit');
});

swift_event_tracker.register_swift_event(
  '.staff-change-job',
  'focusout',
  staff_js,
  'change_job');

$(document).on('focusout', '.staff-change-job', function(e) {
  swift_event_tracker.fire_event(e, '.staff-change-job');
});

swift_event_tracker.register_swift_event(
  '.staff-phone-edit',
  'click',
  staff_js,
  'edit_phone');

$(document).on('click', '.staff-phone-edit', function(e) {
  swift_event_tracker.fire_event(e, '.staff-phone-edit');
});

swift_event_tracker.register_swift_event(
  '.staff-change-phone',
  'focusout',
  staff_js,
  'change_phone');

$(document).on('focusout', '.staff-change-phone', function(e) {
  swift_event_tracker.fire_event(e, '.staff-change-phone');
});

swift_event_tracker.register_swift_event(
  '.staff-id-edit',
  'click',
  staff_js,
  'edit_id');

$(document).on('click', '.staff-id-edit', function(e) {
  swift_event_tracker.fire_event(e, '.staff-id-edit');
});

swift_event_tracker.register_swift_event(
  '.staff-change-id',
  'focusout',
  staff_js,
  'change_id');

$(document).on('focusout', '.staff-change-id', function(e) {
  swift_event_tracker.fire_event(e, '.staff-change-id');
});

swift_event_tracker.register_swift_event(
  '.staff-name-edit',
  'click',
  staff_js,
  'edit_name');

$(document).on('click', '.staff-name-edit', function(e) {
  swift_event_tracker.fire_event(e, '.staff-name-edit');
});

swift_event_tracker.register_swift_event(
  '.staff-change-name',
  'focusout',
  staff_js,
  'change_name');

$(document).on('focusout', '.staff-change-name', function(e) {
  swift_event_tracker.fire_event(e, '.staff-change-name');
});

swift_event_tracker.register_swift_event(
  '#staff-view-code',
  'change',
  staff_js,
  'search_staff');

$(document).on('change', '#staff-view-code', function(e) {
  swift_event_tracker.fire_event(e, '#staff-view-code');
});

swift_event_tracker.register_swift_event(
  '#staff-branch',
  'change',
  staff_js,
  'search_staff');

$(document).on('change', '#staff-branch', function(e) {
  swift_event_tracker.fire_event(e, '#staff-branch');
});

swift_event_tracker.register_swift_event(
  '#create-worker-create',
  'click',
  staff_js,
  'create');

$(document).on('click', '#create-worker-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-worker-create');
});

swift_event_tracker.register_swift_event(
  '.staff-pagination > li > a',
  'click',
  staff_js,
  'staff_paginate');

$(document).on('click', '.staff-pagination > li > a', function(e) {
  e.preventDefault();
  swift_event_tracker.fire_event(e, '.staff-pagination > li > a');
});

$(document).on('focus', '#staff-view-code', function(e) {
  if(!$(this).data('autocomplete')) {
    $(this).autocomplete({
      // Get the suggestions.
      source: function (request, response) {
        $.post('/swift/staff/suggest_staff',
        { code: request.term,
          branch: $('#staff-branch').val(),
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
