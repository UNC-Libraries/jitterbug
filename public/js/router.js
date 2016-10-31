// See: http://www.paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/

JUNEBUG = {
  common: {
    init: function() {
      junebug.initAjax();
      junebug.initSessionTimeout();
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
      junebug.initBatchDeleteForm();
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

    batchEdit: function() {
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
      junebug.initMastersNewButton();
      junebug.initMastersBatchMenu();
      junebug.initBatchDeleteForm();
    },

    show: function() {
      junebug.initRevisionHistory();
      junebug.initRelatedCuts();
      junebug.initRelatedTransfers();
    },

    create: function() {
      junebug.initMasterTypeControls();
      junebug.initMasterBatchCheckbox();
    },

    edit: function() {
      junebug.initRevisionHistory();
      junebug.initRelatedCuts();
      junebug.initRelatedTransfers();
    },

    batchEdit: function() {
      junebug.initBatchEditMixed();
    }
  },

  cuts: {
    init: function() {
      // controller-wide code 
    },

    show: function() {
      junebug.initRevisionHistory();
      junebug.initRelatedTransfers();
    },

    edit: function() {
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
      junebug.initAudioImportModal();
      junebug.initTransfersNewButton();
      junebug.initTransfersBatchMenu();
      junebug.initBatchDeleteForm();
    },

    show: function() {
      junebug.initRevisionHistory();
      junebug.initRelatedCuts();
    },

    create: function() {
      junebug.initTransferTypeControls();
      junebug.initTransferCallNumberQuery();
      junebug.initDatepicker();
    },

    edit: function() {
      junebug.initDatepicker();
      junebug.initTransferCallNumberQuery();
      junebug.initRevisionHistory();
      junebug.initRelatedCuts();
    },
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