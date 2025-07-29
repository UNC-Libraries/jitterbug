jitterbug = {
  clearStorage: function() {
    // clear admin table
    sessionStorage.removeItem('selectedAdminTable');
    // clear items state
    localStorage.removeItem('itemsSearchField');
    localStorage.removeItem('itemsFilterPanel');
    sessionStorage.removeItem('itemsTableSelection');
    localStorage.removeItem('itemsTableParams');
    // clear instances state
    localStorage.removeItem('instancesSearchField');
    localStorage.removeItem('instancesFilterPanel');
    sessionStorage.removeItem('instancesTableSelection');
    localStorage.removeItem('instancesTableParams');
    // clear transfers state
    localStorage.removeItem('transfersSearchField');
    localStorage.removeItem('transfersFilterPanel');
    sessionStorage.removeItem('transfersTableSelection');
    localStorage.removeItem('transfersTableParams');
    // clear marks module
    sessionStorage.removeItem('dashboardMarks');
  },

  initAjax: function() {
    $.ajaxSetup({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
  },

  initSessionTimeout: function() {
    let threeHours = 10800000;
    window.setTimeout(function() {
      window.location.href='/logout'
    }, threeHours);
  },

  initGreeting: function() {
    let hour = new Date().getHours(),
        greeting;
    if (hour > 17) {
      greeting = 'Good Evening!';
    } else if (hour > 11) {
      greeting = 'Good Afternoon!';
    } else if (hour > 0) {
      greeting = 'Good Morning!';
    } else {
      greeting = 'Welcome!';
    }
    $('#greeting').text(greeting);
  },

  getAlert: function() {
    $.get('/alerts', function(data) {
      if (!$.isEmptyObject(data)) {
        $.ajax({url: '/alerts', type: 'delete'});
        jitterbug.displayAlert(data['type'],data['message']);
      }
    });
  },

  displayAlert: function(type, message) {
    if (type.length && message.length) {
      let alert = document.createElement('div');
      $(alert).attr('id', 'alert');
      $(alert).attr('class', 'col-md-12 alert alert-' + type);
      $(alert).attr('role', 'alert');
      $(alert).html(message);
      $('#alert').replaceWith(alert);
      $('#alert').delay(500).slideDown(200).delay(8000).slideUp(200);
    }
  },

  initSubmitButton: function() {
    $('button[type="submit"]').on('click', function(event){
      $(this).attr('disabled', true);
      $(this).closest('form').submit();
    });
  },

  initSelectAll: function(allSelector, checkboxSelector) {
    $(allSelector).on('change', function(event) {
      // check all boxes if select all is clicked or vice versa
      if (this.checked) {
        $(checkboxSelector).each(function() {
          this.checked=true;
        });
      } else {
        $(checkboxSelector).each(function() {
          this.checked=false;
        });
      }
    });

    // if all checkboxes are individually clicked, populate select all accordingly
    $(checkboxSelector).on('change', function () {
      if ($(this).is(":checked")) {
        let isAllChecked = 0;

        $(checkboxSelector).each(function() {
          if (!this.checked)
            isAllChecked = 1;
        });

        if (isAllChecked == 0) {
          $(allSelector).prop("checked", true);
        }
      }
      else {
        $(allSelector).prop("checked", false);
      }
    });
  },

  initAdmin: function() {
    let selectedTable = sessionStorage.getItem('selectedAdminTable');
    if (selectedTable == null) {
      selectedTable = 'users';
      sessionStorage.setItem('selectedAdminTable', 'users');
    }
    // Bind click handlers to each table radio button in the admin section
    $('input[name=table]').on('click', function(event) {
      let table = $(this).val(),
          resource = table.replace(/_/g, '-');
      // Get the records for the chosen table
      $.get('/' + resource, function(data) {
        sessionStorage.setItem('selectedAdminTable', table);
        // Hide any popover if showing, otherwise the open popover will remain
        // on screen after the user has changed tables.
        $('.popover').hide();

        $('#record-container').replaceWith(data);

        // If this is the prefixes table, bind click handlers to
        // legacy checkboxes and set up the popovers
        if (table === 'prefixes') {
          jitterbug.toggleLegacy();
          jitterbug.initAdminEditableFields(resource);
          // This is one of the reference tables. Set up the 'new record' popover
          // first, then set up the field popovers.
        } else {
          jitterbug.initAdminEditableFields(resource);
        }
      });
    });

    // Change to the selected table
    $('input[name=table]').each(function() {
      if ($(this).val() == selectedTable) {
        $(this).trigger('click');
      }
    });
  },

  toggleAdmin: function(user_id) {
    let user = $(`#${user_id}`);
    let makeAdmin = user.is(':checked');
    let route = makeAdmin ? '/admin/make-admin'
        : '/admin/remove-admin';
    let username = user.data('username');
    let data = {};
    data['username'] = username;
    $.post(route, data, function (data) {
      let message = makeAdmin
          ? 'User ' + username + ' was successfully made admin.'
          : 'User ' + username + ' is no longer an admin.';
      $(window).scrollTop(0);
      jitterbug.displayAlert('success', message);
    })
        .fail(function (jqXHR) {
          // Validation error
          if (jqXHR.status === 422) {
            let errors = JSON.parse(jqXHR.responseText);
            let errorMessage = errors['errors']['name'][0];
            // Get the first error, no matter which it is.

            // Unfortunately, we have to hide the popover here
            // because it doesn't stay pinned to the field it
            // relates to when the alert div is opened (a bug
            // in Bootstrap/Tether).
            jitterbug.displayAlert('danger', '<strong>Whoops.</strong> ' + errorMessage);
          }
        });
  },

  toggleInactive: function(user_id) {
    let user = $(`#${user_id}`);
    let makeInactive = user.is(':checked');
    let route = makeInactive ? '/users/inactivate'
        : '/users/reactivate';
    let username = user.data('username');
    let data = {};
    let row = user.closest('tr');
    let id = row.data('id');
    let adminCheckbox = row.find('.admin input:checkbox');
    data['id'] = id;
    $.post(route, data, function (data) {
      let numberDeleted = data['marksDeleted'];
      let message = '';
      if (makeInactive) {
        // when inactivating the user, uncheck and disable admin checkbox
        adminCheckbox.prop('checked', false);
        adminCheckbox.attr('disabled', true);
        row.addClass('inactive-row');
        message = `User ${username} was successfully inactivated. 
              ${numberDeleted} of their marks were deleted.`;
      } else {
        adminCheckbox.attr('disabled', false);
        row.removeClass('inactive-row');
        message = 'User ' + username + ' is now active.';
      }
      $(window).scrollTop(0);
      jitterbug.displayAlert('success', message);
    });
  },

  toggleLegacy: function() {
    let legacyCheckboxes = $('.legacy input:checkbox');
    legacyCheckboxes.on('click', function(event) {
      let makeLegacy = $(this).is(':checked');
      let route = makeLegacy ? '/prefixes/set-legacy-status'
          : '/prefixes/remove-legacy-status';
      let data = {};
      data['id'] = $(this).data('id');
      $.post(route, data, function(data) {
        let message = makeLegacy
            ? 'That prefix was successfully made legacy.'
            : 'That prefix is no longer legacy.';
        jitterbug.displayAlert('success', message);
      });
    });
  },

  initAdminEditableFields: function(resource) {
    $('#new-record-button').popover({
      // Setting the 'container' option here doesn't work with Bootstrap
      // alpha 2
      placement: 'bottom',
      html: true,
      content: $('#new-record-form').html()
    }).on('click', function(event) {
      event.preventDefault();
      let button = this;
      // Because setting the container option is broken, we have to resort
      // to this ugliness to style the popover with an unlimited max-width
      // (for our inline form) for only this use.
      let popover = $('#' + $(this).attr('aria-describedby'));
      popover.css('max-width', 'none');
      // This causes the popover to redraw properly centered after the
      // max-width was changed. This must be popover('show') rather than
      // popover('toggle').
      $(button).popover('show');

      // Hookup the new record popover form submit
      popover.find('form').submit(function(event) {
        event.preventDefault();
        let form = $(this).serialize();

        // Disable submit buttons and start the spinner
        let submitButton = $(this).find('button[type="submit"]');
        let cancelButton = $(this).find('button.cancel-new-record');
        submitButton.attr('disabled', true);
        cancelButton.attr('disabled', true);
        let icon = submitButton.find('i');
        icon.removeClass('fa-check');
        icon.addClass('fa-spinner').addClass('fa-pulse');

        $.ajax({
          url: '/' + resource,
          type: 'post',
          data: form,
          success: function (data) {
            let tableContainer = $('#table-container');
            // Scroll the table div to the top to show the new record
            tableContainer.animate({ scrollTop: 0 });

            // Use the first row of the table as a template
            let templateRow = tableContainer.find('tbody > tr:first').clone();
            templateRow.find('[data-field]').each(function() {
              let field = $(this).attr('data-field');
              $(this).attr('data-id', data.id);
              // If field is empty, add non-breaking spaces so
              // there is something to click on
              let newCellValue = data[field] === '' ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : data[field];
              // if it's the collection type ID column, display the name instead of the ID
              if (field === 'collection_type_id') {
                newCellValue = data['collectionTypeName']
              } else if (field === 'prefixes') {
                newCellValue = "Please add prefixes.";
              }
              $(this).html(newCellValue);

              // Hookup the new field popovers
              if ($(this).hasClass('editable')) {
                jitterbug.createAdminEditableFieldPopover(resource, this);
              }
            });
            let deleteAnchor = templateRow.find('.delete');
            jitterbug.bindAdminRecordDelete(resource, deleteAnchor);

            // Insert row
            templateRow.prependTo('#table-container > table > tbody');
          },
          error: function (jqXHR, textStatus, error) {
            // Validation error
            if (jqXHR.status === 422) {
              let errors = JSON.parse(jqXHR.responseText);
              let errorMessage = errors['errors']['name'][0];
              // Get the first error, no matter which it is.

              // Unfortunately, we have to hide the popover here
              // because it doesn't stay pinned to the field it
              // relates to when the alert div is opened (a bug
              // in Bootstrap/Tether).
              jitterbug.displayAlert('danger',
                  '<strong>Whoops.</strong> ' + errorMessage);
            } else {
              jitterbug.displayAlert('danger',
                  '<strong>Uh oh.</strong> An error has occurred: ' + error);
            }
          },
          complete: function() {
            $(button).popover('hide');
          }
        });
      });
    });

    let body_events = $('body');
    // This will hide the 'create new record' popover, canceling the create
    body_events.on('click', '.cancel-new-record', function(event) {
      event.preventDefault();
      $('#new-record-button').popover('hide');
    });

    // There is a bug in Bootstrap 4 where manually hiding a popover
    // (as we do above) will cause the popover to require 2 clicks to
    // show again:
    // https://github.com/twbs/bootstrap/issues/16732
    body_events.on('hidden.bs.popover', function (event) {
      // This hack fixes the bug referenced above
      $(event.target).data('bs.popover')._activeTrigger.click = false;
    });

    // Hookup the field popovers
    $('.editable').each(function() {
      jitterbug.createAdminEditableFieldPopover(resource, this);
    });

    // Hookup the delete x's
    $('.delete').each(function() {
      jitterbug.bindAdminRecordDelete(resource, this);
    });

    // This will hide any editable field popover, canceling the edit
    body_events.on('click', '.cancel-edit', function(event) {
      event.preventDefault();
      let popover = $(this).closest('.popover');
      popover.popover('hide');
    });

    // When a new popover is opened, hide any already opened.
    body_events.on('show.bs.popover', function (event) {
      let target = event.target;
      $('.editable').each(function() {
        if ($(this).is(target)) {
          return true;
        } else {
          if ($(this).attr('aria-describedby')) {
            $(this).popover('hide');
          }
        }
      });
      if (!$('#new-record-button').is(target)) {
        $('#new-record-button').popover('hide');
      }
    });

    // Hide all popovers when the table div is scrolled
    $('#table-container').scroll(function() {
      $('.editable').popover('hide');
    });
  },

  createAdminEditableFieldPopover: function(resource, span) {
    let fieldName = $(span).data('field'),
        fieldText = $(span).text().trim(),
        formSelector = '#edit-' + fieldName + '-form',
        field = $(formSelector + ' input[name=' + fieldName + ']');
    // Must use .attr() method here instead of .val() otherwise it
    // doesn't change the html.
    field.attr('value', fieldText);
    $(span).popover({
      placement: 'bottom',
      html: true,
      content: $(formSelector).html()
    }).on('click', function(event) {
      event.preventDefault();
      let fieldSpan = this;

      $(this).popover('show');
      // The popover doesn't exist until the user has clicked the
      // field, and the aria-describedby attribute (which is the
      // popover id) is undefined until the popover has been
      // shown.
      let popover = $('#' + $(this).attr('aria-describedby'));
      popover.css('max-width', 'none');

      // Must show again to redraw after max-width has changed
      $(this).popover('show');

      // Must update the popover input field with the current
      // value of the field in case the user has changed the
      // value, and then reopens the popover.
      let popoverInput =
          popover.find('input[name=' + fieldName + ']');
      popoverInput.attr('value', $(fieldSpan).text().trim());

      // Hookup the field popover form submit
      popover.find('form').submit(function(event) {
        event.preventDefault();
        // This needs to be attr('data-id') instead of .data('id')
        let id = $(fieldSpan).attr('data-id'),
            // we assume it's not a dropdown
            dropdownSelect = false,
            // Get field value set by the user
            formInputVal = $(this).find('input[name=' + fieldName + ']').val();
        // If it's undefined, then it's a dropdown field
        if (formInputVal === undefined ) {
          formInputVal = parseInt($(this).find(':selected').val());
          dropdownSelect = true;
          let formInputText = $(this).find(':selected').text();
        }
        data = {};
        data[fieldName] = formInputVal;

        // Disable submit buttons and start the spinner
        let submitButton = $(this).find('button[type="submit"]');
        let cancelButton = $(this).find('button.cancel-edit');
        submitButton.attr('disabled', true);
        cancelButton.attr('disabled', true);
        let icon = submitButton.find('i');
        icon.removeClass('fa-check');
        icon.addClass('fa-spinner').addClass('fa-pulse');

        $.ajax({
          url: '/' + resource + '/' + id,
          type: 'put',
          data: data,
          success: function (data) {
            // If ajax is successful we need to change the cell value
            // to the new value. the default is an empty space
            // if the input was a select, we need the text, not the value
            let newCellValue = formInputVal === '' ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : formInputVal;
            if (dropdownSelect === true) {
              newCellValue = formInputText;
            }
            $(fieldSpan).html(newCellValue);

            // If the user just edited an id field (allowed only
            // on the collections table) we need to update the DOM
            // elements that reference the old id with the new id.
            if (fieldName == 'id') {
              $('.editable[data-id="'+ id +'"]')
                  .attr('data-id', formInputVal);
            }
          },
          error: function (jqXHR, textStatus, error) {
            // Validation error
            if (jqXHR.status==422) {
              let errors = JSON.parse(jqXHR.responseText);
              // Get the first error, no matter which field it is for.
              for (let key in errors) if (errors.hasOwnProperty(key)) break;
              jitterbug.displayAlert('danger',
                  '<strong>Whoops.</strong> ' + errors[key]);
            } else {
              jitterbug.displayAlert('danger',
                  '<strong>Uh oh.</strong> An error has occurred: ' + error);
            }
          },
          complete: function() {
            // Unfortunately, this will also hide the popover on
            // validation error because it doesn't stay pinned to the
            // field it relates to when the alert div is opened for
            // display of the error (a bug in Bootstrap/Tether).
            $(fieldSpan).popover('hide');
          }
        });
      });
    });
  },

  bindAdminRecordDelete: function(resource, anchor) {
    $(anchor).on('click', function(event) {
      event.preventDefault();

      let row = $(this).closest('tr');
      let id = row.find('.editable').first().attr('data-id');

      $.ajax({
        url: '/' + resource + '/' + id,
        type: 'delete',
        success: function (data) {
          let additionalMessage = data['message'] === undefined ? '' : data['message'];
          row.remove();
          jitterbug.displayAlert('success',
              '<strong>Gone.</strong> The record was successfully deleted. ' + additionalMessage);
        },
        error: function (jqXHR, textStatus, error) {
          // Validation error
          if (jqXHR.status==422) {
            let errors = JSON.parse(jqXHR.responseText);
            // Get the first error
            for (let key in errors) if (errors.hasOwnProperty(key)) break;
            jitterbug.displayAlert('danger',
                '<strong>Hmm.</strong> ' + errors[key]);
          } else {
            jitterbug.displayAlert('danger',
                '<strong>Uh oh.</strong> An error has occurred: ' + error);
          }
        }
      });

    });
  },

  initPrefixActions: function() {
    // Hookup the delete x's
    $('.delete').each(function() {
      jitterbug.bindFormatPrefixDetachment(this);
    });
    jitterbug.handlePrefixAttachmentForm();
    jitterbug.initChosenMultiSelect('.chosen-select', {width: '500px'}, {width: '500px'})
  },

  initChosenMultiSelect: function(selector, options, deselectOptions) {
    $(document).ready(function() {
      $(selector).chosen(options);
      $('.chosen-select-deselect').chosen(deselectOptions);
    });
  },

  handlePrefixAttachmentForm: function() {
    $('#prefix-attach-form').submit(function(event) {
      event.preventDefault();

      let dropdown = $(this).find('select');
      let prefixIds = dropdown.val();
      let id = $(this).attr('data-format-id');
      let url = window.location.href;

      let data = {
        'id': id,
        'prefixIds': prefixIds
      };

      $.ajax({
        url: '/formats/attach_prefixes',
        type: 'POST',
        data: data,
        success: function () {
          // clear out dropdown selections
          dropdown.val('');
          jitterbug.displayAlert('success',
              'The prefixes were successfully attached.');
          $('#data-panel').load(url + ' #data-panel', function() {
            // re-enable prefix actions
            jitterbug.initPrefixActions();
          });
        },
        error: function (jqXHR, textStatus, error) {
          jitterbug.displayAlert('danger', '<strong>Uh oh.</strong> An error has occurred: ' + error);
        }
      });
    });
  },

  bindFormatPrefixDetachment: function(anchor) {
    $(anchor).on('click', function(event) {
      event.preventDefault();

      let row = $(this).closest('tr');
      let data = {
        'id': row.attr('data-format-id'),
        'prefixId': row.attr('data-prefix-id')
      };

      $.ajax({
        url: '/formats/detach_prefixes',
        type: 'POST',
        data: data,
        success: function () {
          row.remove();
          jitterbug.displayAlert('success',
              '<strong>Gone.</strong> The prefix was successfully detached.');
        },
        error: function (jqXHR, textStatus, error) {
          jitterbug.displayAlert('danger', '<strong>Uh oh.</strong> An error has occurred: ' + error);
        }
      });

    });
  },

  initDashboardCharts: function() {
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(jitterbug.drawDashboardCharts);
  },

  drawDashboardCharts: function() {
    let itemChart = $('#item-chart');
    let itemCounts = itemChart.data('counts').split(',').map(Number);
    let itemData = new google.visualization.DataTable();
    itemData.addColumn('string', 'Type');
    itemData.addColumn('number', 'Count');
    itemData.addRows([
      ['Audio', itemCounts[0]],
      ['Film', itemCounts[1]],
      ['Video', itemCounts[2]],
    ]);

    let instanceChart = $('#instance-chart');
    let instanceCounts = instanceChart.data('counts').split(',').map(Number);
    let instanceData = new google.visualization.DataTable();
    instanceData.addColumn('string', 'Type');
    instanceData.addColumn('number', 'Count');
    instanceData.addRows([
      ['Audio', instanceCounts[0]],
      ['Film', instanceCounts[1]],
      ['Video', instanceCounts[2]],
    ]);

    let transferChart = $('#transfer-chart');
    let transferCounts = transferChart.data('counts').split(',').map(Number);
    let transferData = new google.visualization.DataTable();
    transferData.addColumn('string', 'Type');
    transferData.addColumn('number', 'Count');
    transferData.addRows([
      ['Audio', transferCounts[0]],
      ['Film', transferCounts[1]],
      ['Video', transferCounts[2]],
    ]);

    let options = {
      width: 200,
      height: 200,
      legend: 'none',
      fontName: 'Source Sans Pro',
      fontSize: 12,
      chartArea: {width: '80%', height: '80%'},
      colors: ['#317da1', '#d1a842', '#d16642']
    };

    itemChart = new google.visualization.PieChart(itemChart[0]);
    itemChart.draw(itemData, options);

    instanceChart = new google.visualization.PieChart(instanceChart[0]);
    instanceChart.draw(instanceData, options);

    transferChart = new google.visualization.PieChart(transferChart[0]);
    transferChart.draw(transferData, options);
  },

  initDashboardActivityStream: function() {
    $('.recent-activity li[role="button"]').on('click', function(event) {
      let type = $(this).data('object-type'),
          id = $(this).data('object-id');
      window.location.href='/' + type + 's/' + id;
    });
  },

  initDashboardMarks: function() {
    let marksModule = jitterbug.MarksModule.load('dashboardMarks', 'session');
    if (marksModule == null) {
      marksModule = new jitterbug.MarksModule({
        key: 'dashboardMarks',
        location: 'session',
        marksContainer: '.marks',
        marksSelector: '.marks li[role="button"]',
        noMarksSelector: '.no-marks',
        filtersSelector: '#marks-filters label',
        usersSelector: '.marks-user',
        selectedUserSelector: '#selected-marks-user'
      });
    }
    marksModule.init();
    marksModule.store();
  },

  /*
   * These properties are set to deserialized instances for each
   * index page (items, instances, and transfers). They aren't used
   * for other pages.
   */
  searchField: null,
  filterPanel: null,
  tableParams: null,
  tableSelection: null,
  queryManager: null,
  /*
   * This is used to determine, when a data import modal is closed,
   * if the page should be refreshed. It is set to true when a data
   * import is successfully executed.
   */
  dataImported: false,

  initItemsNewButton: function() {
    $('#items-new').on('click', function(event) {
      jitterbug.tableSelection.clear();
    });
  },

  initItemsBatchMenu: function() {
    $('#items-batch-edit').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      let maxEditLimit = $(this).data('max-edit-limit');
      if (!jitterbug.validateBatchSelection(tableSelection, 'editing', maxEditLimit)) {
        return;
      }
      jitterbug.submitBatchEditForm('items', tableSelection);
    });

    jitterbug.initDataExportModal('items');
    $('#items-batch-export').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'exporting')) {
        return;
      }
      jitterbug.openDataExportModal('items', tableSelection);
    });

    $('#items-batch-mark').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'marking', 100)) {
        return;
      }
      jitterbug.batchMark('items', 'AudioVisualItem', tableSelection);
    });

    $('#items-batch-unmark').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'unmarking', 100)) {
        return;
      }
      jitterbug.batchUnmark('items', 'AudioVisualItem', tableSelection);
    });

    $('#items-batch-delete').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'deleting', 100)) {
        return;
      }
      $('#confirm-batch-delete-modal').modal('toggle');
      $('#batch-delete-form input[name="ids"]').val(tableSelection.selectedIds());
    });

    $('#items-batch-items-import').on('click', function(event) {
      $('#items-import-modal').modal('toggle');
    });
  },

  initItemsImportModal: function() {
    jitterbug.initDataUploadForm('items');
    jitterbug.initDataImportForm('items');

    // Click handlers for 'start over' links and buttons
    $('#items-import-modal .reset').on('click', function(event) {
      event.preventDefault();
      jitterbug.resetDataImportModal('items');
    });

    // Clean up when modal is closed
    $('#items-import-modal').on('hide.bs.modal', function () {
      jitterbug.resetDataImportModal('items');
      if (jitterbug.dataImported) {
        location.reload();
      }
    });
  },

  initItemSuggestions: function() {
    $('#recording-location').autocomplete({
      serviceUrl: '/suggestions/recording-locations',
      deferRequestBy: 100
    });

    $('#speed').autocomplete({
      serviceUrl: '/suggestions/speeds',
      deferRequestBy: 100
    });

    $('#track-configuration').autocomplete({
      serviceUrl: '/suggestions/track-configurations',
      deferRequestBy: 100
    });

    $('#audio-base').autocomplete({
      serviceUrl: '/suggestions/audio-bases',
      deferRequestBy: 100
    });

    $('#film-element').autocomplete({
      serviceUrl: '/suggestions/film-elements',
      deferRequestBy: 100
    });

    $('#film-base').autocomplete({
      serviceUrl: '/suggestions/film-bases',
      deferRequestBy: 100
    });
  },

  initItemTypeControls: function() {
    $('#detail #item-type-controls :radio').on('click', function(event) {
      if ($(this).val()=='AudioItem') {
        $('#audio-form').show();
        $('#film-form').hide();
        $('#video-form').hide();
      } else if ($(this).val()=='FilmItem') {
        $('#audio-form').hide();
        $('#film-form').show();
        $('#video-form').hide();
      } else if ($(this).val()=='VideoItem') {
        $('#audio-form').hide();
        $('#film-form').hide();
        $('#video-form').show();
      }
    });
  },

  initItemCallNumberGeneration: function() {
    $('#collection-id, #format-id').on('change', function() {
      let collectionId = $('#collection-id').val();
      let formatId = $('#format-id').val();
      if (collectionId.length && formatId.length) {
        query = {};
        query['format'] = formatId;
        query['collection'] = collectionId;
        $.get('/call-numbers/generate', query, function(data) {
          $('#call-number').val(data['callNumber']);
        }).fail(function() {
          console.log('Call number generation failure.');
          $('#call-number').val('');
        });
      } else {
        $('#call-number').val('');
      }
    });
  },

  initInstancesNewButton: function() {
    $('#instances-new').on('click', function(event) {
      jitterbug.tableSelection.clear();
    });
  },

  initInstancesBatchMenu: function() {
    $('#instances-batch-edit').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      let maxEditLimit = $(this).data('max-edit-limit');
      if (!jitterbug.validateBatchSelection(tableSelection, 'editing', maxEditLimit)) {
        return;
      }
      jitterbug.submitBatchEditForm('instances', tableSelection);
    });

    jitterbug.initDataExportModal('instances');
    $('#instances-batch-export').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'exporting')) {
        return;
      }
      jitterbug.openDataExportModal('instances', tableSelection);
    });

    $('#instances-batch-mark').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'marking', 100)) {
        return;
      }
      jitterbug.batchMark('instances', 'PreservationInstance', tableSelection);
    });

    $('#instances-batch-unmark').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'unmarking', 500)) {
        return;
      }
      jitterbug.batchUnmark('instances', 'PreservationInstance', tableSelection);
    });

    $('#instances-batch-delete').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'deleting', 100)) {
        return;
      }
      $('#confirm-batch-delete-modal').modal('toggle');
      $('#batch-delete-form input[name="ids"]').val(
          tableSelection.selectedIds());
    });
  },

  initInstanceTypeControls: function() {
    $('#detail #instance-type-controls :radio').on('click', function(event) {
      if ($(this).val()=='AudioInstance') {
        $('#audio-form').show();
        $('#film-form').hide();
        $('#video-form').hide();
      } else if ($(this).val()=='FilmInstance') {
        $('#audio-form').hide();
        $('#film-form').show();
        $('#video-form').hide();
      } else if ($(this).val()=='VideoInstance') {
        $('#audio-form').hide();
        $('#film-form').hide();
        $('#video-form').show();
      }
    });
  },

  initInstanceBatchCheckbox: function() {
    $('#batch-checkbox').on('change', function(event) {
      $('#fileName').attr('readonly', $(this).is(':checked'));
      $('#fileName').val('');
    });
  },

  initTransfersNewButton: function() {
    $('#transfers-new').on('click', function(event) {
      jitterbug.tableSelection.clear();
    });
  },

  initTransfersBatchMenu: function() {
    $('#transfers-batch-edit').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      let maxEditLimit = $(this).data('max-edit-limit');
      if (!jitterbug.validateBatchSelection(tableSelection, 'editing', maxEditLimit)) {
        return;
      }
      jitterbug.submitBatchEditForm('transfers', tableSelection);
    });

    jitterbug.initDataExportModal('transfers');
    $('#transfers-batch-export').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'exporting')) {
        return;
      }
      jitterbug.openDataExportModal('transfers', tableSelection);
    });

    $('#transfers-batch-mark').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'marking', 100)) {
        return;
      }
      jitterbug.batchMark('transfers', 'Transfer', tableSelection);
    });

    $('#transfers-batch-unmark').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'unmarking', 500)) {
        return;
      }
      jitterbug.batchUnmark('transfers', 'Transfer', tableSelection);
    });

    $('#transfers-batch-delete').on('click', function(event) {
      let tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'deleting', 100)) {
        return;
      }
      $('#confirm-batch-delete-modal').modal('toggle');
      $('#batch-delete-form input[name="ids"]').val(tableSelection.selectedIds());
    });

    $('#transfers-batch-audio-import').on('click', function(event) {
      $('#audio-import-modal').modal('toggle');
    });

    $('#transfers-batch-video-import').on('click', function(event) {
      $('#video-import-modal').modal('toggle');
    });
  },

  initTransferTypeControls: function() {
    $('#detail #transfer-type-controls :radio').on('click', function(event) {
      if ($(this).val()=='AudioTransfer') {
        $('#audio-form').show();
        $('#film-form').hide();
        $('#video-form').hide();
      } else if ($(this).val()=='FilmTransfer') {
        $('#audio-form').hide();
        $('#film-form').show();
        $('#video-form').hide();
      } else if ($(this).val()=='VideoTransfer') {
        $('#audio-form').hide();
        $('#film-form').hide();
        $('#video-form').show();
      }
    });
  },

  initTransferCallNumberQuery: function() {
    $('#preservation-instance-id').on('change', function() {
      let preservationInstanceId = $('#preservation-instance-id').val();
      if (preservationInstanceId.length) {
        query = {};
        query['preservation-instance-id'] = preservationInstanceId;
        $.get('/call-numbers/for-pm', query, function(data) {
          $('#call-number').val(data['callNumber']);
        }).fail(function() {
          console.log('Could not resolve PM to a call number.');
          $('#call-number').val('');
        });
      } else {
        $('#call-number').val('');
      }
    });
  },

  initBatchDeleteForm: function() {
    $('#batch-delete-form button[type="submit"]').on('click', function() {
      $(this).attr('clicked', 'true');
    });
    $('#batch-delete-form').submit( function(event) {
      jitterbug.tableSelection.clear();
      jitterbug.tableParams.setPage(1);
      let submitButtons = $(this).find('button[type="submit"]');
      let deleteCommand = $(this).find('button[type="submit"][clicked="true"]').val();
      $(this).find('input[name="deleteCommand"]').val(deleteCommand);
      submitButtons.attr('disabled', true);
    });
  },

  initAudioImportModal: function() {
    jitterbug.initDataUploadForm('audio');
    jitterbug.initDataImportForm('audio');

    // Click handlers for 'start over' links and buttons
    $('#audio-import-modal .reset').on('click', function(event) {
      event.preventDefault();
      jitterbug.resetDataImportModal('audio');
    });

    // Clean up when modal is closed
    $('#audio-import-modal').on('hide.bs.modal', function () {
      jitterbug.resetDataImportModal('audio');
      if (jitterbug.dataImported) {
        location.reload();
      }
    });
  },

  initVideoImportModal: function() {
    jitterbug.initDataUploadForm('video');
    jitterbug.initDataImportForm('video');

    // Click handlers for 'start over' links and buttons
    $('#video-import-modal .reset').on('click', function(event) {
      event.preventDefault();
      jitterbug.resetDataImportModal('video');
    });

    // Clean up when modal is closed
    $('#video-import-modal').on('hide.bs.modal', function () {
      jitterbug.resetDataImportModal('video');
      if (jitterbug.dataImported) {
        location.reload();
      }
    });
  },

  initFileSelect: function() {
    $(':file').on('change', function() {
      let input = $(this),
          fileName = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.trigger('fileselect', fileName);
    });
    $('#items-import-file').on('fileselect', function(event, fileName) {
      $('#items-import-filename').val(fileName);
    });
    $('#audio-import-file').on('fileselect', function(event, fileName) {
      $('#audio-import-filename').val(fileName);
    });
    $('#video-import-file').on('fileselect', function(event, fileName) {
      $('#video-import-filename').val(fileName);
    });
  },

  resetDataImportModal: function(type) {
    $('#' + type + '-import-file').val('');
    $('#' + type + '-import-filename').val('');
    $('#' + type + '-upload-form-error').html('').hide();
    $('#' + type + '-import-dialog').width(400);
    $('#' + type + '-import-dialog-content').width(400);
    $('#' + type + '-import-step-2 .modal-body').height(80);
    // In order to scroll a div, it must be visible
    $('#' + type + '-import-step-2').show();
    $('#' + type + '-import-step-2 .modal-body').scrollTop(0);
    $('#' + type + '-import-step-2 .modal-body').scrollLeft(0);
    $('#' + type + '-import-step-1').show();
    $('#' + type + '-import-step-2').hide();
    $('#' + type + '-import-step-2 .success-actions').show();
    $('#' + type + '-import-step-2 .failure-actions').hide();
    $('#' + type + '-import-step-3').show();
    $('#' + type + '-import-step-3 .modal-body').scrollTop(0);
    $('#' + type + '-import-step-3 .modal-body').scrollLeft(0);
    $('#' + type + '-import-step-3').hide();
  },

  initDataUploadForm: function(type) {
    jitterbug.initFileSelect();

    $('#' + type + '-upload-form').submit(function(event) {
      event.preventDefault();

      if(!jitterbug.validateDataUploadForm(type)) {
        return;
      }

      $('#' + type + '-upload-spinner').show();
      let form = new FormData(this);
      $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
          console.log('upload success');
          let count = data['count'];
          if (count==0) {
            $('#' + type + '-import-step-2 .success-actions').hide();
            $('#' + type + '-import-step-2 .failure-actions').show();
          }
          // Animation is handled via CSS transition
          $('#' + type + '-import-dialog').width(700);
          $('#' + type + '-import-dialog-content').width(700);
          // Delay to let the css transition finish (hack)
          let delay = 500;
          setTimeout(function() {
            $('#' + type + '-import-step-1').hide();
            $('#' + type + '-import-step-2').show();
            $('#' + type + '-import-step-2 .modal-body').height(300);
          }, delay);

          $('#' + type + '-upload-data-container').replaceWith(data['html']);
        },
        error: function (jqXHR, textStatus, error) {
          console.log('upload failure: ' + textStatus);
          if (jqXHR.status==500) {
            $('#' + type + '-upload-form-error').html('<small>An error occurred \
              while parsing your file. Check that it\'s a \
              valid .csv file.</small>').show();
          } else {
            $('#' + type + '-upload-form-error').html('<small>An error occurred \
              while uploading your file. Refresh the page and try \
              again.</small>').show();
          }
        },
        complete: function() {
          $('#' + type + '-upload-spinner').hide();
        }
      });
    });
  },

  initDataImportForm: function(type) {
    $('#' + type + '-import-form').submit( function(event) {
      event.preventDefault();

      let submitButton = $(this).find('button[type="submit"]');
      submitButton.attr('disabled', true);

      $('#' + type + '-import-spinner').show();
      let form = new FormData(this);
      $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
          let status = data['status'];

          $('#' + type + '-import-result-container').replaceWith(data['html']);
          $('#' + type + '-import-step-2').hide();
          $('#' + type + '-import-step-3 .modal-body').height(300);
          $('#' + type + '-import-step-3').show();
          if (status=='success') {
            $('#' + type + '-import-step-3 .modal-body').height(50);
            jitterbug.dataImported = true;
          }
          // Initialize popovers which contain any errors
          jitterbug.initPopovers();
        },
        error: function (jqXHR, textStatus, error) {
          console.log('import failure: ' + textStatus);
        },
        complete: function() {
          $('#' + type + '-import-spinner').hide();
          submitButton.attr('disabled', false);
        }
      });
    });
  },

  validateDataUploadForm: function(type) {
    if ($('#' + type + '-import-file').val() == '' ||
        $('#' + type + '-import-filename').val() == '') {
      $('#' + type + '-upload-form-error').html('<small>Please select a \
        data file to upload.</small>').show();
      return false;
    } else if (!$('#' + type + '-import-filename').val().endsWith('.csv')) {
      $('#' + type + '-upload-form-error').html('<small>A file of type \
        .csv is required.</small>').show();
      return false;
    } else {
      $('#' + type + '-upload-form-error').html('').hide();
      return true;
    }
  },

  initDataExportModal: function(resource) {
    $('#data-export-form').submit( function(event) {
      event.preventDefault();

      // Validate that at least one field is selected
      let fieldCheckboxes =
              $('#data-export-fields-container').find(':checkbox'),
          oneIsChecked = false;
      $.each(fieldCheckboxes, function(i, checkbox) {
        if ($(this).is(':checked')) {
          oneIsChecked = true;
          return false;
        }
      });
      if (oneIsChecked) {
        $('#export-instructions').removeClass('text-danger');
      } else {
        $('#export-instructions').addClass('text-danger');
        $('#data-export-modal .modal-body').scrollTop(0);
        return;
      }

      $('#export-building-spinner').show();
      let submitButton = $(this).find('button[type="submit"]');
      submitButton.attr('disabled', true);

      // Build export file
      let form = new FormData(this);
      $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
          // File is built, now download
          let form = $(document.createElement('form'));
          form.attr('action', '/' + resource + '/batch/export-download');
          form.attr('method', 'post');
          $('<input>').attr('type', 'hidden')
              .attr('name', '_token')
              .attr('value', $('meta[name="csrf-token"]').attr('content'))
              .appendTo(form);
          form.appendTo(document.body).submit().remove();

          $('#export-building-spinner').hide();
          $('#data-export-modal .modal-body').scrollTop(0);
          $('#data-export-modal').modal('toggle');
          submitButton.attr('disabled', false);
        },
        error: function (jqXHR, textStatus, error) {
          console.log('Export failed: ' + error);
        }
      });

    });

    // Clean up when modal is closed
    $('#data-export-modal').on('hidden.bs.modal', function () {
      $('.export-modal-body').height(40);
    });
  },

  openDataExportModal: function(resource, tableSelection) {
    $('#data-export-modal').modal('toggle');

    // Get the export fields appropriate for the current selection
    $('#loading-export-fields-spinner').show();
    $.ajax({
      url: '/' + resource + '/batch/export-fields',
      type: 'post',
      data: {'ids': tableSelection.selectedIds().toString()},
      success: function (data) {
        $('#data-export-fields-container').replaceWith(data);
        let delay = 200;
        setTimeout(function() {
          $('.export-modal-body').height(220);
        }, delay);
        $('#data-export-form input[name="ids"]').val(
            tableSelection.selectedIds());
        jitterbug.initSelectAll('#checkedAll', ".checkSingle");
      },
      error: function (jqXHR, textStatus, error) {
        console.log('Could not fetch export fields: ' + error);
      },
      complete: function() {
        $('#loading-export-fields-spinner').hide();
      }
    });
  },

  validateBatchSelection: function(tableSelection, action, max) {
    if (tableSelection.count() == 0) {
      jitterbug.displayAlert('warning',
          '<strong>Here\'s a tip:</strong> Batch actions require a table \
          selection. Make a selection by \'shift-clicking\' \
          or \'command-clicking\' on rows of the table.');
      return false;
    }
    // APPDEV-6771 - Allow exporting only 1 record
    if (tableSelection.count() == 1 && action != 'exporting') {
      jitterbug.displayAlert('warning',
          '<strong>More please!</strong> Batch actions require at least \
          2 records to be selected. Make a selection by \
          \'shift-clicking\' or \'command-clicking\' on rows of the table.');
      return false;
    }
    if (tableSelection.count() > max) {
      jitterbug.displayAlert('warning',
          '<strong>Whoa there!</strong> Batch ' + action + ' is limited \
        to ' + max + ' records at a time. Please narrow your selection.');
      return false;
    }
    return true;
  },

  submitBatchEditForm: function(resource, tableSelection) {
    let form = $(document.createElement('form'));
    form.attr('action', '/' + resource + '/batch/edit');
    form.attr('method', 'post');
    $('<input>').attr('type', 'hidden')
        .attr('name', 'ids')
        .attr('value', tableSelection.selectedIds())
        .appendTo(form);
    $('<input>').attr('type', 'hidden')
        .attr('name', '_token')
        .attr('value', $('meta[name="csrf-token"]').attr('content'))
        .appendTo(form);
    form.appendTo(document.body).submit().remove();
  },

  initMarkRibbon: function() {
    $('.mark').on('click', function(event) {
      let mark = $(this);
      let data = {};
      data['markableType'] = mark.data('markable-type');
      data['markableIds'] = [mark.data('markable-id')];

      if (mark.hasClass('marked')) {
        data['_method'] = 'DELETE';
        $.post('/marks', data, function(data) {
          mark.removeClass('marked');
        });
      } else {
        $.post('/marks', data, function(data) {
          mark.addClass('marked');
        });
      }
    });
  },

  batchMark: function(resourceName, type, tableSelection) {
    let data = {};
    data['markableType'] = type;
    data['markableIds'] = tableSelection.selectedIds();
    $.post('/marks', data, function(data) {
      // Render marks currently in view in the data table
      $('#' + resourceName + '-data tr[role="button"]').each(function() {
        let id = $(this).data('id');
        if ($.inArray(id, tableSelection.selectedIds()) != -1) {
          $(this).addClass('marked');
        }
      });
    });
  },

  batchUnmark: function(resourceName, type, tableSelection) {
    let data = {};
    data['markableType'] = type;
    data['markableIds'] = tableSelection.selectedIds();
    data['_method'] = 'DELETE';
    $.post('/marks', data, function(data) {
      // Remove marks currently in view in the data table
      $('#' + resourceName + '-data tr[role="button"]').each(function() {
        let id = $(this).data('id');
        if ($.inArray(id, tableSelection.selectedIds()) != -1) {
          $(this).removeClass('marked');
        }
      });
    });
  },

  initPopovers: function() {
    $('[data-toggle="popover"]').popover();
  },

  initDatepicker: function() {
    $('#detail .input-group.date').datepicker({
      format: "yyyy-mm-dd"
    });
  },

  // When a user batch edits records, some form fields will
  // be set to a value of <mixed>, meaning that those
  // fields differ across the batch. When a user
  // changes one of the <mixed> fields to something
  // else, we want to give them an easy way to reset
  // the field back to the magic value, which we will
  // do with the addition of a 'reset' icon after they
  // have changed the value.
  initBatchEditMixed: function() {
    $("input[value='<mixed>']").on('change', function() {
      jitterbug.handleMixedValueChange(this);
    });

    $('textarea').filter(function () {
      return $(this).val() === '<mixed>';
    }).on('change', function() {
      jitterbug.handleMixedValueChange(this);
    });

    $('select:has(option[value="<mixed>"]:selected)').on('change', function() {
      jitterbug.handleMixedValueChange(this);
    });
  },

  sequence: 0,

  handleMixedValueChange: function(that) {
    let input = $(that);
    let parent = $(that).closest('.detail-value');
    if ($(that).val() !== '<mixed>' && parent.hasClass('col-xs-7')) {
      parent.removeClass('col-xs-7');
      parent.addClass('col-xs-6');
      let divId = jitterbug.sequence++, linkId = jitterbug.sequence++;
      parent.after('\
        <div id=' + divId + ' class="col-xs-1 detail-value">\
          <a id=' + linkId + ' href="#" title="Reset">\
            <i class="fa fa-reply" aria-hidden="true"></i>\
          </a>\
        </div>\
      ');
      $('#' + linkId + '').on('click', function(event) {
        $('#' + divId + '').remove();
        parent.removeClass('col-xs-6');
        parent.addClass('col-xs-7');
        input.val('<mixed>');
        event.preventDefault();
      });
    } else if ($(that).val() === '<mixed>' && parent.hasClass('col-xs-6')) {
      parent.next().remove();
      parent.removeClass('col-xs-6');
      parent.addClass('col-xs-7');
    }
  },

  initTableKeyboardShortcuts: function() {
    $(document).keydown(function(event) {
      // If search input is focused, return
      if ($('#search').is(':focus') && $('#search').val() != '') {
        return;
      }
      let modalOpen = false;
      $('.modal').each(function() {
        if ($(this).is(':visible')) {
          modalOpen = true;
          return false;
        }
      });
      if (!modalOpen) {
        // Right arrow
        if (event.which == 39) {
          $('.next-page').first().trigger('click');
          // Left arrow
        } else if (event.which == 37) {
          $('.prev-page').first().trigger('click');
          // Cmd/ctrl-a (select all)
        } else if (event.which == 65 && (event.ctrlKey || event.metaKey)) {
          event.preventDefault();
          jitterbug.tableSelection.selectAll();
          // Escape (deselect all)
        } else if (event.which == 27) {
          jitterbug.tableSelection.clear();
          jitterbug.tableSelection.render();
        }
      }
    });
  },

  initRevisionHistory: function() {
    $('.revision-history-title').on('click', function(event) {
      event.preventDefault();
      let icon = $('.revision-history-title i');
      if (icon.hasClass('fa-caret-right')) {
        icon.removeClass('fa-caret-right');
        icon.addClass('fa-caret-down');
      } else {
        icon.removeClass('fa-caret-down');
        icon.addClass('fa-caret-right');
      }
      $('.revision-history').slideToggle(200);
    });
  },

  initRelatedPreservationInstances: function() {
    $('#related-instances tr[role="button"]').on('click', function(event) {
      window.location.href='/instances/' + $(this).data('id');
    });
  },

  initRelatedCuts: function() {
    $('#related-cuts tr[role="button"]').on('click', function(event) {
      window.location.href='/cuts/' + $(this).data('id') + '?instanceId=' + $(this).data('instance');
    });
  },

  initRelatedTransfers: function() {
    $('#related-transfers tr[role="button"]').on('click', function(event) {
      window.location.href='/transfers/' + $(this).data('id');
    });
  },

  initIndexPage: function(resourceName) {
    let searchField = jitterbug.SearchField.load(resourceName + 'SearchField');
    if (searchField==null) {
      searchField = new jitterbug.SearchField({
        key:resourceName + 'SearchField',
        selector:'#search'});
      searchField.init();
      searchField.store();
    } else {
      searchField.init();
    }
    jitterbug.searchField = searchField;

    let filterPanel = jitterbug.FilterPanel.load(resourceName + 'FilterPanel');
    if (filterPanel==null) {
      filterPanel = new jitterbug.FilterPanel({
        key:resourceName + 'FilterPanel',
        selector:'#filter-panel',
        listSelector: '.filter-list'});
      filterPanel.init();
      filterPanel.store();
    } else {
      filterPanel.init();
    }
    jitterbug.filterPanel = filterPanel;

    let tableParams = jitterbug.TableParams.load(resourceName + 'TableParams');
    if (tableParams==null) {
      tableParams = new jitterbug.TableParams({
        key:resourceName + 'TableParams'});
      tableParams.store();
    }
    jitterbug.tableParams = tableParams;

    let tableSelection =
        jitterbug.TableSelection.load(resourceName + 'TableSelection','session');
    if (tableSelection==null) {
      tableSelection = new jitterbug.TableSelection({
        key:resourceName + 'TableSelection',
        resource: resourceName,
        location:'session',
        selector: '#' + resourceName + '-data tr[role="button"]',
        countSelector:'#data-panel .selection-count'});
      tableSelection.init();
      tableSelection.store();
    } else {
      tableSelection.init();
      tableSelection.render();
    }
    jitterbug.tableSelection = tableSelection;

    let queryManager = new jitterbug.QueryManager(searchField, filterPanel,
        tableParams, tableSelection, resourceName);
    jitterbug.tableSelection.setQueryManager(queryManager);

    queryManager.init();
    queryManager.executeQuery();

    jitterbug.queryManager = queryManager;
  },

  initItemsIndex: function() {
    jitterbug.initIndexPage('items');
  },

  initInstancesIndex: function() {
    jitterbug.initIndexPage('instances');
  },

  initTransfersIndex: function() {
    jitterbug.initIndexPage('transfers');
  },

  QueryManager: function(searchFieldInstance, filterPanelInstance,
                         tableParamsInstance, tableSelectionInstance, resourceName) {
    let searchField = searchFieldInstance,
        filterPanel = filterPanelInstance,
        tableSelection = tableSelectionInstance,
        tableParams = tableParamsInstance,
        resource = resourceName,

        init = function() {
          $.subscribe('filterPanelChanged', handleFilterPanelChanged);
          $.subscribe('searchSubmitted', handleSearchSubmitted);
        },

        handleFilterPanelChanged = function(event) {
          tableSelection.clear();
          tableParams.setPage(1);
          executeQuery();
        },

        handleSearchSubmitted = function(event) {
          tableSelection.clear();
          tableParams.setPage(1);
          executeQuery();
        },

        queryString = function() {
          let query = {};
          query['search'] = searchField.elementValue();
          query = $.extend(query, filterPanel.selectedFilters());
          return JSON.stringify(query);
        },
        // default sort is updatedAt column, descending
        executeQuery = function(sortColumn = 'updatedAt', sortDirection = 'desc') {
          let query = {};
          query['q'] = encodeURIComponent(queryString());
          query['page'] = tableParams.getPage();
          query['perPage'] = tableParams.getPerPage();
          query['sortColumn'] = sortColumn;
          query['sortDirection'] = sortDirection;

          $.get('/' + resource, query, function(data) {
            $('#data-container').replaceWith(data);

            let dataSelector = '#' + resource + '-data';
            // Initialize the colResizable plugin. Note that we're using a very
            // slightly modified version that doesn't set an explict width of the
            // grip container element.
            $(dataSelector).colResizable(
                {partialRefresh: true, postbackSafe: true, removePadding: false});

            tableSelection.init();

            $.publish('dataLoaded');

            // Bind click handlers to all data table rows
            $(dataSelector + ' tr[role="button"]').on('click', function(event) {
              tableSelection.clear();
              tableSelection.render();
              window.location.href='/' + resource + '/' + $(this).data('id');
            });

            // Bind click handler to header row for sortable columns
            $('#header-row').on('click', function(e) {
              e.preventDefault();
              const column = e.target;
              const columnName = column.getAttribute('data-sort-column');
              const currentSort = column.getAttribute('data-sort-direction');
              if (columnName !== null && currentSort !== null) {
                const toggleSort = (currentSort === "asc") ? "desc" : "asc";
                tableSelection.clear();
                tableParams.setPage(1);
                executeQuery(columnName, toggleSort);
              }
            });

            // Bind click handlers to all data pagination links
            if ($('.pagination').length) {
              let currentPage = parseInt($('.page-item.active').text().trim());
              tableParams.setPage(currentPage);
              $('.pagination').each(function() {
                $('.page-link').each(function() {
                  if ($(this).parent().hasClass('disabled') ||
                      $(this).parent().hasClass('active')) {
                    return;
                  } else if ($(this).hasClass('prev-page')) {
                    $(this).on('click', function(event){
                      event.preventDefault();
                      tableParams.setPage(currentPage - 1);
                      executeQuery(sortColumn, sortDirection);
                    });
                  } else if ($(this).hasClass('next-page')) {
                    $(this).on('click', function(event){
                      event.preventDefault();
                      tableParams.setPage(currentPage + 1);
                      executeQuery(sortColumn, sortDirection);
                    });
                  } else {
                    $(this).on('click', function(event){
                      event.preventDefault();
                      tableParams.setPage($(this).text().trim());
                      executeQuery(sortColumn, sortDirection);
                    });
                  }
                })
              });
            }
          });
        };

    return {
      init: init,
      executeQuery: executeQuery,
      queryString: queryString
    };
  },

  TableParams: function(params) {
    let key = params.key,
        location = params.location,
        page = params.page == null ? 1 : params.page,
        perPage = params.perPage == null ? 20 : params.perPage,

        allParams = function() {
          return {
            page:page,
            perPage:perPage
          };
        },

        getPage = function() {
          return page;
        },

        setPage = function(pageNum) {
          page = pageNum;
          store();
        },

        getPerPage = function() {
          return perPage;
        },

        setPerPage = function(perPageNum) {
          perPage = perPageNum;
          store();
        },

        store = function() {
          if (key != null) {
            if (location=='local' || location==null) {
              localStorage.setItem(key, toString());
            } else if (location=='session') {
              sessionStorage.setItem(key, toString());
            }
          }
        },

        toJson = function() {
          return {
            key:key,
            location:location,
            page:page,
            perPage:perPage
          };
        },

        toString = function() {
          return JSON.stringify(toJson());
        };

    return {
      allParams:allParams,
      getPage:getPage,
      setPage:setPage,
      getPerPage:getPerPage,
      setPerPage:setPerPage,
      store:store,
      toString:toString
    };
  },

  SearchField: function(params) {
    if (params==null || params.selector == null) {
      throw new jitterbug.IllegalArgumentException("Param 'selector' " +
          "is required.");
    }

    let key = params.key,
        location = params.location,
        selector = params.selector,
        value = params.value,
        lastValue = params.lastValue,

        init = function() {
          $(selector).val(value);
          // Display the clear search link if the field has contents
          if (value != '') {
            $(selector).next().find('i').show();
          }

          // Hook up the clear search link
          let clearLink = $(selector).next().find('a');
          clearLink.on('click', function(event) {
            event.preventDefault();
            $(selector).next().find('i').hide();
            $(selector).val('');
            $(selector).focus();
            store();

            $.publish('searchSubmitted');
          });

          // Handle "enter" keypress on search input
          $(selector).keypress(function(event) {
            if (enterKey(event)) {
              event.preventDefault();
              lastValue = elementValue();
              store();

              $.publish('searchSubmitted');
            }
          });

          $(selector).keyup(function(event){
            // Handle "delete" key on search input
            if (deleteKey(event)) {
              if (searchTermsRemoved()) {
                store();
                $.publish('searchSubmitted');
              }
              lastValue = elementValue();

              if (elementValue() == '') {
                $(selector).next().find('i').hide();
              }
              // Handle typing in regular characters
            } else {
              if (elementValue() != '') {
                $(selector).next().find('i').show();
              }
            }
          });
        },

        enterKey = function(event) {
          return event.which == 13;
        },

        deleteKey = function(event) {
          return event.keyCode == 8
        },

        searchTermsRemoved = function() {
          return lastValue != null && lastValue != '' && elementValue() == '';
        },

        elementValue = function() {
          return $(selector).val();
        },

        focused = function() {
          return $(selector).is(':focus');
        },

        store = function() {
          if (key != null) {
            if (location=='local' || location==null) {
              localStorage.setItem(key, toString());
            } else if (location=='session') {
              sessionStorage.setItem(key, toString());
            }
          }
        },

        toJson = function() {
          return {
            key: key,
            location: location,
            selector: selector,
            lastValue: lastValue,
            value:elementValue()
          };
        },

        toString = function() {
          return JSON.stringify(toJson());
        };

    return {
      init: init,
      elementValue: elementValue,
      store: store,
      toString: toString
    };

  },

  /**
   * A FilterPanel is composed of one or more FilterLists, instantiated
   * when the FilterPanel.init() method is called.
   */
  FilterPanel: function(params) {
    if (params==null || params.selector == null || params.listSelector == null) {
      throw new jitterbug.IllegalArgumentException("Params 'selector' " +
          "and 'listSelector' are required.");
    }

    let key = params.key,
        location = params.location,
        selector = params.selector,
        listSelector = params.listSelector,
        selected = params.selectedFilters,
        lists = [],

        init = function() {
          $(selector).find(listSelector).each(function() {
            let list = new jitterbug.FilterList(this);
            list.init();

            if (selected != null && selected[list.listType()] != null) {
              list.setSelected(selected[list.listType()]);
            } else {
              list.setDefault();
            }

            lists.push(list);
          });
          $.subscribe('filterChanged', handleFilterChanged);
        },

        handleFilterChanged = function(event) {
          store();
          $.publish('filterPanelChanged');
        },

        setDefault = function() {
          $.each(lists, function(i, list) {
            list.setDefault();
          });
        },

        filterLists = function() {
          return lists;
        },

        selectedFilters = function() {
          allSelected = {};
          // If lists is empty, make sure there are indeed no lists,
          // init() may not have been called yet
          if(!lists.length) {
            $(selector).find(listSelector).each(function() {
              let list = new jitterbug.FilterList(this);
              // We're not calling list.init() here on purpose
              lists.push(list);
            });
          }
          $.each(lists, function(i, list) {
            allSelected[list.listType()] = list.selectedFilters();
          });
          return allSelected;
        },

        store = function() {
          if (key != null) {
            if (location=='local' || location==null) {
              localStorage.setItem(key, toString());
            } else if (location=='session') {
              sessionStorage.setItem(key, toString());
            }
          }
        },

        toJson = function() {
          return {
            key:key,
            location:location,
            selector:selector,
            listSelector:listSelector,
            selectedFilters:selectedFilters()
          };
        },

        toString = function() {
          return JSON.stringify(toJson());
        };

    return {
      init: init,
      setDefault: setDefault,
      filterLists: filterLists,
      selectedFilters: selectedFilters,
      store:store,
      toString: toString
    };
  },

  FilterList: function(listElement) {
    let list = listElement,
        checkboxes = $(list).find(':checkbox'),
        radioButtons = $(list).find(':radio'),

        init = function() {
          $.each(checkboxes, function(i, checkbox) {
            $(checkbox).on('click', function(event) {
              // If this is an 'Any' checkbox
              if ($(this).is(checkboxes[0])) {

                // Prevent unchecking if it's already checked
                if (!$(this).is(':checked')) {
                  event.preventDefault();
                  return false;
                }

                // Uncheck the other filters
                for (let i = 1; i < checkboxes.length; i++) {
                  checkboxes[i].checked = false;
                }
              } else {
                // Check if at least one non-Any filter is checked
                let oneIsChecked = false;
                for (let i = 1; i < checkboxes.length; i++) {
                  if (checkboxes[i].checked == true) {
                    oneIsChecked = true;
                    break;
                  }
                }

                // If one is checked, turn off the Any filter
                if (oneIsChecked) {
                  checkboxes[0].checked = false;
                } else {
                  checkboxes[0].checked = true;
                }
              }

              renderSelectionCount();

              $.publish('filterChanged');
            });
          });
          $.each(radioButtons, function(i, radioButton) {
            $(radioButton).on('click', function(event) {
              $.publish('filterChanged');
            });
          });
        },

        setSelected = function(selectedFilters) {
          let totalChecked = 0;
          $.each(checkboxes, function(i, checkbox) {
            // if the checkbox value is found in the selectedFilters array
            if ($.inArray(checkbox.value, selectedFilters) !== -1) {
              checkbox.checked = true;
              totalChecked++;
            } else {
              checkbox.checked = false;
            }
          });
          // This means one of a user's selected filters is
          // no longer present in the list, so let's reset the
          // list to the default state.
          if (totalChecked != selectedFilters.length) {
            setDefault();
          }
          // radio button should be checked if its value is in the selectedFilters array
          $.each(radioButtons, function(i, radioButton) {
            radioButton.checked = $.inArray(radioButton.value, selectedFilters) !== -1;
          });
          renderSelectionCount();
        },

        setDefault = function() {
          $.each(checkboxes, function(i) {
            if (i == 0) {
              checkboxes[i].checked = true;
            } else {
              checkboxes[i].checked = false;
            }
          });
          // check first if there are any radio buttons on the page
          // then check first radio button, which is the 'any'
          if (radioButtons.length) {
            radioButtons[0].checked = true;
          }
        },

        listType = function() {
          return $(list).attr('id');
        },

        selectedFilters = function() {
          let selected = $(list).find('input:checked');
          let values = [];
          for (let i=0; i < selected.length; i++) {
            values.push(selected[i].value);
          }
          return values;
        },

        count = function() {
          if (selectedFilters()[0] == 0) {
            return 0;
          } else {
            return selectedFilters().length;
          }
        },

        scrollable = function() {
          return $(list).height() < list.scrollHeight;
        },

        renderSelectionCount = function() {
          if (scrollable()) {
            let countSelector = '#' + listType() + '-selection-count';
            if (count() > 0) {
              $(countSelector).html(count() + ' selected' +
                  ' <a id="' + listType() + '-clear-selection" href="#" style="color: #fff">\
                <i class="fa fa-times-circle" aria-hidden="true"></i>\
              </a>');
              $('#' + listType() + '-clear-selection').on('click', function(event) {
                event.preventDefault();
                // Turn on the 'Any' filter
                setSelected(['0']);
                $.publish('filterChanged');
              });
            } else {
              $(countSelector).html('');
            }
          }
        };

    return {
      init: init,
      setDefault: setDefault,
      setSelected: setSelected,
      listType: listType,
      selectedFilters: selectedFilters
    };

  },

  /**
   * A TableSelection models a user's selection of multiple
   * rows of a table created by 'shift-clicking' or 'command-clicking'
   * on the rows to make the selection, rather than using form
   * checkboxes.
   *
   * Rows of the table must have the data attributes 'data-index'
   * and 'data-id' on them that reflects the index of the record
   * in the table and the id of the record in the database,
   * respectively.
   *
   * If storage parameters are supplied (storage key and location),
   * the table selection will persist itself to local storage when
   * the selection changes.
   *
   * Constructor params are as follows:
   * 'key' = storage key under which the serialized selection is stored
   * 'location' = Storage location (can be 'session' or 'local')
   * 'resource' = The type of entity being displayed in the table
   * 'selector' = jQuery selector for the table rows *required
   * 'countSelector' = jQuery selector for the element containing
   *  the count of selected items
   * 'beginIndex' = Beginning index of the selection range
   * 'beginId' = Database id for the record at beginIndex
   * 'ids' = Ids that are currently selected
   */
  TableSelection: function(params) {
    if (params==null || params.resource == null || params.selector == null ||
        params.countSelector == null) {
      throw new jitterbug.IllegalArgumentException("Params 'resource', " +
          "'selector' and 'countSelector' are required.");
    }

    let key = params.key,
        location = params.location,
        resource = params.resource,
        selector = params.selector,
        countSelector = params.countSelector,
        beginIndex = params.beginIndex,
        beginId = params.beginId,
        ids = params.ids != null ? params.ids : [],
        queryManager = null,
        cache = {},

        init = function() {

          // Prevent multiple subscriptions after data load
          $.unsubscribe('dataLoaded');

          let dataTableRows = $(selector);

          // Prevent the user from selecting text in the data table
          dataTableRows.on('selectstart dragstart', function(event) {
            event.preventDefault();
          });

          // Bind click handlers to all data table rows
          dataTableRows.on('click', function(event) {
            // The index of the Solr search result
            let index = $(this).data('index');
            // The id of the record at the index
            let id = $(this).data('id');
            // column by which table is being sorted. may be null
            const sortColumn = $(this).closest('table').data('sort-column');
            // direction of sort, if there is one in use
            const sortDirection = $(this).closest('table').data('sort-direction');

            // If user is "shift-clicking" a row (i.e. selecting a range of rows)
            if (event.shiftKey) {
              resolveRange(index, id, sortColumn, sortDirection);
              finalizeEvent(event);
              return;
            }

            // If user is "command-clicking" (Mac) (or control on Windows)
            // a row (i.e. selecting/deselecting single row)
            if (event.ctrlKey || event.metaKey) {
              toggle(id);
              finalizeEvent(event);
              return;
            }

          });

          $.subscribe('dataLoaded', dataLoaded);
        },

        finalizeEvent = function(event) {
          store();
          render();
          event.stopImmediatePropagation();
        },

        dataLoaded = function(event) {
          // Cache the loaded indices & ids
          $(selector).each(function() {
            let index = $(this).data('index'),
                id = $(this).data('id');
            cache[index] = id;
            // Refresh beginIndex in case it's gotten out of sync
            if (id == beginId) {
              beginIndex = index;
            }
          });
          render();
        },

        selected = function(id) {
          return $.inArray(id, ids) != -1;
        },

        render = function() {
          $(selector).each(function() {
            let id = $(this).data('id');
            if (selected(id)) {
              $(this).addClass('selected');
            } else {
              $(this).removeClass('selected');
            }
          });
          if (count() > 0) {
            $(countSelector).html(count() + ' selected' +
                ' <a id="clear-selection" href="#" style="color: #fff">\
                    <i class="fa fa-times-circle" aria-hidden="true"></i>\
                  </a>');
            $('#clear-selection').on('click', function(event) {
              event.preventDefault();
              clear();
              render();
            });
          } else {
            $(countSelector).html('');
          }
        },

        // Resolve a range selection to an array of ids
        resolveRange = function(endIndex, endId, sortColumn, sortDirection) {
          if (beginIndex == null && beginId == null) {
            beginIndex = endIndex;
            beginId = endId;
            ids = [beginId];
          } else {
            let beforeCount = count();

            // Check if full range is currently within the table on screen
            if (rangeInTable(beginIndex, endIndex)) {
              console.log('Getting range from table: ' + beginIndex + ' ' + endIndex);
              ids = idsFromTable(beginIndex, endIndex);
              // Full range is not in the table, so check to see if it's in cache
            } else if (rangeInCache(beginIndex, endIndex)) {
              console.log('Getting range from cache: ' + beginIndex + ' ' + endIndex);
              ids = idsFromCache(beginIndex, endIndex);
              // Not in table or cache, so go to the server to get ids from Solr
            } else {
              if (queryManager != null) {
                console.log('Getting range from server');
                let query = {};
                query['q'] = encodeURIComponent(queryManager.queryString());
                let range = JSON.stringify({beginIndex: beginIndex,
                  beginId: beginId, endIndex: endIndex, endId: endId});
                query['r'] = encodeURIComponent(range);
                query['sortColumn'] = sortColumn;
                query['sortDirection'] = sortDirection;

                $.ajax({
                  url: '/' + resource + '/resolve-range',
                  data: query,
                  success: function(data) {
                    ids = data['ids'].map(Number);
                    store();
                    render();
                  },
                  statusCode: {
                    400: function() {
                      jitterbug.displayAlert('danger',
                          '<strong>Sorry to interrupt!</strong> It appears someone \
                          has changed the data you\'re viewing. Please reload the \
                          page and try your selection again.');
                      clear();
                      render();
                    }
                  },
                  error: function() {
                    console.log('Could not resolve selection range');
                  }
                });
              } else {
                console.log('QueryManager is null. \
              Could not resolve selection range');
              }
            }

            // Allows user to deselect a range
            if (count()==1 && beforeCount==1 && beginIndex==endIndex) {
              clear();
            }
          }
        },

        rangeInTable = function(begin, end) {
          let table = tableToObject();
          return table[begin] != null && table[end] != null;
        },

        idsFromTable = function(begin, end) {
          let first = Math.min(begin, end),
              last = Math.max(begin, end);
          tableIds = [];
          $(selector).each(function() {
            let thisIndex = $(this).data('index'),
                thisId = $(this).data('id');
            if (thisIndex >= first && thisIndex <= last) {
              tableIds.push(thisId);
            }
          });
          return tableIds;
        },

        rangeInCache = function(begin, end) {
          let first = Math.min(begin, end),
              last = Math.max(begin, end);
          for(i = first; i <= last; i++) {
            if(cache[i] == null) {
              return false;
            }
          }
          return true;
        },

        idsFromCache = function(begin, end) {
          let first = Math.min(begin, end),
              last = Math.max(begin, end),
              cacheIds = [];
          for(i = first; i <= last; i++) {
            cacheIds.push(cache[i]);
          }
          return cacheIds;
        },

        tableToObject = function() {
          let table = {};
          $(selector).each(function() {
            table[$(this).data('index')] = $(this).data('id');
          });
          return table;
        },

        toggle = function(id) {
          let result = $.inArray(id, ids);
          if (result == -1) {
            ids.push(id);
          } else {
            ids.splice(result, 1);
          }
          if (count() == 0) {
            clear();
          }
        },

        setQueryManager = function(manager) {
          queryManager = manager;
        },

        selectAll = function() {
          let max = 3000;
          // This is kinda gross
          let total = parseInt($('.record-count').text().trim().split(/\s+/)[0]);
          if (total > max) {
            jitterbug.displayAlert('warning',
                '<strong>Sorry!</strong> That\'s too many records to select at \
                once. Please narrow your search to less than ' +
                max + ' records.');
          } else {
            beginIndex = 0;
            endIndex = total - 1;
            resolveRange(endIndex, null);
            if (rangeInTable(beginIndex, endIndex) ||
                rangeInCache(beginIndex, endIndex)) {
              store();
              render();
            }
            // Cache all ids
            for (let i = beginIndex; i <= endIndex; i++) {
              cache[i] = ids[i];
            }
          }
        },

        selectedIds = function() {
          return ids;
        },

        clear = function() {
          beginIndex = null;
          beginId = null;
          ids = [];
          cache = {};
          store();
        },

        count = function() {
          return ids.length;
        },

        store = function() {
          if (key != null) {
            if (location == 'local' || location == null) {
              localStorage.setItem(key, toString());
            } else if (location == 'session') {
              sessionStorage.setItem(key, toString());
            }
          }
        },

        toJson = function() {
          return {
            key: key,
            location: location,
            resource: resource,
            selector: selector,
            countSelector: countSelector,
            beginIndex: beginIndex,
            beginId: beginId,
            ids: ids
          };
        },

        toString = function() {
          return JSON.stringify(toJson());
        };

    return {
      init: init,
      selected: selected,
      render: render,
      clear: clear,
      selectedIds: selectedIds,
      selectAll: selectAll,
      count: count,
      setQueryManager: setQueryManager,
      store: store,
      toJson: toJson,
      toString: toString
    };

  },

  MarksModule: function(params) {
    if (params == null || params.marksContainer == null ||
        params.marksSelector == null || params.noMarksSelector == null ||
        params.filtersSelector == null || params.usersSelector == null ||
        params.selectedUserSelector == null) {
      throw new jitterbug.IllegalArgumentException("Params 'marksContainer', " +
          "'marksSelector', 'noMarksSelector', " +
          "'filtersSelector', 'usersSelector' and " +
          "'selectedUserSelector' are required.");
    }

    let key = params.key,
        location = params.location,
        marksContainer = params.marksContainer,
        marksSelector = params.marksSelector,
        noMarksSelector = params.noMarksSelector,
        filtersSelector = params.filtersSelector,
        usersSelector = params.usersSelector,
        selectedUserSelector = params.selectedUserSelector,
        currentFilter = params.currentFilter,
        selectedUserId = params.selectedUserId,

        init = function() {
          // Check if selected user is present in the users list. If
          // not present, it means the selected user has removed all
          // of their marks and is no longer showing up in the menu,
          // in which case we will default to the current user.
          if (!selectedUserIdPresent()) {
            selectedUserId = currentUser().id;
          }
          // Hook up the filter radios.
          // Binding click events to the radio buttons themselves didn't work,
          // because Bootstrap was not propagating events, so we're binding to
          // the labels instead.
          $(filtersSelector).on('click',function(event) {
            event.preventDefault();
            currentFilter = $(this).data('filter');
            updateFilterHighlighting();
            // when the filter changes, deselect all marks
            deselectAllMarks();
            store();
            render();
          });

          // Hook up user selection drop down
          $(usersSelector).on('click', function(event) {
            event.preventDefault();
            selectedUserId = $(this).data('user-id');
            store();
            getMarks();
          });

          // Set up the filter radio buttons
          if (currentFilter == null) {
            currentFilter = 'all';
            $(filtersSelector).first().addClass('active');
          } else {
            updateFilterHighlighting();
          }
          // set up delete marks button
          $('.delete-marks button').on('click', function() {
            let size = $('input.delete-checkbox:checkbox:checked').length;
            if (confirm('Are you sure you want to delete ' + size + ' marks?')) {
              deleteMarks();
            }
          });

          getMarks();
        },

        updateFilterHighlighting = function() {
          $(filtersSelector).each(function() {
            if (currentFilter === $(this).data('filter')) {
              $(this).addClass('active');
            } else {
              $(this).removeClass('active');
            }
          });
        },

        getMarks = function() {
          // Load the marks for the selected user
          query = {};
          query['id'] = selectedUserId;
          $.get('/dashboard/marks-for-user', query, function(data) {
            $(marksContainer).replaceWith(data);
            link();
            toggleSelectAllVisibility(selectedUserId);
            render();
            let selectedUserFullName = selectedUserName();
            let truncatedUser = selectedUserFullName.length > 13 ?
                selectedUserFullName.substr(0, 13) + '...' : selectedUserFullName;
            $(selectedUserSelector).text(truncatedUser);
            jitterbug.initSelectAll('#mark-checkbox-all', '.delete-checkbox:visible');
          });
        },

        deleteMarks = function() {
          let marksToDelete = {};

          // gather and sort all selected markable IDs by type
          $('input.delete-checkbox:checkbox:checked').each(function() {
            let parent = $(this).parent();
            let markId = parent.data('object-id');
            let type = parent.data('object-type');

            if (marksToDelete[type] === undefined) {
              marksToDelete[type] = [markId];
            } else {
              marksToDelete[type].push(markId);
            }
          });

          let keys = Object.keys(marksToDelete);

          for (let index in keys) {
            key = keys[index];

            // reformat names correctly
            if (key == 'item') {
              let markableType = 'AudioVisualItem';
            } else if (key == 'instance') {
              let markableType = 'PreservationInstance';
            } else if (key == 'transfer') {
              let markableType = 'Transfer';
            }

            let data = {};
            data['markableType'] = markableType;
            data['markableIds'] = marksToDelete[key];
            data['_method'] = 'DELETE';

            $.post('/marks', data, function(data) {
              // Reload the marks part of the DOM so if the user
              // navigates away from the page, and then uses
              // the back button, the current state is cached.
              getMarks();
            });
          }
        },

        link = function() {
          // Hook up individual marks to their associated objects
          $(marksSelector). on('click',function(event) {
            let type = $(this).data('object-type'),
                id = $(this).data('object-id');
            window.location.href='/' + type + 's/' + id;
          });

          // unlink delete checkboxes from the associated objects
          $('.delete-checkbox').on('click', function(event) {
            event.stopImmediatePropagation();
          });
        },

        deselectAllMarks = function() {
          $('#mark-checkbox-all').prop('checked', false);
          $('.delete-checkbox').each(function() {
            this.checked=false;
          });
        },

        toggleSelectAllVisibility = function(selectedUserId) {
          if (selectedUserId === currentUser().id) {
            $('.select-all'). show();
            $('.delete-marks').show();
          } else {
            $('.select-all').hide();
            $('.delete-marks').hide();
          }
        },

        render = function() {
          let hasOne = false;
          $(marksSelector).each(function() {
            if (currentFilter == 'all') {
              $(this).show();
              hasOne = true;
              return true;
            }
            let type = $(this).data('object-type');
            if (currentFilter == type) {
              $(this).show();
              hasOne = true;
            } else {
              $(this).hide();
            }
          });
          if (!hasOne) {
            switch (currentFilter) {
              case 'all':
                $(noMarksSelector).text('Marks are like shortcuts to records. Try them out!');
                break;
              case 'item':
                $(noMarksSelector).text('No audio visual items are currently marked.');
                break;
              case 'instance':
                $(noMarksSelector).text('No preservation instances are currently marked.');
                break;
              case 'transfer':
                $(noMarksSelector).text('No transfers are currently marked.');
                break;
            }
            $(noMarksSelector).show();
          } else {
            $(noMarksSelector).hide();
          }
        },

        currentUser = function() {
          let currentUser = {};
          $(usersSelector).each(function() {
            if ($(this).hasClass('current-user')) {
              currentUser.id = $(this).data('user-id');
              currentUser.fullName = $(this).text();
            }
          });
          return currentUser;
        },

        selectedUserIdPresent = function() {
          isPresent = false;
          $(usersSelector).each(function() {
            if (selectedUserId == $(this).data('user-id')) {
              isPresent = true;
            }
          });
          return isPresent;
        },

        selectedUserName = function() {
          fullName = null;
          $(usersSelector).each(function() {
            if (selectedUserId == $(this).data('user-id')) {
              fullName = $(this).text();
            }
          });
          return fullName;
        },

        store = function() {
          if (key != null) {
            if (location == 'local' || location == null) {
              localStorage.setItem(key, toString());
            } else if (location == 'session') {
              sessionStorage.setItem(key, toString());
            }
          }
        },

        toJson = function() {
          return {
            key: key,
            location: location,
            marksContainer: marksContainer,
            marksSelector: marksSelector,
            noMarksSelector: noMarksSelector,
            filtersSelector: filtersSelector,
            usersSelector: usersSelector,
            selectedUserSelector: selectedUserSelector,
            currentFilter: currentFilter,
            selectedUserId: selectedUserId
          };
        },

        toString = function() {
          return JSON.stringify(toJson());
        };

    return {
      init: init,
      store: store
    };

  },

  IllegalArgumentException: function(message) {
    this.message = message;
  },

  /**
   * Used to deserialize all models from storage.
   */
  loader: function(key, location) {
    if (key==null) {
      console.log("Could not load object. Param 'key' is null.");
      return null;
    }
    let string = null;
    if (location=='local' || location==null) {
      string = localStorage.getItem(key);
    } else if (location=='session') {
      string = sessionStorage.getItem(key);
    }
    if (string==null) {
      return null;
    }
    params = JSON.parse(string);
    return new this(params);
  }
};

jitterbug.SearchField.load = jitterbug.loader;
jitterbug.TableParams.load = jitterbug.loader;
jitterbug.FilterPanel.load = jitterbug.loader;
jitterbug.TableSelection.load = jitterbug.loader;
jitterbug.MarksModule.load = jitterbug.loader;

/* jQuery Tiny Pub/Sub - v0.7 - 10/27/2011
 * http://benalman.com/
 * Copyright (c) 2011 "Cowboy" Ben Alman; Licensed MIT, GPL */
(function($) {
  let o = $({});
  $.subscribe = function() {
    o.on.apply(o, arguments);
  };
  $.unsubscribe = function() {
    o.off.apply(o, arguments);
  };
  $.publish = function() {
    o.trigger.apply(o, arguments);
  };
}(jQuery));
