/*
  products Object.
*/
function Product() {
  products_code = '';
  products_provider = '';
  products_description = '';
  products_children = '';
  products_measurement_unit_code = '';
  products_avg_cost = '';
  products_price = '';
  products_sellable = '';
  products_sell_at_base_price = '';
  products_measurement_unit_code = '';
  products_avg_cost = '';
  products_price = '';
  products_sellable = '';
  products_sell_at_base_price = '';
  products_price = '';
  products_alternatives = '';
  products_volume = '';
  products_weight = '';
  products_package_code = '';
  products_package_measurement_unit_code = '';
  products_order_by = '';
  products_service = '';
  products_materials = '';
  products_points_cost = '';
  products_account_code = '';
  products_offset = 1;
}}

Product.prototype = {
  constructor: Product,


  /
  verify_product_data: function(a) {
    if(a.code == '') {
      swift_utils.display_error(swift_language.get_sentence('create_product_blank_code'));
      return false;
    }


    return true;
  },


  create_product: function(e) {

    // Make target busy and get relevant data.
    swift_utils.busy(e.target);
    var product-data = {
        'code': $('#create-product-code').val(),
        'provider': $('#create-product-provider').val(),
        'description': $('#create-product-description').val(),
        'category': $('#create-product-children').val(),
        'measurement-unit-code': $('#create-product-measurement-unit-code').val(),
        'avg-cost': $('#create-product-avg-cost').val(),
        'price': $('#create-product-price').val(),
        'sellable': $('#create-product-sellable').val(),
        'sell-at-base-price': $('#create-product-sell-at-base-price').val(),
        'base-price': $('#create-product-base-price').val(),
        'alternatives': $('#create-product-alternatives').val(),
        'volume': $('#create-product-volume').val(),
        'weight': $('#create-product-weight').val(),
        'package-code': $('#create-product-package-code').val(),
        'package-mesasurement-unit-code': $('#create-product-package-mesasurement-unit-code').val(),
        'order-by': $('#create-product-order-by').val(),
        'service': $('#create-product-service').val(),
        'materials': $('#create-product-materials').val(),
        'cost': $('#create-product-cost').val(),
        'account-code': $('#create-product-account-code').val(),

      };

    // Check if data is correct and create it if it is.
    if(this.verify_product_data(product_data)) {
      var request = $.post('/swift/products/create_product', { product: product_data, _token: swift_utils.swift_token() });
      request.done(function(data) {
        swift_utils.free(e.target);
        if(data.state != 'Success') {
          swift_utils.display_error(data.error);
          return;
        }

        // Clear modal and hide it.
        $('#create-product-code').val(''),
        $('#create-product-provider').val(''),
        $('#create-product-description').val(''),
        $('#create-product-children').val(''),
        $('#create-product-measurement-unit-code').val(''),
        $('#create-product-avg-cost').val(''),
        $('#create-product-price').val(''),
        $('#create-product-sellable').val(''),
        $('#create-product-sell-at-base-price').val(''),
        $('#create-product-base-price').val(''),
        $('#create-product-alternatives').val(''),
        $('#create-product-volume').val(''),
        $('#create-product-weight').val(''),
        $('#create-product-package-code').val(''),
        $('#create-product-package-mesasurement-unit-code').val(''),
        $('#create-product-order-by').val(),
        $('#create-product-service').val(''),
        $('#create-product-materials').val(''),
        $('#create-product-cost').val(''),
        $('#create-product-account-code').val(''),
        $('#create-product').modal('hide');

        swift_utils.display_success(data.message);
      });
      request.fail(function(ev) {
        swift_utils.free(e.target);
        swift_utils.ajax_fail(ev);
      });
    } else {
      swift_utils.free(e.target);
    }
  },

  change_code: function(e) {
    products_code = $('#account-code').val();
    products_offset = 1;
    this.load_products({
      'code': products_code,
      'offset': products_offset,
    }, e);
  },


  load_products: function(a, e) {
    var request = $.post('/swift/products/load_products', { product_data: a, _token: swift_utils.swift_token() });
    request.done(function(data) {
      swift_utils.free(e.target);
      $('#products-table').empty();
      $('#products-table').append(data);
    });
    request.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  },

  product_paginate: function() {
      products_offset = $(e.target).attr('id').split('-')[2];
      this.load_products({
        'code': products_code,
        'offset': products_offset
  },

}

var products_js = new product();

// Define Event Listeners.
swift_event_tracker.register_swift_event(
  '#create-product-create',
  'click',
  products_js,
  'create_product');

$(document).on('click', '#create-product-create', function(e) {
  swift_event_tracker.fire_event(e, '#create-product-create');
});

swift_event_tracker.register_swift_event(
  '#product-type',
  'change',
  products_js,
  'change_type');

$(document).on('change', '#product-type', function(e) {
  swift_event_tracker.fire_event(e, '#product-type');
});

swift_event_tracker.register_swift_event(
  '#product-code',
  'change',
  products_js,
  'change_code');

$(document).on('change', '#product-code', function(e) {
  swift_event_tracker.fire_event(e, '#product-code');
});

$(function() {
  $('#product-code').autocomplete({
    // Get the suggestions.
    source: function (request, response) {
      $.post('/swift/producting/suggest_products',
      { code: request.term,
        type: $('#product-type').val(),
        _token: swift_utils.swift_token()
      },
      function (data) {
          response(data);
      });
    },
    minLength: 2
  });

});
// Define Menu Tab Events.
swift_event_tracker.register_swift_event('#products-view-products-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#products-view-products-tab', function(e) {
  swift_event_tracker.fire_event(e, '#products-view-products-tab');
});
