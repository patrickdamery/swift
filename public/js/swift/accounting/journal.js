function Journal() {
  entry_offset = 1;
  entries = [];
  report_variables = {};
  report_layouts = [];
  report_row = null;
  create_report = true;
  report_code = '';
  create_graph = true;
  graph_variables = {};
  graph_colors = {};
  graphed_variables = [];
  graph_code = '';
  it_rules = [];
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
      swift_utils.displaGraficoy_error(swift_language.get_sentence('blank_amount'));
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
    var rep_functions = ['balance_inicial', 'balance_final', 'variable', 'variacion', 'debito', 'credito', 'balance'];
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

    /*var group_by = cont.slice((content_end+2));
    var group_parts = group_by.split(new RegExp('(?:\\(|\\)).*?', 'g'));
    var group_options = ['resumen', 'dia', 'semana', 'mes', 'año'];

    if(!group_options.includes(group_options[1])) {
      swift_utils.display_error(swift_language.get_sentence('unrecognized_group'));
      good = false;
    }*/

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
      //'group_by': group_by
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
            '<div class="col-xs-7 col-lg-8">',
              '<p class="variable-padding">',
                key,
              '</p>',
            '</div>',
            '<div class="col-xs-2 col-lg-1">',
              '<button class="btn btn-info">',
                '<i class="fa fa-search"></i>',
              '</button>',
            '</div>',
            '<div class="col-xs-1 col-lg-1">',
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
    content += ')';
    //content += ').'+report_variables[name]['group_by'];

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
    var group_by = $('#journal-create-report-group').val();
    if(create_report) {
      var journal_ref = this;
      var request = $.post('/swift/accounting/create_report', { name: name,
        variables: report_variables, layout: report_layouts, group_by: group_by,
         _token: swift_utils.swift_token() });
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
        variables: report_variables, layout: report_layouts, group_by: group_by,
         _token: swift_utils.swift_token() });
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
      $('#journal-create-report-variable').val('');
      $('#journal-create-report-content').val('');
      $('#journal-create-report-group').val(data.report.group_by);
      $('#journal-create-report').removeClass('hide');
      $('.showable').addClass('hide');
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  generate_report: function(e) {
    swift_utils.busy(e.target);
    var report = $('#journal-reports-report').val();
    var date_range = $('#journal-reports-date-range').val();
    var request = $.post('/swift/accounting/generate_report', { report: report,
      date_range: date_range, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      $('#report-box').empty();
      $('#report-box').append(data);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  print_report: function(e) {
    swift_utils.busy(e.target);
    var report = $('#journal-reports-report').val();
    var date_range = $('#journal-reports-date-range').val();
    var request = $.post('/swift/accounting/print_report', { report: report,
      date_range: date_range, _token: swift_utils.swift_token() });
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
  save_configuration: function(e) {
    var entity_type = $('#journal-configuration-entity-type').val();
    var retained_vat = $('#journal-configuration-retained-vat').val();
    var advanced_vat = $('#journal-configuration-advanced-vat').val();
    var vat_percentage = $('#journal-configuration-vat-percentage').val();
    var fixed_fee = $('#journal-configuration-fixed-fee').val();
    var retained_it = $('#journal-configuration-retained-it').val();
    var advanced_it = $('#journal-configuration-advanced-it').val();
    var it_percentage = $('#journal-configuration-it-percentage').val();
    var isc = $('#journal-configuration-isc').val();

    if(retained_vat == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_retained_vat'));
      return;
    }
    if(advanced_vat == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_advanced_vat'));
      return;
    }
    if(vat_percentage == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_vat_percentage'));
      return;
    }
    if(retained_it == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_retained_it'));
      return;
    }
    if(advanced_it == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_advanced_it'));
      return;
    }
    if(it_percentage == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_it_percentage'));
      return;
    }
    if(isc == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_isc'));
      return;
    }

    var request = $.post('/swift/accounting/save_configuration', { retained_vat: retained_vat,
      advanced_vat: advanced_vat, vat_percentage: vat_percentage,
      retained_it: retained_it, advanced_it: advanced_it, it_percentage: it_percentage,
      isc: isc, entity_type: entity_type, fixed_fee: fixed_fee,
      it_rules: it_rules, _token: swift_utils.swift_token() });
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
  set_it_rules: function(rules) {
    it_rules = rules;
  },
  show_create_graph: function() {
    create_graph = true;
    $('#journal-create-graph').removeClass('hide');
    $('.showable').addClass('hide');
    graph_variables = {};
    $('#journal-create-graph-variables').empty();
    $('#journal-create-graph-variable').val('');
    $('#journal-create-graph-content').val('');
    $('#journal-create-graph-title').val('');
    $('#create-graph-title').html(swift_language.get_sentence('create_graph'));
    $('#journal-create-graph-create').html(swift_language.get_sentence('create_graph_button'));
  },
  change_entity_type: function() {
    var type = $('#journal-configuration-entity-type').val();
    if(type == 'natural') {
      $('#vat-percentage-div').addClass('hide');
      $('#fixed-fee-div').removeClass('hide');
      $('#it-percentage-div').addClass('hide');
      $('#it-rules-div').removeClass('hide');
    } else {
      $('#vat-percentage-div').removeClass('hide');
      $('#fixed-fee-div').addClass('hide');
      $('#it-percentage-div').removeClass('hide');
      $('#it-rules-div').addClass('hide');
    }
  },
  display_it_rules: function() {
    $('#journal-create-it-rules').empty();
    $.each(it_rules, function(key, data) {
      var variable = $([
          '<div class="row journal-config-group" id="journal-config-'+key+'">',
            '<div class="col-xs-10">',
              '<p class="variable-padding">',
                data['start']+' - '+data['end'],
              '</p>',
            '</div>',
            '<div class="col-xs-1">',
              '<button class="btn btn-danger">',
                '<i class="fa fa-trash"></i>',
              '</button>',
            '</div>',
          '</div>'].join("\n"));
      $('#journal-create-it-rules').append(variable);
    });
  },
  create_it_rule: function(e) {
    var start = $('#add-configuration-rule-start').val();
    var end = $('#add-configuration-rule-end').val();
    var percentage = $('#add-configuration-rule-percentage').val();

    it_rules.push({'start':start,'end':end,'percentage':percentage});

    this.display_it_rules();
    $('#add-configuration-rule').modal('hide');
  },
  clear_it_rule_form: function(e) {
    $('#add-configuration-rule-start').val('');
    $('#add-configuration-rule-end').val('');
    $('#add-configuration-rule-percentage').val('');
  },
  delete_rule: function(e) {
    var i = $(e.target).closest('.journal-config-group').attr('id').split('-')[2];
    it_rules.splice(i, 1);
    this.display_it_rules();
  },
  paint_graph: function(setup) {
    // Clear current graph canvas.
    $('#generated-graph').remove();
    $('#generated-graph-container').append('<canvas id="generated-graph"></canvas>');
    var ctx = document.getElementById("generated-graph").getContext('2d');
    new Chart(ctx, setup);
  },
  paint_create_graph: function(setup) {
    $('#graph-layout').remove();
    $('#graph-layout-container').append('<canvas id="graph-layout"></canvas>');
    var ctx = document.getElementById("graph-layout").getContext('2d');
    new Chart(ctx, setup);
  },
  add_graph_variable: function(e) {
    // TODO: Revise this method, it can probably be optimized.
    var name = $('#journal-create-graph-variable').val();
    if(name == '') {
      swift_utils.display_error(swift_language.get_sentence('no_variable_name'));
      return;
    }
    if(name == 'periodo') {
      swift_utils.display_error(swift_language.get_sentence('reserved_period'));
      return;
    }
    var cont = $('#journal-create-graph-content').val();

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
    var rep_functions = ['balance_inicial', 'balance_final', 'variable', 'variacion', 'debito', 'credito', 'balance'];
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
          if(!graph_variables.hasOwnProperty(entry_parts[1]) && good) {
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
      journal_ref.create_graph_variable(name, cont);
      journal_ref.show_graph_available_variables();
    }
  },
  create_graph_variable: function(name, cont) {
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
    graph_variables[name] = {
      'calc': content_entries,
      //'group_by': group_by
    };
    if(!graph_colors.hasOwnProperty(name)) {
      graph_colors[name] = {
        r: 0,
        g: 0,
        b: 0,
      };
    }
    $('#journal-create-graph-variable').val('');
    $('#journal-create-graph-content').val('');
  },
  show_graph_available_variables: function() {
    $('#journal-create-graph-variables').empty();
    $('#journal-create-graph-graphed-variables').empty();
    var journal_ref = this;
    $.each(graph_variables, function(key, data){
      var variable = $([
          '<div class="row graph-variable-group" id="variable-'+key+'">',
            '<div class="col-xs-5 col-sm-5 col-lg-5">',
              '<p class="variable-padding">',
                key,
              '</p>',
            '</div>',
            '<div class="col-xs-3 col-sm-2 col-lg-2">',
              '<input type="color" class="form-control" value="'+journal_ref.rgb_to_hex(graph_colors[key])+'" />',
            '</div>',
            '<div class="col-xs-2 col-sm-2 col-lg-1">',
              '<button class="btn btn-info">',
                '<i class="fa fa-search"></i>',
              '</button>',
            '</div>',
            '<div class="col-xs-1 col-sm-1 col-lg-1">',
              '<button class="btn btn-danger">',
                '<i class="fa fa-trash"></i>',
              '</button>',
            '</div>',
          '</div>'].join("\n"));
      $('#journal-create-graph-variables').append(variable);

      var selected = ($.inArray(key, graphed_variables) > -1) ? 'selected' : '';
      var option = $([
        '<option value="'+key+'" '+selected+'>',
          key,
        '</option>',
      ].join("\n"));
      $('#journal-create-graph-graphed-variables').append(option);
    });
  },
  delete_graph_variable: function(e) {
    var name = $(e.target).closest('.graph-variable-group').attr('id').split('-')[1];
    this.remove_graph_variable(name);
    this.show_graph_available_variables();
  },
  show_graph_variable: function(e) {
    var name = $(e.target).closest('.graph-variable-group').attr('id').split('-')[1];
    var content = 'calc(';
    $.each(graph_variables[name]['calc'], function(key, data){
      content += data;
    });
    content += ')';
    //content += ').'+report_variables[name]['group_by'];

    $('#journal-create-graph-variable').val(name);
    $('#journal-create-graph-content').val(content);
  },
  remove_graph_variable: function(name) {
    // Check if there is any other variable that is dependent on this variable.
    var journal_ref = this;
    $.each(graph_variables, function(key, data) {
      var count = 0;
      $.each(data['calc'], function(k, d) {
        if((count % 2) == 0) {
          entry_parts = d.split(new RegExp('(?:\\(|\\)).*?', 'g'));
          if(entry_parts[0] == 'variable' && entry_parts[1] == name) {
            journal_ref.remove_graph_variable(key);
          }
        }
        count++;
      });
    });
    delete graph_variables[name];
    delete graph_colors[name];
  },
  create_graph: function(e) {
    var name = $('#journal-create-graph-title').val();
    var group_by = $('#journal-create-graph-group').val();
    var type = $('#journal-create-graph-type').val();
    var graphed_variables = $('#journal-create-graph-graphed-variables').val();
    if(create_graph) {
      var journal_ref = this;
      var request = $.post('/swift/accounting/create_graph', { name: name,
        variables: graph_variables, group_by: group_by,
         type: type, graphed_variables: graphed_variables,
         colors: graph_colors, _token: swift_utils.swift_token() });
      request.done(function(data) {
        swift_utils.free(e.target);
        if(data.state != 'Success') {
          swift_utils.display_error(data.error);
          return;
        }
        swift_utils.display_success(data.message);
        $('#journal-create-graph').addClass('hide');
        $('.showable').removeClass('hide');
      });
      request.fail(function(ev) {
        swift_utils.free(e.target);
        swift_utils.ajax_fail(ev);
      });
    } else {
      var journal_ref = this;
      var request = $.post('/swift/accounting/edit_graph', { graph: graph_code, name: name,
        variables: graph_variables, group_by: group_by,
         type: type, graphed_variables: graphed_variables,
         colors: graph_colors, _token: swift_utils.swift_token() });
      request.done(function(data) {
        swift_utils.free(e.target);
        if(data.state != 'Success') {
          swift_utils.display_error(data.error);
          return;
        }
        swift_utils.display_success(data.message);
        $('#journal-create-graph').addClass('hide');
        $('.showable').removeClass('hide');
      });
      request.fail(function(ev) {
        swift_utils.free(e.target);
        swift_utils.ajax_fail(ev);
      });
    }
  },
  edit_graph: function(e) {
    var graph = $('#journal-graphs-graph').val();
    var journal_ref = this;
    var request = $.post('/swift/accounting/load_graph', { graph: graph, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      $('#journal-create-graph-title').val(data.graph.name);
      graph_variables = data.graph.variables;
      create_graph = false;
      graph_code = data.graph.id;
      graph_colors = data.graph.colors;
      graphed_variables = data.graph.graphed_variables;
      $('#create-graph-title').html(swift_language.get_sentence('edit_graph'));
      $('#journal-create-graph-create').html(swift_language.get_sentence('edit_graph_button'));
      $('#journal-create-graph-variable').val('');
      $('#journal-create-graph-content').val('');
      $('#journal-create-graph-group').val(data.graph.group_by);
      $('#journal-create-graph-type').val(data.graph.graph_type);
      $('#journal-create-graph').removeClass('hide');
      $('.showable').addClass('hide');

      journal_ref.show_graph_available_variables();
      journal_ref.change_graph();
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  update_graphed_variables: function(e) {
    graphed_variables = $(e.target).val();
    this.change_graph();
  },
  get_graph_labels: function() {
    var group_by = $('#journal-create-graph-group').val();
    switch(group_by) {
      case 'summary':
        var labels = [];
        $.each(graphed_variables, function(key, data) {
          labels.push(data);
        });
        return labels;
        break;
      case 'day':
        return ['01/01/2017', '02/01/2017','03/01/2017', '04/01/2017', '05/01/2017'];
        break;
      case 'week':
        return ['01/2017', '02/2017','03/2017', '04/2017', '05/01/2017'];
        break;
      case 'month':
        return ['01/2017', '02/2017','03/2017', '04/2017', '05/01/2017'];
        break;
      case 'year':
        return ['2017', '2018','2019', '2020'];
        break;
    }
  },
  change_graph: function() {
    var type = $('#journal-create-graph-type').val();
    var journal_ref = this;
    switch(type) {
      case 'line':
      if($('#journal-create-graph-group').val() == 'summary') {
        $('#journal-create-graph-group').val('day');
      }
        // First define the basic setup of the graph.
        var graph_setup = {
          type: 'line',
          data: {
            labels: journal_ref.get_graph_labels(),
            datasets: [],
          }
        };

        $.each(graphed_variables, function(key, data){
          var graph_data = [];
          for(var i = 0; i < graph_setup.data.labels.length; i++) {
            graph_data.push(Math.random() * (100 - 10) + 10);
          }
          graph_setup.data.datasets.push({
            label: data,
            data: graph_data,
            backgroundColor: 'rgba('+graph_colors[data].r+', '+graph_colors[data].g+', '+graph_colors[data].b+', 0.2)',
            borderColor: 'rgba('+graph_colors[data].r+', '+graph_colors[data].g+', '+graph_colors[data].b+', 1)',
            borderWidth: 1
          });
        });

        journal_ref.paint_create_graph(graph_setup);
        break;
      case 'bar':
        // First define the basic setup of the graph.
        var graph_setup = {
          type: 'bar',
          data: {
            labels: journal_ref.get_graph_labels(),
            datasets: [],
          }
        };
        // TODO: Fix hover label bug.
        if($('#journal-create-graph-group').val() == 'summary') {
          var count = 0;
          $.each(graphed_variables, function(key, data){
            var graph_data = [];
            graph_data.push(Math.random() * (100 - 10) + 10);
            graph_setup.data.datasets.push({
              label: data,
              data: graph_data,
              backgroundColor: 'rgba('+graph_colors[data].r+', '+graph_colors[data].g+', '+graph_colors[data].b+', 0.2)',
              borderColor: 'rgba('+graph_colors[data].r+', '+graph_colors[data].g+', '+graph_colors[data].b+', 1)',
              borderWidth: 1
            });
            count++;
          });
        } else {
          $.each(graphed_variables, function(key, data){
            var graph_data = [];
            for(var i = 0; i < graph_setup.data.labels.length; i++) {
              graph_data.push(Math.random() * (100 - 10) + 10);
            }
            graph_setup.data.datasets.push({
              label: data,
              data: graph_data,
              backgroundColor: 'rgba('+graph_colors[data].r+', '+graph_colors[data].g+', '+graph_colors[data].b+', 0.2)',
              borderColor: 'rgba('+graph_colors[data].r+', '+graph_colors[data].g+', '+graph_colors[data].b+', 1)',
              borderWidth: 1
            });
          });
        }

        journal_ref.paint_create_graph(graph_setup);
        break;
      case 'pie':
        // First define the basic setup of the graph.
        if($('#journal-create-graph-group').val() != 'summary') {
          $('#journal-create-graph-group').val('summary');
        }
        var graph_setup = {
          type: 'pie',
          data: {
            labels: journal_ref.get_graph_labels(),
            datasets: [],
          }
        };

        var graph_data = [];
        for(var i = 0; i < graph_setup.data.labels.length; i++) {
          graph_data.push(Math.random() * (100 - 10) + 10);
        }
        var backgroundColors = [];
        var borderColors = [];
        $.each(graphed_variables, function(key, data){
          backgroundColors.push('rgba('+graph_colors[data].r+', '+graph_colors[data].g+', '+graph_colors[data].b+', 0.2)');
          borderColors.push('rgba('+graph_colors[data].r+', '+graph_colors[data].g+', '+graph_colors[data].b+', 1)');
        });

        graph_setup.data.datasets.push({
          //label: journal_ref.get_graph_labels(),
          data: graph_data,
          backgroundColor: backgroundColors,
          borderColor: borderColors,
          borderWidth: 1
        });

        journal_ref.paint_create_graph(graph_setup);
        break;
    }
  },
  generate_graph: function(e) {
    var graph = $('#journal-graphs-graph').val();
    var date_range = $('#journal-graphs-date-range').val();
    swift_utils.busy(e.target);
    var journal_ref = this;
    var request = $.post('/swift/accounting/generate_graph', { graph: graph, date_range: date_range, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
        return;
      }
      journal_ref.paint_graph(data.setup);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },
  change_color: function(e) {
    var name = $(e.target).closest('.graph-variable-group').attr('id').split('-')[1];
    var rgb = this.hex_to_rgb($(e.target).val());
    graph_colors[name] = rgb;
    this.change_graph();
  },
  rgb_to_hex: function(rgb) {
    return "#" + ((1 << 24) + (parseInt(rgb.r) << 16) + (parseInt(rgb.g) << 8) + parseInt(rgb.b)).toString(16).slice(1);
  },
  hex_to_rgb: function(hex) {
    // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
    var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
      return r + r + g + g + b + b;
    });

    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
  },
}

var journal_js = new Journal();

// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '#journal-create-graph-group',
  'change',
  journal_js,
  'change_graph');

$(document).on('change', '#journal-create-graph-group', function(e) {
  swift_event_tracker.fire_event(e, '#journal-create-graph-group');
});

swift_event_tracker.register_swift_event(
  '#journal-create-graph-type',
  'change',
  journal_js,
  'change_graph');

$(document).on('change', '#journal-create-graph-type', function(e) {
  swift_event_tracker.fire_event(e, '#journal-create-graph-type');
});

swift_event_tracker.register_swift_event(
  '#journal-create-graph-graphed-variables',
  'change',
  journal_js,
  'update_graphed_variables');

$(document).on('change', '#journal-create-graph-graphed-variables', function(e) {
  swift_event_tracker.fire_event(e, '#journal-create-graph-graphed-variables');
});

swift_event_tracker.register_swift_event(
  '.graph-variable-group > div > input',
  'change',
  journal_js,
  'change_color');

$(document).on('change', '.graph-variable-group > div > input', function(e) {
  swift_event_tracker.fire_event(e, '.graph-variable-group > div > input');
});

swift_event_tracker.register_swift_event(
  '#journal-graphs-edit',
  'click',
  journal_js,
  'edit_graph');

$(document).on('click', '#journal-graphs-edit', function(e) {
  swift_event_tracker.fire_event(e, '#journal-graphs-edit');
});

swift_event_tracker.register_swift_event(
  '#journal-create-graph-create',
  'click',
  journal_js,
  'create_graph');

$(document).on('click', '#journal-create-graph-create', function(e) {
  swift_event_tracker.fire_event(e, '#journal-create-graph-create');
});

swift_event_tracker.register_swift_event(
  '.graph-variable-group > div > .btn-danger',
  'click',
  journal_js,
  'delete_graph_variable');

$(document).on('click', '.graph-variable-group > div > .btn-danger', function(e) {
  swift_event_tracker.fire_event(e, '.graph-variable-group > div > .btn-danger');
});

swift_event_tracker.register_swift_event(
  '.graph-variable-group > div > .btn-info',
  'click',
  journal_js,
  'show_graph_variable');

$(document).on('click', '.graph-variable-group > div > .btn-info', function(e) {
  swift_event_tracker.fire_event(e, '.graph-variable-group > div > .btn-info');
});

swift_event_tracker.register_swift_event(
  '#journal-create-graph-add',
  'click',
  journal_js,
  'add_graph_variable');

$(document).on('click', '#journal-create-graph-add', function(e) {
  swift_event_tracker.fire_event(e, '#journal-create-graph-add');
});

swift_event_tracker.register_swift_event(
  '#journal-graphs-generate',
  'click',
  journal_js,
  'generate_graph');

$(document).on('click', '#journal-graphs-generate', function(e) {
  swift_event_tracker.fire_event(e, '#journal-graphs-generate');
});

swift_event_tracker.register_swift_event(
  '.journal-config-group > div > .btn-danger',
  'click',
  journal_js,
  'delete_rule');

$(document).on('click', '.journal-config-group > div > .btn-danger', function(e) {
  swift_event_tracker.fire_event(e, '.journal-config-group > div > .btn-danger');
});

swift_event_tracker.register_swift_event(
  '#add-configuration-rule-add',
  'click',
  journal_js,
  'create_it_rule');

$(document).on('click', '#add-configuration-rule-add', function(e) {
  swift_event_tracker.fire_event(e, '#add-configuration-rule-add');
});

swift_event_tracker.register_swift_event(
  '#journal-configuration-add-rule',
  'click',
  journal_js,
  'clear_it_rule_form');

$(document).on('click', '#journal-configuration-add-rule', function(e) {
  swift_event_tracker.fire_event(e, '#journal-configuration-add-rule');
});

swift_event_tracker.register_swift_event(
  '#journal-configuration-entity-type',
  'change',
  journal_js,
  'change_entity_type');

$(document).on('change', '#journal-configuration-entity-type', function(e) {
  swift_event_tracker.fire_event(e, '#journal-configuration-entity-type');
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
  '#journal-graphs-create',
  'click',
  journal_js,
  'show_create_graph');

$(document).on('click', '#journal-graphs-create', function(e) {
  swift_event_tracker.fire_event(e, '#journal-graphs-create');
});

swift_event_tracker.register_swift_event(
  '#journal-configuration-save',
  'click',
  journal_js,
  'save_configuration');

$(document).on('click', '#journal-configuration-save', function(e) {
  swift_event_tracker.fire_event(e, '#journal-configuration-save');
});

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

$(document).on('focus', '#journal-configuration-retained-vat', function(e) {
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

$(document).on('focus', '#journal-configuration-advanced-vat', function(e) {
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

$(document).on('focus', '#journal-configuration-retained-it', function(e) {
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

$(document).on('focus', '#journal-configuration-advanced-it', function(e) {
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
swift_event_tracker.register_swift_event('#journal-processes-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-processes-tab', function(e) {
  $('.hideable').addClass('hide');
  $('.showable').removeClass('hide');
  swift_event_tracker.fire_event(e, '#journal-processes-tab');
});
swift_event_tracker.register_swift_event('#journal-configuration-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#journal-configuration-tab', function(e) {
  $('.hideable').addClass('hide');
  $('.showable').removeClass('hide');
  swift_event_tracker.fire_event(e, '#journal-configuration-tab');
});
