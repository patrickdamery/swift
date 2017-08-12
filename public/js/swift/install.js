/*
  Swift Installation.
*/
function Install() {
  ruc = '';
  card_data = {};
  modules_data = {},
  business_data = {};
  stock_data = {};
  staff_data = {};
  clients_data = {};
  last = '';
}

Install.prototype = {
  constructor: Install,
  get_modules_data: function() {
    return modules_data;
  },
  set_modules_data: function(m) {
    modules_data = m;
  },
  load_modules: function() {

    // Get reference of object to reference inside post request.
    var i = this;
    console.log(i.get_modules_data());
    var request = $.post('/swift/install/load_modules', {
      _token: swift_utils.swift_token() });
    request.done(function(data) {

      if(data.state != 'Success') {
        swift_utils.display_error(data.error);
      }
      i.set_modules_data(data.modules);
      console.log(i.get_modules_data());
    });
  },
  download_branches_data_template: function(e) {
    window.open('/swift/install/download_branches', '_blank');
  },
  download_staff_data_template: function(e) {
    window.open('/swift/install/download_staff', '_blank');
  },
  download_warehouses_data_template: function(e) {
    window.open('/swift/install/download_warehouses', '_blank');
  },
  download_warehouse_locations_data_template: function(e) {
    window.open('/swift/install/download_warehouse_locations', '_blank');
  },
  download_providers_data_template: function(e) {
    window.open('/swift/install/download_providers', '_blank');
  },
  download_categories_data_template: function(e) {
    window.open('/swift/install/download_categories', '_blank');
  },
  download_measurement_units_data_template: function(e) {
    window.open('/swift/install/download_measurement_units', '_blank');
  },
  download_clients_data_template: function(e) {
    window.open('/swift/install/download_clients', '_blank');
  },
  download_products_data_template: function(e) {
    window.open('/swift/install/download_products', '_blank');
  },
  download_accounting_data_template: function(e) {
    window.open('/swift/install/download_accounting', '_blank');
  },
  download_vehicles_data_template: function(e) {
    window.open('/swift/install/download_vehicles', '_blank');
  },
  check_token: function(e) {
    swift_utils.busy(e.target);
    var token = $('#token').val();

    if(token == "") {
      swift_utils.display_error(swift_language.get_sentence('blank_token'));
    }

    var request = $.post('/alonica/user', { alonica_token: token,
        _token: swift_utils.swift_token() });
    request.done(function(data) {

      swift_utils.free(e.target);
      if(data.state != 'Success') {
          swift_utils.display_error(data.error);
        return;
      }
      $('.content-wrapper-off').addClass('content-wrapper');
      $('.content-wrapper').removeClass('content-wrapper-off');
      $('#landing').addClass('hide');
      $('#business').removeClass('hide');

      var modules = $.parseJSON(data.modules);
      set_modules_data(modules);

      if(!modules.staff) {
        $('.staff-module').addClass('hide');
      }
      if(!modules.sales_stock) {
        $('.sales-stock-module').addClass('hide');
      }
      if(!modules.warehouses) {
        $('.warehouses-module').addClass('hide');
      }
      if(!modules.accounting) {
        $('.accounting-module').addClass('hide');
      }
      if(!modules.vehicles) {
        $('.vehicles-module').addClass('hide');
      }
    });
    request.fail(function(ev) {
      swift_utils.ajax_fail(ev);
      swift_utils.free(e.target);
    });
  },
  launch_swift: function(e) {

    // Get relevant values.
    var name = $('#business-name').val();
    var ruc = $('#business-ruc').val();
    var dgi_auth = $('#dgi-auth').val();

    if(name == '' || ruc == '' || dgi_auth == '') {
      swift_utils.display_error(swift_language.get_sentence('business_blank'));
      return;
    }
    swift_utils.busy(e.target);

    // Get files.
    var modules = this.get_modules_data();
    var formData = new FormData();
    formData.append('_token', swift_utils.swift_token());
    formData.append('name', name);
    formData.append('ruc', ruc);
    formData.append('dgi_auth', dgi_auth);
    formData.append('branches', $('#branches').prop('files')[0]);

    if(modules.staff) {
      formData.append('staff', $('#staff').prop('files')[0]);
    }
    if(modules.sales_stock) {
      formData.append('clients', $('#clients').prop('files')[0]);
      formData.append('providers', $('#providers').prop('files')[0]);
      formData.append('categories', $('#categories').prop('files')[0]);
      formData.append('measurement_units', $('#measurement-units').prop('files')[0]);
      formData.append('products', $('#products').prop('files')[0]);
    }
    if(modules.accounting) {
      formData.append('accounting', $('#accounting').prop('files')[0]);
    }
    if(modules.vehicles) {
      formData.append('vehicles', $('#vehicles').prop('files')[0]);
    }
    if(modules.warehouses) {
      formData.append('warehouses', $('#warehouses').prop('files')[0]);
      formData.append('locations',  $('#warehouse-locations').prop('files')[0]);
    }

  	// Submit the ajax request.
  	$.ajax({
        type:'POST',
        url:'/swift/install/launch_swift',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success:function(data){
          swift_utils.free(e.target);
        	// Check if we had any errors
        	if(data.hasOwnProperty('error')) {
        		swift_utils.display_error(data.error);
        	}
          location.reload();
        },
        error: function(data){
          swift_utils.free(e.target);
          swift_utils.display_error("Hubo un error al agregar la factura!");
        }
    });
  }
}

var install_swift = new Install();
$(document).ready(function() {
  install_swift.load_modules();
});

// Register events.
swift_event_tracker.register_swift_event('#token-button', 'click', install_swift, 'check_token');
$(document).on('click', '#token-button', function(e) {
  swift_event_tracker.fire_event(e, '#token-button');
});

swift_event_tracker.register_swift_event('#launch-swift', 'click', install_swift, 'launch_swift');
$(document).on('click', '#launch-swift', function(e) {
  swift_event_tracker.fire_event(e, '#launch-swift');
});

swift_event_tracker.register_swift_event('#branches-template', 'click', install_swift, 'download_branches_data_template');
$(document).on('click', '#branches-template', function(e) {
  swift_event_tracker.fire_event(e, '#branches-template');
});

swift_event_tracker.register_swift_event('#staff-template', 'click', install_swift, 'download_staff_data_template');
$(document).on('click', '#staff-template', function(e) {
  swift_event_tracker.fire_event(e, '#staff-template');
});

swift_event_tracker.register_swift_event('#clients-template', 'click', install_swift, 'download_clients_data_template');
$(document).on('click', '#clients-template', function(e) {
  swift_event_tracker.fire_event(e, '#clients-template');
});

swift_event_tracker.register_swift_event('#warehouses-template', 'click', install_swift, 'download_warehouses_data_template');
$(document).on('click', '#warehouses-template', function(e) {
  swift_event_tracker.fire_event(e, '#warehouses-template');
});

swift_event_tracker.register_swift_event('#warehouse-locations-template', 'click', install_swift, 'download_warehouse_locations_data_template');
$(document).on('click', '#warehouse-locations-template', function(e) {
  swift_event_tracker.fire_event(e, '#warehouse-locations-template');
});

swift_event_tracker.register_swift_event('#providers-template', 'click', install_swift, 'download_providers_data_template');
$(document).on('click', '#providers-template', function(e) {
  swift_event_tracker.fire_event(e, '#providers-template');
});

swift_event_tracker.register_swift_event('#categories-template', 'click', install_swift, 'download_categories_data_template');
$(document).on('click', '#categories-template', function(e) {
  swift_event_tracker.fire_event(e, '#categories-template');
});

swift_event_tracker.register_swift_event('#measurement-units-template', 'click', install_swift, 'download_measurement_units_data_template');
$(document).on('click', '#measurement-units-template', function(e) {
  swift_event_tracker.fire_event(e, '#measurement-units-template');
});

swift_event_tracker.register_swift_event('#products-template', 'click', install_swift, 'download_products_data_template');
$(document).on('click', '#products-template', function(e) {
  swift_event_tracker.fire_event(e, '#products-template');
});

swift_event_tracker.register_swift_event('#accounting-template', 'click', install_swift, 'download_accounting_data_template');
$(document).on('click', '#accounting-template', function(e) {
  swift_event_tracker.fire_event(e, '#accounting-template');
});

swift_event_tracker.register_swift_event('#vehicles-template', 'click', install_swift, 'download_vehicles_data_template');
$(document).on('click', '#vehicles-template', function(e) {
  swift_event_tracker.fire_event(e, '#vehicles-template');
});
