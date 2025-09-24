import { $, j as jitterbug } from "./jitterbug-C7z39nYE.js";
window.$ = window.jQuery = $;
const JITTERBUG_LOAD = {
  common: {
    init() {
      jitterbug.initAjax();
      jitterbug.initSessionTimeout();
      jitterbug.getAlert();
    }
  },
  login: {
    showLoginForm() {
      jitterbug.initGreeting();
    }
  },
  admin: {
    init() {
    },
    index() {
      jitterbug.initAdmin();
    }
  },
  dashboard: {
    init() {
    },
    index() {
      jitterbug.initDashboardCharts();
      jitterbug.initDashboardActivityStream();
      jitterbug.initDashboardMarks();
    }
  },
  items: {
    init() {
    },
    index() {
      jitterbug.initItemsIndex();
      jitterbug.initTableKeyboardShortcuts();
      jitterbug.initItemsImportModal();
      jitterbug.initItemsNewButton();
      jitterbug.initItemsBatchMenu();
      jitterbug.initBatchDeleteForm();
    },
    show() {
      jitterbug.initMarkRibbon();
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedPreservationInstances();
      jitterbug.initRelatedCuts();
    },
    create() {
      jitterbug.initItemTypeControls();
      jitterbug.initItemCallNumberGeneration();
      jitterbug.initDatepicker();
      jitterbug.initItemSuggestions();
      jitterbug.initSubmitButton();
    },
    edit() {
      jitterbug.initDatepicker();
      jitterbug.initItemSuggestions();
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedPreservationInstances();
      jitterbug.initRelatedCuts();
      jitterbug.initSubmitButton();
    },
    batchEdit() {
      jitterbug.initBatchEditMixed();
      jitterbug.initDatepicker();
      jitterbug.initItemSuggestions();
      jitterbug.initSubmitButton();
    }
  },
  instances: {
    init() {
    },
    index() {
      jitterbug.initInstancesIndex();
      jitterbug.initTableKeyboardShortcuts();
      jitterbug.initInstancesNewButton();
      jitterbug.initInstancesBatchMenu();
      jitterbug.initBatchDeleteForm();
    },
    show() {
      jitterbug.initMarkRibbon();
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedCuts();
      jitterbug.initRelatedTransfers();
    },
    create() {
      jitterbug.initInstanceTypeControls();
      jitterbug.initInstanceBatchCheckbox();
      jitterbug.initSubmitButton();
    },
    edit() {
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedCuts();
      jitterbug.initRelatedTransfers();
      jitterbug.initSubmitButton();
    },
    batchEdit() {
      jitterbug.initBatchEditMixed();
      jitterbug.initSubmitButton();
    }
  },
  cuts: {
    init() {
    },
    show() {
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
    init() {
    },
    index() {
      jitterbug.initTransfersIndex();
      jitterbug.initTableKeyboardShortcuts();
      jitterbug.initAudioImportModal();
      jitterbug.initVideoImportModal();
      jitterbug.initTransfersNewButton();
      jitterbug.initTransfersBatchMenu();
      jitterbug.initBatchDeleteForm();
    },
    show() {
      jitterbug.initMarkRibbon();
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedCuts();
    },
    create() {
      jitterbug.initTransferTypeControls();
      jitterbug.initTransferCallNumberQuery();
      jitterbug.initDatepicker();
      jitterbug.initSubmitButton();
    },
    edit() {
      jitterbug.initDatepicker();
      jitterbug.initTransferCallNumberQuery();
      jitterbug.initRevisionHistory();
      jitterbug.initRelatedCuts();
      jitterbug.initSubmitButton();
    },
    batchEdit() {
      jitterbug.initDatepicker();
      jitterbug.initTransferCallNumberQuery();
      jitterbug.initBatchEditMixed();
      jitterbug.initSubmitButton();
    }
  },
  formats: {
    init() {
    },
    show() {
      jitterbug.initPrefixActions();
    }
  }
};
const ROUTER = {
  exec(controller, action) {
    let ns = JITTERBUG_LOAD, action_type = action === void 0 ? "init" : action;
    if (controller !== "" && ns[controller] && typeof ns[controller][action] == "function") {
      ns[controller][action_type]();
    }
  },
  init() {
    let body = document.body, controller = body.getAttribute("data-controller"), action = body.getAttribute("data-action");
    ROUTER.exec("common");
    ROUTER.exec(controller);
    ROUTER.exec(controller, action);
  }
};
$(document).ready(ROUTER.init);
