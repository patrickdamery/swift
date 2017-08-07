/*
  Class that serves translations of messages. Serves to extend Laravel's
  Localization on the FrontEnd.
*/
function Language(language = 'es') {
  lang = language;
  sentences = {};
}

Language.prototype = {
  constructor: Language,
  set_language: function(language) {
    lang = language;
  },
  get_language: function() {
    return lang;
  },
  add_sentence: function(desc, sentence) {
    sentences[desc] = sentence;
  },
  get_sentence: function(desc) {
    return sentences[desc][lang];
  }
}

swift_language = new Language();

// Add sentences.
swift_language.add_sentence('blank_token', {
                            'en': 'Alonica Token can\'t be left blank!',
                            'es': 'Token de Alonica no puede dejarse en blanco!'
                          });
swift_language.add_sentence('business_blank', {
                            'en': 'All fields are required!',
                            'es': 'Todos los campos son requeridos!'
                          });
