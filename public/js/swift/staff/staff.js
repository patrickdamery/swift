/*
  Staff Object.
*/
function Staff() {
  code = '';
  branch = 'all';
  offset = 1;
  edit_code = '';
  edit_value = '';
  user_action = '';
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
    var request = $.post('/swift/staff/change_name', { code: edit_code, value: value, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $(e.target).parent('td')
        .replaceWith('<td class="staff-name-edit">'+value+'</td>');
      swift_utils.display_success(data.message);
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
    // Get new value.
    var value = $(e.target).val();
    if(value == edit_value) {
      $(e.target).parent('td')
        .replaceWith('<td class="staff-id-edit">'+edit_value+'</td>');
      return;
    }
    var staff_ref = this;
    var request = $.post('/swift/staff/change_id', { code: edit_code, value: value, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $(e.target).parent('td')
        .replaceWith('<td class="staff-id-edit">'+value+'</td>');
      swift_utils.display_success(data.message);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
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
    // Get new value.
    var value = $(e.target).val();
    if(value == edit_value) {
      $(e.target).parent('td')
        .replaceWith('<td class="staff-phone-edit">'+edit_value+'</td>');
      return;
    }
    var staff_ref = this;
    var request = $.post('/swift/staff/change_phone', { code: edit_code, value: value, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $(e.target).parent('td')
        .replaceWith('<td class="staff-phone-edit">'+value+'</td>');
      swift_utils.display_success(data.message);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  edit_job: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');

    edit_code = row.attr('id').split('-')[1];
    edit_value = cell.text();

    cell.replaceWith('<td><input type="text" class="staff-change-job" value="'+edit_value+'"></td>')
    $('.staff-change-job').focus();
  },
  change_job: function(e) {
    // Get new value.
    var value = $(e.target).val();
    if(value == edit_value) {
      $(e.target).parent('td')
        .replaceWith('<td class="staff-job-edit">'+edit_value+'</td>');
      return;
    }
    var staff_ref = this;
    var request = $.post('/swift/staff/change_job', { code: edit_code, value: value, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $(e.target).parent('td')
        .replaceWith('<td class="staff-job-edit">'+value+'</td>');
      swift_utils.display_success(data.message);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  edit_address: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');

    edit_code = row.attr('id').split('-')[1];
    edit_value = cell.text();

    cell.replaceWith('<td><input type="text" class="staff-change-address" value="'+edit_value+'"></td>')
    $('.staff-change-address').focus();
  },
  change_address: function(e) {
    // Get new value.
    var value = $(e.target).val();
    if(value == edit_value) {
      $(e.target).parent('td')
        .replaceWith('<td class="staff-address-edit">'+edit_value+'</td>');
      return;
    }
    var staff_ref = this;
    var request = $.post('/swift/staff/change_address', { code: edit_code, value: value, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $(e.target).parent('td')
        .replaceWith('<td class="staff-address-edit">'+value+'</td>');
      swift_utils.display_success(data.message);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  edit_inss: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');

    edit_code = row.attr('id').split('-')[1];
    edit_value = cell.text();

    cell.replaceWith('<td><input type="text" class="staff-change-inss" value="'+edit_value+'"></td>')
    $('.staff-change-inss').focus();
  },
  change_inss: function(e) {
    // Get new value.
    var value = $(e.target).val();
    if(value == edit_value) {
      $(e.target).parent('td')
        .replaceWith('<td class="staff-inss-edit">'+edit_value+'</td>');
      return;
    }
    var staff_ref = this;
    var request = $.post('/swift/staff/change_inss', { code: edit_code, value: value, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $(e.target).parent('td')
        .replaceWith('<td class="staff-inss-edit">'+value+'</td>');
      swift_utils.display_success(data.message);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  edit_state: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');

    edit_code = row.attr('id').split('-')[1];
    edit_value = cell.text();

    cell.replaceWith('<td><select class="form-control staff-change-state">'
      +'<option value="1">'+swift_language.get_sentence('active')+'</option>'
      +'<option value="2">'+swift_language.get_sentence('unactive')+'</option>'
      +'</td>')
    $('.staff-change-state').focus();
  },
  change_state: function(e) {
    // Get new value.
    var value = $(e.target).val();
    if(value == edit_value) {
      $(e.target).parent('td')
        .replaceWith('<td class="staff-state-edit">'+edit_value+'</td>');
      return;
    }
    var staff_ref = this;
    var request = $.post('/swift/staff/change_state', { code: edit_code, value: value, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $(e.target).parent('td')
        .replaceWith('<td class="staff-state-edit">'+value+'</td>');
      swift_utils.display_success(data.message);
      staff_ref.search(e);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  edit_configuration: function(e) {
    var cell = $(e.target);
    var row = $(e.target).parent('tr');

    edit_code = row.attr('id').split('-')[1];
    edit_value = cell.text();

    var request = $.post('/swift/staff/load_configurations', { _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      var select = '<td><select class="form-control staff-change-configuration">';
      $.each(data.configs, function(key, info) {
          if(info.name == edit_value) {
            select += '<option value="'+info.id+'" selected>'+info.name+'</option>';
          } else {
            select += '<option value="'+info.id+'">'+info.name+'</option>';
          }
      });
      select += '</td>';
      cell.replaceWith(select);
      $('.staff-change-state').focus();
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  change_configuration: function(e) {
    // Get new value.
    var value = $(e.target).val();
    if(value == edit_value) {
      $(e.target).parent('td')
        .replaceWith('<td class="staff-configuration-edit">'+edit_value+'</td>');
      return;
    }
    var staff_ref = this;
    var request = $.post('/swift/staff/change_configuration', { code: edit_code, value: value, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $(e.target).parent('td')
        .replaceWith('<td class="staff-configuration-edit">'+value+'</td>');
      swift_utils.display_success(data.message);
      staff_ref.search(e);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  create: function(e) {
    swift_utils.busy(e.target);
    var name = $('#create-worker-name').val();
    var id = $('#create-worker-id').val();
    var job_title = $('#create-worker-job-title').val();
    var phone = $('#create-worker-phone').val();
    var address = $('#create-worker-address').val();
    var inss = $('#create-worker-inss').val();
    var config = $('#create-worker-configuration').val();
    var branch = $('#create-worker-branch').val();
    var staff_ref = this;
    var request = $.post('/swift/staff/create', { name: name, id: id,
      job_title: job_title, phone: phone, address: address, inss: inss,
      config: config, branch: branch, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.free(e.target);
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
    swift_utils.busy(e.target);
    var request = $.post('/swift/staff/print_staff', { code: code, branch: branch,
       _token: swift_utils.swift_token() });
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
  clear_create_user: function(e) {
    var row = $(e.target).parent('td').parent('tr');
    edit_code = row.attr('id').split('-')[1];
    user_action = 'create';
    $('#worker-user-update').html(swift_language.get_sentence('create'));
    $('#worker-user-username').val('');
    $('#worker-user-email').val('');
  },
  execute_user_action: function(e) {
    swift_utils.busy(e.target);
    var username = $('#worker-user-username').val();
    var email = $('#worker-user-email').val();
    var password = $('#worker-user-password').val();
    if (password.length < 6 && user_action == 'create') {
      swift_utils.free(e.target);
      swift_utils.display_error(swift_language.get_sentence('short_pasword'));
      return;
    }
    var staff_ref = this;

    if(user_action == 'create') {
      var request = $.post('/swift/staff/create_user', { code: edit_code, username: username,
        email: email, password: password, _token: swift_utils.swift_token() });
    } else {
      var request = $.post('/swift/staff/edit_user', { code: edit_code, username: username,
        email: email, password: password, _token: swift_utils.swift_token() });
    }
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      swift_utils.display_success(data.message);
      $('#worker-user').modal('hide');
      staff_ref.search(e);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  show_edit_user: function(e) {
    var row = $(e.target).parent('td').parent('tr');
    edit_code = row.attr('id').split('-')[1];
    user_action = 'edit';
    $('#worker-user-update').html(swift_language.get_sentence('update'));

    var request = $.post('/swift/staff/get_user', { code: edit_code, _token: swift_utils.swift_token() });
    request.done(function(data) {
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $('#worker-user-username').val(data.user.username);
      $('#worker-user-email').val(data.user.email);
      $('#worker-user').modal('show');
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
}

var staff_js = new Staff();

// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '.staff-address-edit',
  'click',
  staff_js,
  'edit_address');

$(document).on('click', '.staff-address-edit', function(e) {
  swift_event_tracker.fire_event(e, '.staff-address-edit');
});

swift_event_tracker.register_swift_event(
  '.staff-change-address',
  'focusout',
  staff_js,
  'change_address');

$(document).on('focusout', '.staff-change-address', function(e) {
  swift_event_tracker.fire_event(e, '.staff-change-address');
});

swift_event_tracker.register_swift_event(
  '.staff-inss-edit',
  'click',
  staff_js,
  'edit_inss');

$(document).on('click', '.staff-inss-edit', function(e) {
  swift_event_tracker.fire_event(e, '.staff-inss-edit');
});

swift_event_tracker.register_swift_event(
  '.staff-change-inss',
  'focusout',
  staff_js,
  'change_inss');

$(document).on('focusout', '.staff-change-inss', function(e) {
  swift_event_tracker.fire_event(e, '.staff-change-inss');
});

swift_event_tracker.register_swift_event(
  '.staff-configuration-edit',
  'click',
  staff_js,
  'edit_configuration');

$(document).on('click', '.staff-configuration-edit', function(e) {
  swift_event_tracker.fire_event(e, '.staff-configuration-edit');
});

swift_event_tracker.register_swift_event(
  '.staff-change-configuration',
  'focusout',
  staff_js,
  'change_configuration');

$(document).on('focusout', '.staff-change-configuration', function(e) {
  swift_event_tracker.fire_event(e, '.staff-change-configuration');
});

swift_event_tracker.register_swift_event(
  '#staff-print',
  'click',
  staff_js,
  'print');

$(document).on('click', '#staff-print', function(e) {
  swift_event_tracker.fire_event(e, '#staff-print');
});

swift_event_tracker.register_swift_event(
  '#worker-user-update',
  'click',
  staff_js,
  'execute_user_action');

$(document).on('click', '#worker-user-update', function(e) {
  swift_event_tracker.fire_event(e, '#worker-user-update');
});

swift_event_tracker.register_swift_event(
  '.create-user',
  'click',
  staff_js,
  'clear_create_user');

$(document).on('click', '.create-user', function(e) {
  swift_event_tracker.fire_event(e, '.create-user');
});

swift_event_tracker.register_swift_event(
  '.edit-user',
  'click',
  staff_js,
  'show_edit_user');

$(document).on('click', '.edit-user', function(e) {
  swift_event_tracker.fire_event(e, '.edit-user');
});

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
