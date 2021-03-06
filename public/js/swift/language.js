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
