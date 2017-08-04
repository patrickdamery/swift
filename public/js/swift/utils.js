/*
  Utilities class that contains generally usefull swift functions.
*/
function Utilities() {

}

Utilities.prototype = {
  constructor: Utilities,
  busy: function(e) {
    $('body').css('cursor', 'wait');
    $(e).prop("disabled", true);
  },
  free: function(e) {
    $('body').css('cursor', 'default');
    $(e).prop("disabled", false);
  },
  display_success: function(message, fadeOut = true, time = 5000) {
    $('#alerts-area').empty();
    var box = $([
        '<div class="center-block alert alert-success alert-dismissible hide" role="alert" style="width:90%;display:none;">',
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">',
        '<span aria-hidden="true">&times;</span></button>',
        '<span class="alert-text">'+message+'</span>',
        '</div>'].join("\n"));
    $('#alerts-area').append(box);
    $(box).fadeIn('slow')
    if(fadeOut) {
      setTimeout(function () {
        $(box).fadeOut('slow');
      }, time);
    }
  },
  display_info: function(message, fadeOut = true, time = 5000) {
    $('#alerts-area').empty();
    var box = $([
        '<div class="center-block alert alert-info alert-dismissible hide" role="alert" style="width:90%;display:none;">',
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">',
        '<span aria-hidden="true">&times;</span></button>',
        '<span class="alert-text">'+message+'</span>',
        '</div>'].join("\n"));
    $('#alerts-area').append(box);
    $(box).fadeIn('slow')
    if(fadeOut) {
      setTimeout(function () {
        $(box).fadeOut('slow');
      }, time);
    }
  },
  display_warning: function(message, fadeOut = true, time = 5000) {
    $('#alerts-area').empty();
    var box = $([
        '<div class="center-block alert alert-warning alert-dismissible hide" role="alert" style="width:90%;display:none;">',
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">',
        '<span aria-hidden="true">&times;</span></button>',
        '<span class="alert-text">'+message+'</span>',
        '</div>'].join("\n"));
    $('#alerts-area').append(box);
    $(box).fadeIn('slow')
    if(fadeOut) {
      setTimeout(function () {
        $(box).fadeOut('slow');
      }, time);
    }
  },
  display_error: function(message, fadeOut = true, time = 5000) {
    $('#alerts-area').empty();
    var box = $([
        '<div class="center-block alert alert-danger alert-dismissible" role="alert" style="width:90%;display:none;">',
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">',
        '<span aria-hidden="true">&times;</span></button>',
        '<span class="alert-text">'+message+'</span>',
        '</div>'].join("\n"));
    $('#alerts-area').append(box);
    $(box).fadeIn('slow')
    if(fadeOut) {
      setTimeout(function () {
        $(box).fadeOut('slow');
      }, time);
    }
  },
 }

var swift_utils = new Utilities();
