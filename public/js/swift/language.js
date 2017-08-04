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
  setLanguage: function(language) {
    lang = language;
  },
  getLanguage: function() {
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
swift_language.add_sentence('blank_ruc', {
                            'en': 'RUC can\'t be left blank!',
                            'es': 'RUC no puede dejarse en blanco!'
                          });
