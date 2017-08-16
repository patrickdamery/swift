/*
  Swift Menu handles. Controls the logic of the Swift Menu.
*/
function Menu() {
  current = '';
  menu = {};
  language = null;
}

Menu.prototype={
  constructor: Menu,
  register_menu_option: function(o) {
    var key = Object.keys(o)[0];
    if(key != '' && key != undefined) {
      menu[key] = o[key];
    }
  },
  get_language: function() {
    return language;
  },
  new_submenu: function() {
    language = new Language();
  },
  select_submenu_option: function(e) {
    var id = $(e.target).attr('id');
    $('.crumb').html(language.get_sentence(id));
  },
  select_menu_option: function(e) {
    var id = $(e.target).attr('id');
    var url = menu[id];
    this.load_selected_view(url, e);
  },
  load_selected_view: function(url, e) {
    swift_utils.busy(e.target);
    var menu_content = $.post(url, { _token: swift_utils.swift_token() });
    menu_content.done(function(view) {
      $('#main-content').empty();
      $('#main-content').append(view);
      swift_utils.free(e.target);
    });
    menu_content.fail(function(ev) {
      swift_utils.free(e.target);
      swift_utils.ajax_fail(ev);
    });
  }
}

var swift_menu = new Menu();
