// See: http://www.paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/

JITTERBUG = {
  common: {
    init: function() {
      jitterbug.initAjax();
      jitterbug.initSessionTimeout();
      jitterbug.getAlert();
    }
  },

  auth: {
    showLoginForm: function() {
      jitterbug.initGreeting();
    }
  },

  items: {
    init: function() {
      // controller-wide code 
    },

    index: function() {
      jitterbug.initItemsIndex();
      jitterbug.initTableKeyboardShortcuts();
      jitterbug.initItemsNewButton();
      jitterbug.initItemsBatchMenu();
      jitterbug.initBatchDeleteForm();
    },

    show: function() {
      jitterbug.initMarkRibbon();
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedPreservationMasters();
      jitterbug.initRelatedCuts();
    },

    create: function() {
      jitterbug.initItemTypeControls();
      jitterbug.initItemCallNumberGeneration();
      jitterbug.initDatepicker();
      jitterbug.initItemSuggestions();
    },

    edit: function() {
      jitterbug.initDatepicker();
      jitterbug.initItemSuggestions();
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedPreservationMasters();
      jitterbug.initRelatedCuts();
    },

    batchEdit: function() {
      jitterbug.initBatchEditMixed();
      jitterbug.initDatepicker();
      jitterbug.initItemSuggestions();
    }
  },

  masters: {
    init: function() {
      // controller-wide code 
    },

    index: function() {
      jitterbug.initMastersIndex();
      jitterbug.initTableKeyboardShortcuts();
      jitterbug.initMastersNewButton();
      jitterbug.initMastersBatchMenu();
      jitterbug.initBatchDeleteForm();
    },

    show: function() {
      jitterbug.initMarkRibbon();
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedCuts();
      jitterbug.initRelatedTransfers();
    },

    create: function() {
      jitterbug.initMasterTypeControls();
      jitterbug.initMasterBatchCheckbox();
    },

    edit: function() {
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedCuts();
      jitterbug.initRelatedTransfers();
    },

    batchEdit: function() {
      jitterbug.initBatchEditMixed();
    }
  },

  cuts: {
    init: function() {
      // controller-wide code 
    },

    show: function() {
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedTransfers();
    },

    edit: function() {
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedTransfers();
    }
  },

  transfers: {
    init: function() {
      // controller-wide code 
    },

    index: function() {
      jitterbug.initTransfersIndex();
      jitterbug.initTableKeyboardShortcuts();
      jitterbug.initAudioImportModal();
      jitterbug.initVideoImportModal();
      jitterbug.initTransfersNewButton();
      jitterbug.initTransfersBatchMenu();
      jitterbug.initBatchDeleteForm();
    },

    show: function() {
      jitterbug.initMarkRibbon();
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedCuts();
    },

    create: function() {
      jitterbug.initTransferTypeControls();
      jitterbug.initTransferCallNumberQuery();
      jitterbug.initDatepicker();
    },

    edit: function() {
      jitterbug.initDatepicker();
      jitterbug.initTransferCallNumberQuery();
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedCuts();
    },
  },

};

ROUTER = {
  exec: function(controller, action) {
    var ns = JITTERBUG,
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