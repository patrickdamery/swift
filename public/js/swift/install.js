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
  set_business_data: function(e) {

  },
  get_business_data: function(e) {

  },
  set_card_data: function(e) {

  },
  get_card_data: function(e) {

  },
  set_modules_data: function(e) {

  },
  get_modules_data: function(e) {

  },
  set_stock_data: function(e) {

  },
  get_stock_data: function(e) {

  },
  set_clients_data: function(e) {

  },
  get_clients_data: function(e) {

  },
  download_business_data_template: function(e) {

  },
  download_stock_data_template: function(e) {

  },
  download_clients_data_template: function(e) {

  },
  upload_business_data: function(e) {

  },
  upload_card_data: function(e) {

  },
  upload_stock_data: function(e) {

  },
  upload_clients_data: function(e) {

  },
  save_and_install: function(e) {

  },
  next: function(e) {
    // Fire appropriate step function.
    var targets = ['#configure', '.ruc'];
    var t = $.inArray(e.target, targets);
    if(t > -1) {
        this.set_page(targets[t+1]);
    }
  },
  set: function(e) {
    this.set_page(e.target);
  },
  set_page: function(page) {
    $('.hideables').addClass('hide');
    $(page+'-page').removeClass('hide');
  },
  start_config: function(e) {
    $('.content-wrapper-off').addClass('content-wrapper');
    $('.content-wrapper').removeClass('content-wrapper-off');
    $('.main-sidebar').removeClass('hide');
    $('#landing').addClass('hide');
    $('#business').removeClass('hide');
  },
  check_ruc: function(e) {
    swift_utils.busy(e.target);
    var ruc = $('#ruc').val();

    if(ruc == '') {
      swift_utils.display_error(swift_language.get_sentence('blank_ruc'));
      swift_utils.free(e.target);
      return;
    }
    // TODO: Actually submit RUC to alonica server to check.
    swift_utils.free(e.target);
    // Display business modules form.
    $('#module-selection').slideDown("slow");
  },
  check_business_data: function(e) {

  }
}

var install_swift = new Install();

// Register events.
swift_event_tracker.register_swift_event('#configure', 'click', install_swift, 'start_config');
$(document).on('click', '#configure', function(e) {
  swift_event_tracker.fire_event(e, '#configure');
});

swift_event_tracker.register_swift_event('#check-ruc', 'click', install_swift, 'check_ruc');
$(document).on('click', '#check-ruc', function(e) {
  swift_event_tracker.fire_event(e, '#check-ruc');
});
