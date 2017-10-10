function Journal() {
  entry_offset = 1;
  entries = [];
  report_variables = {};
  report_layouts = [];
  report_row = null;
  create_report = true;
  report_code = '';
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
  show_create_report: function() {
    create_report = true;
    $('#journal-create-report').removeClass('hide');
    $('.showable').addClass('hide');
    report_variables = {};
    report_layouts = [];
    $('#journal-create-report-variables').empty();
    $('#journal-create-report-variable').val('');
    $('#journal-create-report-content').val('');
    $('#journal-create-report-title').val('');
    $('#report-layout').empty();
    $('#create-report-title').html(swift_language.get_sentence('create_report'));
    $('#journal-create-report-create').html(swift_language.get_sentence('create_report_button'));
  },
  add_variable: function(e) {
    // TODO: Revise this method, it can probably be optimized.
    var name = $('#journal-create-report-variable').val();
    if(name == '') {
      swift_utils.display_error(swift_language.get_sentence('no_variable_name'));
      return;
    }
    if(name == 'periodo') {
      swift_utils.display_error(swift_language.get_sentence('reserved_period'));
      return;
    }
    var cont = $('#journal-create-report-content').val();

    // Make sure we start with a calc.
    var journal_ref = this;
    var calc_check = cont.search('calc');
    if(calc_check != 0) {
      swift_utils.display_error(swift_language.get_sentence('must_start_calc'));
      return false;
    }

    // Make sure parenthesis match.
    var parenthesis = cont.match(new RegExp('.*?(?:\\(|\\)).*?', 'g'));
    var count = parenthesis ? parenthesis.length : 0;
    if((count % 2) != 0) {
      swift_utils.display_error(swift_language.get_sentence('malformed_function'));
      return false;
    }

    // Make sure curly brackets match.
    var curly_brackets = cont.match(new RegExp('.*?(?:\\{|\\}).*?', 'g'));
    var count = curly_brackets ? curly_brackets.length : 0;
    if((count % 2) != 0) {
      swift_utils.display_error(swift_language.get_sentence('malformed_object'));
      return false;
    }

    // Check calc contents.
    var content_start = 5;
    var content_parts = cont.slice(content_start).split('');
    var parenthesis = 1;
    var end = 0;
    $.each(content_parts, function(key, data) {
      if(parenthesis != 0) {
        end++;
        if(data == '(') {
          parenthesis += 1;
        } else if(data == ')') {
          parenthesis -= 1;
        }
      }
    });

    // Get Calc function contents.
    var content_end = content_start+end-1;
    var calc_content = cont.slice(content_start, content_end);
    var content_entries = calc_content.split(new RegExp('((?:\\+|\\-)|(?:\\*|\\/)).*?', 'g'));

    // Check that function calls are correct.
    var rep_functions = ['variable', 'variacion', 'debito', 'credito', 'balance'];
    var rep_operations = ['+', '-', '*', '/'];
    var count = 0;
    var check_accounts = [];
    var good = true;
    $.each(content_entries, function(key, data) {
      if((count % 2) == 0) {
        // Get entry parts.
        entry_parts = data.split(new RegExp('(?:\\(|\\)).*?', 'g'));

        // Make sure function exists.
        if(!rep_functions.includes(entry_parts[0])) {
          swift_utils.display_error(swift_language.get_sentence('unrecognized_function')+entry_parts[0]);
          good = false;
        }

        // Make sure JSON object is valid.
        if(entry_parts[0] == 'variable') {
          if(entry_parts[1] == 'periodo') {
            swift_utils.display_error(swift_language.get_sentence('calc_period'));
            good = false;
          }
          if(!report_variables.hasOwnProperty(entry_parts[1]) && good) {
            swift_utils.display_error(swift_language.get_sentence('unexistent_variable')+entry_parts[1]);
            good = false;
          }
        } else {
          // Make sure object is formatted correctly.
          try{
            var json = JSON.parse(entry_parts[1]);
            if(json.hasOwnProperty('tipo')) {
              var tipos = ['activo', 'gasto', 'costo', 'pasivo', 'patrimonio', 'ingresos'];

              if(!tipos.includes(json['tipo'])) {
                swift_utils.display_error(swift_language.get_sentence('unrecognized_type')+json['tipo']);
                good = false;
              }
            } else if(json.hasOwnProperty('codigo')) {
              check_accounts.push(json['codigo']);
            } else {
              swift_utils.display_error(swift_language.get_sentence('object_malformed')+entry_parts[1]);
              good = false;
            }
          } catch(e) {
            swift_utils.display_error(swift_language.get_sentence('object_malformed')+entry_parts[1]);
            good = false;
          }
        }
      } else {
        // Get operation.
        if(!rep_operations.includes(data)) {
          swift_utils.display_error(swift_language.get_sentence('unrecognized_operation')+data);
          good = false;
        }
      }
      count++;
    });

    var group_by = cont.slice((content_end+2));
    var group_parts = group_by.split(new RegExp('(?:\\(|\\)).*?', 'g'));
    var group_options = ['resumen', 'dia', 'semana', 'mes', 'año'];

    if(!group_options.includes(group_options[1])) {
      swift_utils.display_error(swift_language.get_sentence('unrecognized_group'));
      good = false;
    }

    if(!good) {
      return;
    }

    if(check_accounts.length > 0) {
      swift_utils.busy(e.target);
      var request = $.post('/swift/accounting/check_account_code', { code: check_accounts, _token: swift_utils.swift_token() });
      request.done(function(data) {
        swift_utils.free(e.target);
        if(data.state != 'Success') {
          journal_ref.remove_variable(name);
          swift_utils.display_error(data.error);
          return;
        }

        journal_ref.create_variable(name, cont);
        journal_ref.show_available_variables();
      });
      request.fail(function(ev) {
        swift_utils.free(e.target);
        swift_utils.ajax_fail(ev);
      });
    } else {
      journal_ref.create_variable(name, cont);
      journal_ref.show_available_variables();
    }
  },
  create_variable: function(name, cont) {
    var content_start = 5;
    var content_parts = cont.slice(content_start).split('');
    var parenthesis = 1;
    var end = 0;
    $.each(content_parts, function(key, data) {
      if(parenthesis != 0) {
        end++;
        if(data == '(') {
          parenthesis += 1;
        } else if(data == ')') {
          parenthesis -= 1;
        }
      }
    });

    // Get Calc function contents.
    var content_end = content_start+end-1;
    var calc_content = cont.slice(content_start, content_end);
    var content_entries = calc_content.split(new RegExp('((?:\\+|\\-)|(?:\\*|\\/)).*?', 'g'));
    var group_by = cont.slice((content_end+2));

    // Save variable.
    report_variables[name] = {
      'calc': content_entries,
      'group_by': group_by
    };
    $('#journal-create-report-variable').val('');
    $('#journal-create-report-content').val('');
  },
  remove_variable: function(name) {
    // Check if there is any other variable that is dependent on this variable.
    var journal_ref = this;
    $.each(report_variables, function(key, data) {
      var count = 0;
      $.each(data['calc'], function(k, d) {
        if((count % 2) == 0) {
          entry_parts = d.split(new RegExp('(?:\\(|\\)).*?', 'g'));
          if(entry_parts[0] == 'variable' && entry_parts[1] == name) {
            journal_ref.remove_variable(key);
          }
        }
        count++;
      });
    });
    delete report_variables[name];
  },
  delete_variable: function(e) {
    var name = $(e.target).closest('.variable-group').attr('id').split('-')[1];
    this.remove_variable(name);
    this.show_available_variables();
  },
  show_available_variables: function() {
    $('#journal-create-report-variables').empty();
    $.each(report_variables, function(key, data){
      var variable = $([
          '<div class="row variable-group" id="variable-'+key+'">',
            '<div class="col-xs-9">',
              '<p class="variable-padding">',
                key,
              '</p>',
            '</div>',
            '<div class="col-xs-1">',
              '<button class="btn btn-info">',
                '<i class="fa fa-search"></i>',
              '</button>',
            '</div>',
            '<div class="col-xs-1">',
              '<button class="btn btn-danger">',
                '<i class="fa fa-trash"></i>',
              '</button>',
            '</div>',
          '</div>'].join("\n"));
      $('#journal-create-report-variables').append(variable);
    });
  },
  show_variable: function(e) {
    var name = $(e.target).closest('.variable-group').attr('id').split('-')[1];
    var content = 'calc(';
    $.each(report_variables[name]['calc'], function(key, data){
      content += data;
    });
    content += ').'+report_variables[name]['group_by'];

    $('#journal-create-report-variable').val(name);
    $('#journal-create-report-content').val(content);
  },
  show_add_row: function(e) {
    report_row = e.trigger[0].id.split('-');
    if(report_row.length > 3) {
      swift_utils.display_error(swift_language.get_sentence('max_sub_row'));
      return;
    }
    $('#create-report-row-columns').val('');
    $('#create-report-row').modal('show');
    $('#create-report-row-columns').focus();
  },
  create_report_row: function(e) {
    var columns = $('#create-report-row-columns').val();
    if(columns == '' || !$.isNumeric(columns) || columns > 4) {
      swift_utils.display_error(swift_language.get_sentence('blank_columns'));
      return;
    }

    var cols = [];
    for(var i = 0; i < columns; i++) {
      cols.push('');
    }
    if(report_row[0] == 'report') {
      report_layouts.push({
        'columns': cols
      });
    } else {
      report_layouts[report_row[1]]['columns'][report_row[2]] = cols;
    }

    $('#create-report-row').modal('hide');

    this.show_layout();
  },
  show_layout: function() {
    $('#report-layout').empty();
    $.each(report_layouts, function(key, data) {
      var row = [];
      row.push('<div class="report-row" id="row-'+key+'">');
        $.each(data['columns'], function(i, cols) {
          row.push('<div class="w-'+data['columns'].length+'">');
          if(Array.isArray(cols)) {
            $.each(cols, function(sub_i, sub_cols){
              row.push('<div class="report-row">');
              row.push('<input class="w-i" id="col-'+key+'-'+i+'-'+sub_i+'" type="text" value="'+sub_cols+'">');
              row.push('</div>');
            });
          } else {
            row.push('<input class="w-i" id="col-'+key+'-'+i+'" type="text" value="'+cols+'">');
          }
          row.push('</div>');
        });
      row.push('</div>');
      row = row.join("\n");
      $('#report-layout').append(row);
    });
  },
  update_row_data: function(e) {
    var data = $(e.target).val();
    var row = $(e.target).attr('id').split('-');
    if(row.length == 3) {
      report_layouts[row[1]]['columns'][row[2]] = data;
    } else {
      report_layouts[row[1]]['columns'][row[2]][row[3]] = data;
    }

    this.show_layout();
  },
  create_report: function(e) {
    var name = $('#journal-create-report-title').val();
    if(create_report) {
      var journal_ref = this;
      var request = $.post('/swift/accounting/create_report', { name: name,
        variables: report_variables, layout: report_layouts, _token: swift_utils.swift_token() });
      request.done(function(data) {
        swift_utils.free(e.target);
        if(data.state != 'Success') {
          swift_utils.display_error(data.error);
          return;
        }
        swift_utils.display_success(data.message);
        $('#journal-create-report').addClass('hide');
        $('.showable').removeClass('hide');
      });
      request.fail(function(ev) {
        swift_utils.free(e.target);
        swift_utils.ajax_fail(ev);
      });
    } else {
      var journal_ref = this;
      var request = $.post('/swift/accounting/edit_report', { report: report_code, name: name,
        variables: report_variables, layout: report_layouts, _token: swift_utils.swift_token() });
      request.done(function(data) {
        swift_utils.free(e.target);
        if(data.state != 'Success') {
          swift_utils.display_error(data.error);
          return;
        }
        swift_utils.display_success(data.message);
        $('#journal-create-report').addClass('hide');
        $('.showable').removeClass('hide');
      });
      request.fail(function(ev) {
        swift_utils.free(e.target);
        swift_utils.ajax_fail(ev);
      });
    }
  },
  edit_report: function(e) {
    var report = $('#journal-reports-report').val();
    var journal_ref = this;
    var request = $.post('/swift/accounting/load_report', { report: report, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $('#journal-create-report-title').val(data.report.name);
      report_variables = data.report.variables;
      report_layouts = data.report.layout;
      create_report = false;
      report_code = data.report.id;
      journal_ref.show_available_variables();
      journal_ref.show_layout();

      $('#create-report-title').html(swift_language.get_sentence('edit_report'));
      $('#journal-create-report-create').html(swift_language.get_sentence('edit_report_button'));
      $('#journal-create-report').removeClass('hide');
      $('.showable').addClass('hide');
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  generate_report: function(e) {
    var report = $('#journal-reports-report').val();
    var date_range = $('#journal-reports-date-range').val();
    var request = $.post('/swift/accounting/generate_report', { report: report,
      date_range: date_range, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }

    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  print_report: function(e) {
    var report = $('#journal-reports-report').val();
    var date_range = $('#journal-reports-date-range').val();
    var request = $.post('/swift/accounting/print_report', { report: report,
      date_range: date_range, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }

    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  download_report: function(e) {
    var report = $('#journal-reports-report').val();
    var date_range = $('#journal-reports-date-range').val();
    var report_data = {
      'report': report,
      'date_range': date_range
    }
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host
    window.open(baseUrl+'/swift/accounting/download_report?report_data='+JSON.stringify(report_data), '_blank')
  },
}

var journal_js = new Journal();

// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '#journal-reports-edit',
  'click',
  journal_js,
  'edit_report');

$(document).on('click', '#journal-reports-edit', function(e) {
  swift_event_tracker.fire_event(e, '#journal-reports-edit');
});

swift_event_tracker.register_swift_event(
  '#journal-reports-download',
  'click',
  journal_js,
  'download_report');

$(document).on('click', '#journal-reports-download', function(e) {
  swift_event_tracker.fire_event(e, '#journal-reports-download');
});

swift_event_tracker.register_swift_event(
  '#journal-reports-print',
  'click',
  journal_js,
  'print_report');

$(document).on('click', '#journal-reports-print', function(e) {
  swift_event_tracker.fire_event(e, '#journal-reports-print');
});

swift_event_tracker.register_swift_event(
  '#journal-reports-generate',
  'click',
  journal_js,
  'generate_report');

$(document).on('click', '#journal-reports-generate', function(e) {
  swift_event_tracker.fire_event(e, '#journal-reports-generate');
});

swift_event_tracker.register_swift_event(
  '#journal-create-report-create',
  'click',
  journal_js,
  'create_report');

$(document).on('click', '#journal-create-report-create', function(e) {
  swift_event_tracker.fire_event(e, '#journal-create-report-create');
});

swift_event_tracker.register_swift_event(
  '.w-i',
  'change',
  journal_js,
  'update_row_data');

$(document).on('change', '.w-i', function(e) {
  swift_event_tracker.fire_event(e, '.w-i');
});

swift_event_tracker.register_swift_event(
  '.variable-group > div > .btn-info',
  'click',
  journal_js,
  'show_variable');

$(document).on('click', '.variable-group > div > .btn-info', function(e) {
  swift_event_tracker.fire_event(e, '.variable-group > div > .btn-info');
});

swift_event_tracker.register_swift_event(
  '#create-report-row-create',
  'click',
  journal_js,
  'create_report_row');

$(document).on('click', '#create-report-row-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-report-row-create');
});

swift_event_tracker.register_swift_event(
  '.variable-group > div > .btn-danger',
  'click',
  journal_js,
  'delete_variable');

$(document).on('click', '.variable-group > div > .btn-danger', function(e) {
  swift_event_tracker.fire_event(e, '.variable-group > div > .btn-danger');
});

swift_event_tracker.register_swift_event(
  '#journal-create-report-add',
  'click',
  journal_js,
  'add_variable');

$(document).on('click', '#journal-create-report-add', function(e) {
  swift_event_tracker.fire_event(e, '#journal-create-report-add');
});

swift_event_tracker.register_swift_event(
  '#journal-reports-create',
  'click',
  journal_js,
  'show_create_report');

$(document).on('click', '#journal-reports-create', function(e) {
  swift_event_tracker.fire_event(e, '#journal-reports-create');
});

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

$(function() {
  $.contextMenu({
    selector: '.w-i',
    callback: function(key, options) {
      if(key == 'add') {
        var e = { 'type': 'context_option', 'trigger': options.$trigger};
        swift_event_tracker.fire_event(e, '.add-row');
      } else if(key == 'remove') {
        var e = { 'type': 'context_option', 'trigger': options.$trigger};
        swift_event_tracker.fire_event(e, '.remove-row');
      }
    },
    items: {
      'add': {name: swift_language.get_sentence('add_sub_row'), icon: 'fa-plus'},
      'remove': {name: swift_language.get_sentence('remove_row'), icon: 'fa-trash'}
    }
  });
  $.contextMenu({
    selector: '#report-layout',
    callback: function(key, options) {
      if(key == 'add') {
        var e = { 'type': 'context_option', 'trigger': options.$trigger};
        swift_event_tracker.fire_event(e, '.add-row');
      } else if(key == 'remove') {
        var e = { 'type': 'context_option', 'trigger': options.$trigger};
        swift_event_tracker.fire_event(e, '.remove-row');
      }
    },
    items: {
      'add': {name: swift_language.get_sentence('add_row'), icon: 'fa-plus'},
    }
  });
});

swift_event_tracker.register_swift_event(
  '.add-row',
  'context_option',
  journal_js,
  'show_add_row');

swift_event_tracker.register_swift_event(
  '.remove-row',
  'context_option',
  journal_js,
  'remove_row');



swift_event_tracker.register_swift_event('#journal-view-entries-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-view-entries-tab', function(e) {
  $('.hideable').addClass('hide');
  $('.showable').removeClass('hide');
  swift_event_tracker.fire_event(e, '#journal-view-entries-tab');
});
swift_event_tracker.register_swift_event('#journal-reports-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-reports-tab', function(e) {
  $('.hideable').addClass('hide');
  $('.showable').removeClass('hide');
  swift_event_tracker.fire_event(e, '#journal-reports-tab');
});
swift_event_tracker.register_swift_event('#journal-graphs-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-graphs-tab', function(e) {
  $('.hideable').addClass('hide');
  $('.showable').removeClass('hide');
  swift_event_tracker.fire_event(e, '#journal-graphs-tab');
});
swift_event_tracker.register_swift_event('#journal-configuration-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-configuration-tab', function(e) {
  $('.hideable').addClass('hide');
  $('.showable').removeClass('hide');
  swift_event_tracker.fire_event(e, '#journal-configuration-tab');
});
