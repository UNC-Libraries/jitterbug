// See: http://www.paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/

JUNEBUG = {
  common: {
    init: function() {
      junebug.displayAlert();
    }
  },

  items: {
    init: function() {
      // controller-wide code 
    },

    index: function() {
      junebug.initItemIndex();
      junebug.initTableKeyboardShortcuts();
    },

    show: function() {
      junebug.initRevisionHistory();
    },

    create: function() {
      junebug.initItemTypeControls();
      junebug.initDatepicker();
      junebug.initItemSuggestions();
    },

    edit: function() {
      junebug.initDatepicker();
      junebug.initItemSuggestions();
      junebug.initRevisionHistory();
    }
  }
};

ROUTER = {
  exec: function(controller, action) {
    var ns = JUNEBUG,
        action = (action === undefined) ? "init" : action;
    if (controller !== "" && ns[controller] && typeof ns[controller][action] == "function") {
      ns[controller][action]();
    }
  },

  init: function() {
    var body = document.body,
      controller = body.getAttribute("data-controller"),
          action = body.getAttribute("data-action");
      ROUTER.exec("common");
      ROUTER.exec(controller);
      ROUTER.exec(controller, action);
  }
};
$(document).ready(ROUTER.init);