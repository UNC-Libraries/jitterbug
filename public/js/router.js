// See: http://www.paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/

JITTERBUG = {
  common: {
    init: function() {
      jitterbug.initAjax();
      jitterbug.initSessionTimeout();
      jitterbug.getAlert();
    }
  },

  login: {
    showLoginForm: function() {
      jitterbug.initGreeting();
    }
  },

  admin: {
    init: function() {
      // controller-wide code 
    },

    index: function() {
      jitterbug.initAdmin();
    }
  },

  dashboard: {
    init: function() {
      // controller-wide code 
    },

    index: function() {
      jitterbug.initDashboardCharts();
      jitterbug.initDashboardActivityStream();
      jitterbug.initDashboardMarks();
    }
  },

  items: {
    init: function() {
      // controller-wide code 
    },

    index: function() {
      jitterbug.initItemsIndex();
      // TODO Will fix a bug where batch marking, 
      // then navigating away from the index page,
      // then using the back button renders the 
      // page without the new marks
      // jitterbug.renderMarks();
      jitterbug.initTableKeyboardShortcuts();
      jitterbug.initItemsImportModal();
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
      jitterbug.initSubmitButton();
    },

    edit: function() {
      jitterbug.initDatepicker();
      jitterbug.initItemSuggestions();
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedPreservationMasters();
      jitterbug.initRelatedCuts();
      jitterbug.initSubmitButton();
    },

    batchEdit: function() {
      jitterbug.initBatchEditMixed();
      jitterbug.initDatepicker();
      jitterbug.initItemSuggestions();
      jitterbug.initSubmitButton();
    }
  },

  masters: {
    init: function() {
      // controller-wide code 
    },

    index: function() {
      jitterbug.initMastersIndex();
      // jitterbug.renderMarks();
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
      jitterbug.initSubmitButton();
    },

    edit: function() {
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedCuts();
      jitterbug.initRelatedTransfers();
      jitterbug.initSubmitButton();
    },

    batchEdit: function() {
      jitterbug.initBatchEditMixed();
      jitterbug.initSubmitButton();
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
      jitterbug.initSubmitButton();
    }
  },

  transfers: {
    init: function() {
      // controller-wide code 
    },

    index: function() {
      jitterbug.initTransfersIndex();
      // jitterbug.renderMarks();
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
      jitterbug.initSubmitButton();
    },

    edit: function() {
      jitterbug.initDatepicker();
      jitterbug.initTransferCallNumberQuery();
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedCuts();
      jitterbug.initSubmitButton();
    },

    batchEdit: function() {
      jitterbug.initDatepicker();
      jitterbug.initTransferCallNumberQuery();
      jitterbug.initBatchEditMixed();
      jitterbug.initSubmitButton();
    }
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