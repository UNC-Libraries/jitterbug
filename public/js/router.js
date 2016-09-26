// See: http://www.paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/

JUNEBUG = {
  common: {
    init: function() {
      junebug.initAjax();
      junebug.getAlert();
    }
  },

  auth: {
    showLoginForm: function() {
      junebug.initGreeting();
    }
  },

  items: {
    init: function() {
      // controller-wide code 
    },

    index: function() {
      junebug.initItemsIndex();
      junebug.initTableKeyboardShortcuts();
      junebug.initItemsNewButton();
      junebug.initItemsBatchMenu();
    },

    show: function() {
      junebug.initRevisionHistory();
      junebug.initRelatedPreservationMasters();
      junebug.initRelatedCuts();
    },

    create: function() {
      junebug.initItemTypeControls();
      junebug.initItemCallNumberGeneration();
      junebug.initDatepicker();
      junebug.initItemSuggestions();
    },

    edit: function() {
      junebug.initDatepicker();
      junebug.initItemSuggestions();
      junebug.initRevisionHistory();
      junebug.initRelatedPreservationMasters();
      junebug.initRelatedCuts();
    },

    editBatch: function() {
      junebug.initBatchEditMixed();
      junebug.initDatepicker();
      junebug.initItemSuggestions();
    }
  },

  masters: {
    init: function() {
      // controller-wide code 
    },

    index: function() {
      junebug.initMastersIndex();
      junebug.initTableKeyboardShortcuts();
    },

    show: function() {
      junebug.initRevisionHistory();
      junebug.initRelatedCuts();
      junebug.initRelatedTransfers();
    },

    create: function() {
      junebug.initMasterTypeControls();
    },

    edit: function() {
      junebug.initRevisionHistory();
      junebug.initRelatedCuts();
      junebug.initRelatedTransfers();
    }
  },

  cuts: {
    init: function() {
      // controller-wide code 
    },

    show: function() {
      junebug.initRevisionHistory();
      junebug.initRelatedTransfers();
    }
  },

  transfers: {
    init: function() {
      // controller-wide code 
    },

    index: function() {
      junebug.initTransfersIndex();
      junebug.initTableKeyboardShortcuts();
      junebug.initFileSelect();
      junebug.initAudioImportModal();
    },

    show: function() {
      junebug.initRevisionHistory();
      junebug.initRelatedCuts();
    }
  },

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