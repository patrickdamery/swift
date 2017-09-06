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
  ajax_fail: function(e) {
    if(e.status === 404) {
      this.display_error(swift_language.get_sentence('404'));
    } else if(e.status === 500) {
      this.display_error(swift_language.get_sentence('500'));
    } else if(e.status == 419) {
      location.reload();
    } else {
      this.display_error(swift_language.get_sentence('no_internet'));
    }
  },
  swift_token: function(e) {
    return $('meta[name=csrf-token]').attr('content');
  },
  refresh_token: function() {
    var token = $.post('/refresh_token');
    token.done(function(data) {
      $('meta[name=csrf-token]').attr('content', data.token);
    });
    token.fail(function(ev) {
      swift_utils.ajax_fail(ev);
    });
  },
  register_ajax_fail: function() {
    swift_language.add_sentence('404', {
                                'en': 'The requested resource could not be found on the server!',
                                'es': 'No se pudo encontrar el recurso solicitado en el servidor!'
                              });
    swift_language.add_sentence('500', {
                                'en': 'There\'s a configuration problem on the server, please contact your system\'s administrator!',
                                'es': 'Hay un problema con la configuracion del servidor, por favor contactar al administrador!'
                              });

    swift_language.add_sentence('no_internet', {
                                'en': 'You are not connected to the internet!',
                                'es': 'No hay conexion al internet!'
                              });
  },
 }

var swift_utils = new Utilities();

// Interval to keep csrf token updated.
setInterval('swift_utils.refresh_token()', 3600000);
/**
 * List of all the available skins
 *
 * @type Array
 */
var mySkins = [
  'skin-blue',
  'skin-black',
  'skin-red',
  'skin-yellow',
  'skin-purple',
  'skin-green',
]

// Add the change skin listener
$(document).on('click', '[data-skin]', function (e) {
  if ($(this).hasClass('knob'))
    return
  e.preventDefault()
  changeSkin($(this).data('skin'))
});

/**
 * Replaces the old skin with the new skin
 * @param String cls the new skin class
 * @returns Boolean false to prevent link's default action
 */
function changeSkin(cls) {
  $.each(mySkins, function (i) {
    $('body').removeClass(mySkins[i])
  })

  $('body').addClass(cls)
  store('skin', cls)
  return false
}
