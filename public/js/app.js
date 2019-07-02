jitterbug = {
  clearStorage: function() {
    // clear admin table
    sessionStorage.removeItem('selectedAdminTable');
    // clear items state
    localStorage.removeItem('itemsSearchField');
    localStorage.removeItem('itemsFilterPanel');
    sessionStorage.removeItem('itemsTableSelection');
    localStorage.removeItem('itemsTableParams');
    // clear masters state
    localStorage.removeItem('mastersSearchField');
    localStorage.removeItem('mastersFilterPanel');
    sessionStorage.removeItem('mastersTableSelection');
    localStorage.removeItem('mastersTableParams');
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
    var threeHours = 10800000;
    window.setTimeout(function() {
      window.location.href='/logout'
    }, threeHours);
  },

  initGreeting: function() {
    var hour = new Date().getHours(),
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
      var alert = document.createElement('div');
      $(alert).attr('id', 'alert');
      $(alert).attr('class', 'col-md-12 alert alert-' + type);
      $(alert).attr('role', 'alert');
      $(alert).html(message);
      $('#alert').replaceWith(alert);
      $('#alert').delay(500).slideDown(200).delay(8000).slideUp(200);
    }
  },

  initSubmitButton: function() {
    $('button[type="submit"]').click(function(event){
      $(this).attr('disabled', true);
      $(this).closest('form').submit();
    });
  },

  initSelectAll: function(allSelector, checkboxSelector) {
    $(allSelector).change(function(event) {
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
    $(checkboxSelector).change(function () {
      if ($(this).is(":checked")) {
        var isAllChecked = 0;

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
    var selectedTable = sessionStorage.getItem('selectedAdminTable');
    if (selectedTable == null) {
      selectedTable = 'users';
      sessionStorage.setItem('selectedAdminTable', 'users');
    }
    // Bind click handlers to each table radio button in the admin section
    $('input[name=table]').click(function(event) {
      var table = $(this).val(),
      resource = table.replace(/_/g, '-');
      // Get the records for the chosen table
      $.get('/' + resource, function(data) {
        sessionStorage.setItem('selectedAdminTable', table);
        // Hide any popover if showing, otherwise the open popover will remain
        // on screen after the user has changed tables.
        $('.popover').hide();

        $('#record-container').replaceWith(data);

        // If this is the users table, bind click handlers to the 
        // admin checkboxes
        if (table == 'users') {
          jitterbug.toggleAdmin();
          // If this is the prefixes table, bind click handlers to
          // legacy checkboxes and set up the popovers
        } else if (table === 'prefixes') {
          jitterbug.toggleLegacy();
          jitterbug.initAdminEditableFields(resource);
          // This is one of the reference tables. Setup the 'new record' popover
          // first, then setup the field popovers.
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

  toggleAdmin: function() {
    var adminCheckboxes = $('#table-container input:checkbox');
    adminCheckboxes.click(function(event) {
      var makeAdmin = $(this).is(':checked');
      var route = makeAdmin == true ? '/admin/make-admin'
          : '/admin/remove-admin';
      var data = {};
      var username = $(this).data('username');
      data['username'] = username;
      $.post(route, data, function(data) {
        var message = makeAdmin == true
            ? 'User ' + username + ' was successfully made admin.'
            : 'User ' + username + ' is no longer an admin.';
        jitterbug.displayAlert('success', message);
      });
    });
  },

  toggleLegacy: function() {
    var legacyCheckboxes = $('#table-container input:checkbox');
    legacyCheckboxes.click(function(event) {
      var makeLegacy = $(this).is(':checked');
      var route = makeLegacy === true ? '/prefixes/set-legacy-status'
          : '/prefixes/remove-legacy-status';
      var data = {};
      var id = $(this).data('id');
      data['id'] = id;
      $.post(route, data, function(data) {
        var message = makeLegacy === true
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
    }).click(function(event) {
      event.preventDefault();
      var button = this;
      // Because setting the container option is broken, we have to resort
      // to this ugliness to style the popover with an unlimited max-width
      // (for our inline form) for only this use.
      var popover = $('#' + $(this).attr('aria-describedby'));
      popover.css('max-width', 'none');
      // This causes the popover to redraw properly centered after the
      // max-width was changed. This must be popover('show') rather than
      // popover('toggle').
      $(button).popover('show');

      // Hookup the new record popover form submit
      popover.find('form').submit(function(event) {
        event.preventDefault();
        var form = $(this).serialize();

        // Disable submit buttons and start the spinner
        var submitButton = $(this).find('button[type="submit"]');
        var cancelButton = $(this).find('button.cancel-new-record');
        submitButton.attr('disabled', true);
        cancelButton.attr('disabled', true);
        var icon = submitButton.find('i');
        icon.removeClass('fa-check');
        icon.addClass('fa-spinner').addClass('fa-pulse');

        $.ajax({
          url: '/' + resource,
          type: 'post',
          data: form,
          success: function (data) {
            var tableContainer = $('#table-container');
            // Scroll the table div to the top to show the new record
            tableContainer.animate({ scrollTop: 0 });

            // Use the first row of the table as a template
            var templateRow = tableContainer.find('tbody > tr:first').clone();
            templateRow.find('[data-field]').each(function() {
              var field = $(this).attr('data-field');
              $(this).attr('data-id', data.id);
              // If field is empty, add non-breaking spaces so
              // there is something to click on
              var newCellValue = data[field] == '' ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : data[field];
              // if it's the collection type ID column, display the name instead of the ID
              if (field === 'collectionTypeId') {
                newCellValue = data['collectionTypeName']
              }
              $(this).html(newCellValue);

              // Hookup the new field popovers
              if ($(this).hasClass('editable')) {
                jitterbug.createAdminEditableFieldPopover(resource, this);
              }
            });
            var deleteAnchor = templateRow.find('.delete');
            jitterbug.bindAdminRecordDelete(resource, deleteAnchor);

            // Insert row
            templateRow.prependTo('#table-container > table > tbody');
          },
          error: function (jqXHR, textStatus, error) {
            // Validation error
            if (jqXHR.status==422) {
              var errors = JSON.parse(jqXHR.responseText);
              // Get the first error, no matter which it is.
              for (var key in errors) if (errors.hasOwnProperty(key)) break;
              // Unfortunately, we have to hide the popover here
              // because it doesn't stay pinned to the field it
              // relates to when the alert div is opened (a bug
              // in Bootstrap/Tether).
              jitterbug.displayAlert('danger',
                  '<strong>Whoops.</strong> ' + errors[key]);
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

    // This will hide the 'create new record' popover, canceling the create
    $('body').on('click', '.cancel-new-record', function(event) {
      event.preventDefault();
      $('#new-record-button').popover('hide');
    });

    // There is a bug in Bootstrap 4 where manually hiding a popover
    // (as we do above) will cause the popover to require 2 clicks to
    // show again:
    // https://github.com/twbs/bootstrap/issues/16732
    $('body').on('hidden.bs.popover', function (event) {
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
    $('body').on('click', '.cancel-edit', function(event) {
      event.preventDefault();
      var popover = $(this).closest('.popover');
      popover.popover('hide');
    });

    // When a new popover is opened, hide any already opened.
    $('body').on('show.bs.popover', function (event) {
      var target = event.target;
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
    var fieldName = $(span).data('field'),
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
    }).click(function(event) {
      event.preventDefault();
      var fieldSpan = this;

      $(this).popover('show');
      // The popover doesn't exist until the user has clicked the
      // field, and the aria-describedby attribute (which is the 
      // popover id) is undefined until the popover has been
      // shown.
      var popover = $('#' + $(this).attr('aria-describedby'));
      popover.css('max-width', 'none');

      // Must show again to redraw after max-width has changed
      $(this).popover('show');
      
      // Must update the popover input field with the current
      // value of the field in case the user has changed the
      // value, and then reopens the popover.
      var popoverInput = 
          popover.find('input[name=' + fieldName + ']');
      popoverInput.attr('value', $(fieldSpan).text().trim());
      
      // Hookup the field popover form submit
      popover.find('form').submit(function(event) {
        event.preventDefault();
        // This needs to be attr('data-id') instead of .data('id')
        var id = $(fieldSpan).attr('data-id'),
        // we assume it's not a dropdown
        dropdownSelect = false,
        // Get field value set by the user
        formInputVal = $(this).find('input[name=' + fieldName + ']').val();
        // If it's undefined, then it's a dropdown field
        if (formInputVal === undefined ) {
          formInputVal = parseInt($(this).find(':selected').val());
          dropdownSelect = true;
          var formInputText = $(this).find(':selected').text();
        }
        data = {};
        data[fieldName] = formInputVal;

        // Disable submit buttons and start the spinner
        var submitButton = $(this).find('button[type="submit"]');
        var cancelButton = $(this).find('button.cancel-edit');
        submitButton.attr('disabled', true);
        cancelButton.attr('disabled', true);
        var icon = submitButton.find('i');
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
            var newCellValue = formInputVal === '' ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : formInputVal;
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
              var errors = JSON.parse(jqXHR.responseText);
              // Get the first error, no matter which field it is for.
              for (var key in errors) if (errors.hasOwnProperty(key)) break;
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
    $(anchor).click(function(event) {
      event.preventDefault();
      
      var row = $(this).closest('tr');
      var id = row.find('.editable').first().attr('data-id');

      $.ajax({
        url: '/' + resource + '/' + id,
        type: 'delete',
        success: function (data) {
          var additionalMessage = data['message'] === undefined ? '' : data['message'];
          row.remove();
          jitterbug.displayAlert('success',
              '<strong>Gone.</strong> The record was successfully deleted. ' + additionalMessage);
        },
        error: function (jqXHR, textStatus, error) {
          // Validation error
          if (jqXHR.status==422) {
            var errors = JSON.parse(jqXHR.responseText);
            // Get the first error
            for (var key in errors) if (errors.hasOwnProperty(key)) break;
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

      var prefixIds = $(this).find('select').val();
      var id = $(this).attr('data-format-id');
      var url = window.location.href;

      var data = {
        'id': id,
        'prefixIds': prefixIds
      };

      $.ajax({
        url: '/formats/attach_prefixes',
        type: 'POST',
        data: data,
        success: function () {
          jitterbug.displayAlert('success',
              'The prefixes were successfully attached.');
          $('#data-panel').load(url + ' #data-panel', function() {
            jitterbug.initChosenMultiSelect('.chosen-select', {width: '500px'}, {width: '500px'})
          });
        },
        error: function (jqXHR, textStatus, error) {
          jitterbug.displayAlert('danger', '<strong>Uh oh.</strong> An error has occurred: ' + error);
        }
      });
    });
  },

  bindFormatPrefixDetachment: function(anchor) {
    $(anchor).click(function(event) {
      event.preventDefault();

      var row = $(this).closest('tr');
      var url = window.location.href;
      var data = {
        'id': row.attr('data-format-id'),
        'prefixId': row.attr('data-prefix-id')
      };

      $.ajax({
        url: '/formats/detach_prefixes',
        type: 'POST',
        data: data,
        success: function () {
          row.remove();
          $('#attach-prefix-form').load(url + ' #attach-prefix-form', function() {
            jitterbug.initChosenMultiSelect('.chosen-select', {width: '500px'}, {width: '500px'})
          });
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
    var itemChart = $('#item-chart');
    var itemCounts = itemChart.data('counts').split(',').map(Number);
    var itemData = new google.visualization.DataTable();
    itemData.addColumn('string', 'Type');
    itemData.addColumn('number', 'Count');
    itemData.addRows([
      ['Audio', itemCounts[0]],
      ['Film', itemCounts[1]],
      ['Video', itemCounts[2]],
    ]);

    var masterChart = $('#master-chart');
    var masterCounts = masterChart.data('counts').split(',').map(Number);
    var masterData = new google.visualization.DataTable();
    masterData.addColumn('string', 'Type');
    masterData.addColumn('number', 'Count');
    masterData.addRows([
      ['Audio', masterCounts[0]],
      ['Film', masterCounts[1]],
      ['Video', masterCounts[2]],
    ]);

    var transferChart = $('#transfer-chart');
    var transferCounts = transferChart.data('counts').split(',').map(Number);
    var transferData = new google.visualization.DataTable();
    transferData.addColumn('string', 'Type');
    transferData.addColumn('number', 'Count');
    transferData.addRows([
      ['Audio', transferCounts[0]],
      ['Film', transferCounts[1]],
      ['Video', transferCounts[2]],
    ]);

    var options = {
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

    masterChart = new google.visualization.PieChart(masterChart[0]);
    masterChart.draw(masterData, options);

    transferChart = new google.visualization.PieChart(transferChart[0]);
    transferChart.draw(transferData, options);
  },

  initDashboardActivityStream: function() {
    $('.recent-activity li[role="button"]').click(function(event) {
      var type = $(this).data('object-type'),
      id = $(this).data('object-id');
      window.location.href='/' + type + 's/' + id;
    });
  },

  initDashboardMarks: function() {
    var marksModule = jitterbug.MarksModule.load('dashboardMarks', 'session');
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
   * index page (items, masters, and transfers). They aren't used
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
    $('#items-new').click(function(event) {
      jitterbug.tableSelection.clear();
    });
  },

  initItemsBatchMenu: function() {
    $('#items-batch-edit').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      var maxEditLimit = $(this).data('max-edit-limit');
      if (!jitterbug.validateBatchSelection(tableSelection, 'editing', maxEditLimit)) {
        return;
      }
      jitterbug.submitBatchEditForm('items', tableSelection);
    });

    jitterbug.initDataExportModal('items');
    $('#items-batch-export').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'exporting')) {
        return;
      }
      jitterbug.openDataExportModal('items', tableSelection);
    });

    $('#items-batch-mark').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'marking', 100)) {
        return;
      }
      jitterbug.batchMark('items', 'AudioVisualItem', tableSelection);
    });

    $('#items-batch-unmark').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'unmarking', 100)) {
        return;
      }
      jitterbug.batchUnmark('items', 'AudioVisualItem', tableSelection);
    });

    $('#items-batch-delete').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'deleting', 100)) {
        return;
      }
      $('#confirm-batch-delete-modal').modal('toggle');
      $('#batch-delete-form input[name="ids"]').val(tableSelection.selectedIds());
    });

    $('#items-batch-items-import').click(function(event) {
      $('#items-import-modal').modal('toggle');
    });
  },

  initItemsImportModal: function() {
    jitterbug.initDataUploadForm('items');
    jitterbug.initDataImportForm('items');

    // Click handlers for 'start over' links and buttons
    $('#items-import-modal .reset').click(function(event) {
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
    $('#detail #item-type-controls :radio').click(function(event) {
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
    $('#collection-id, #format-id').change(function() {
      var collectionId = $('#collection-id').val();
      var formatId = $('#format-id').val();
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

  initMastersNewButton: function() {
    $('#masters-new').click(function(event) {
      jitterbug.tableSelection.clear();
    });
  },

  initMastersBatchMenu: function() {
    $('#masters-batch-edit').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      var maxEditLimit = $(this).data('max-edit-limit');
      if (!jitterbug.validateBatchSelection(tableSelection, 'editing', maxEditLimit)) {
        return;
      }
      jitterbug.submitBatchEditForm('masters', tableSelection);
    });

    jitterbug.initDataExportModal('masters');
    $('#masters-batch-export').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'exporting')) {
        return;
      }
      jitterbug.openDataExportModal('masters', tableSelection);
    });

    $('#masters-batch-mark').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'marking', 100)) {
        return;
      }
      jitterbug.batchMark('masters', 'PreservationMaster', tableSelection);
    });

    $('#masters-batch-unmark').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'unmarking', 500)) {
        return;
      }
      jitterbug.batchUnmark('masters', 'PreservationMaster', tableSelection);
    });

    $('#masters-batch-delete').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'deleting', 100)) {
        return;
      }
      $('#confirm-batch-delete-modal').modal('toggle');
      $('#batch-delete-form input[name="ids"]').val(
        tableSelection.selectedIds());
    });
  },

  initMasterTypeControls: function() {
    $('#detail #master-type-controls :radio').click(function(event) {
      if ($(this).val()=='AudioMaster') {
        $('#audio-form').show();
        $('#film-form').hide();
        $('#video-form').hide();
      } else if ($(this).val()=='FilmMaster') {
        $('#audio-form').hide();
        $('#film-form').show();
        $('#video-form').hide();
      } else if ($(this).val()=='VideoMaster') {
        $('#audio-form').hide();
        $('#film-form').hide();
        $('#video-form').show();
      }
    });
  },

  initMasterBatchCheckbox: function() {
    $('#batch-checkbox').change(function(event) {
      $('#fileName').attr('readonly', $(this).is(':checked'));
      $('#fileName').val('');
    });
  },

  initTransfersNewButton: function() {
    $('#transfers-new').click(function(event) {
      jitterbug.tableSelection.clear();
    });
  },

  initTransfersBatchMenu: function() {
    $('#transfers-batch-edit').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      var maxEditLimit = $(this).data('max-edit-limit');
      if (!jitterbug.validateBatchSelection(tableSelection, 'editing', maxEditLimit)) {
        return;
      }
      jitterbug.submitBatchEditForm('transfers', tableSelection);
    });

    jitterbug.initDataExportModal('transfers');
    $('#transfers-batch-export').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'exporting')) {
        return;
      }
      jitterbug.openDataExportModal('transfers', tableSelection);
    });

    $('#transfers-batch-mark').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'marking', 100)) {
        return;
      }
      jitterbug.batchMark('transfers', 'Transfer', tableSelection);
    });

    $('#transfers-batch-unmark').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'unmarking', 500)) {
        return;
      }
      jitterbug.batchUnmark('transfers', 'Transfer', tableSelection);
    });

    $('#transfers-batch-delete').click(function(event) {
      var tableSelection = jitterbug.tableSelection;
      if (!jitterbug.validateBatchSelection(tableSelection, 'deleting', 100)) {
        return;
      }
      $('#confirm-batch-delete-modal').modal('toggle');
      $('#batch-delete-form input[name="ids"]').val(tableSelection.selectedIds());
    });

    $('#transfers-batch-audio-import').click(function(event) {
      $('#audio-import-modal').modal('toggle');
    });

    $('#transfers-batch-video-import').click(function(event) {
      $('#video-import-modal').modal('toggle');
    });
  },

  initTransferTypeControls: function() {
    $('#detail #transfer-type-controls :radio').click(function(event) {
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
    $('#preservation-master-id').change(function() {
      var preservationMasterId = $('#preservation-master-id').val();
      if (preservationMasterId.length) {
        query = {};
        query['preservation-master-id'] = preservationMasterId;
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
    $('#batch-delete-form button[type="submit"]').click(function() {
        $(this).attr('clicked', 'true');
    });
    $('#batch-delete-form').submit( function(event) {
      jitterbug.tableSelection.clear();
      jitterbug.tableParams.setPage(1);
      var submitButtons = $(this).find('button[type="submit"]');
      var deleteCommand = $(this).find('button[type="submit"][clicked="true"]').val();
      $(this).find('input[name="deleteCommand"]').val(deleteCommand);
      submitButtons.attr('disabled', true);
    });
  },

  initAudioImportModal: function() {
    jitterbug.initDataUploadForm('audio');
    jitterbug.initDataImportForm('audio');

    // Click handlers for 'start over' links and buttons
    $('#audio-import-modal .reset').click(function(event) {
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
    $('#video-import-modal .reset').click(function(event) {
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
    $(':file').change(function() {
      var input = $(this),
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
      var form = new FormData(this);
      $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        data: form,
        processData: false,
        contentType: false, 
        success: function (data) {
          console.log('upload success');
          var count = data['count'];
          if (count==0) {
            $('#' + type + '-import-step-2 .success-actions').hide();
            $('#' + type + '-import-step-2 .failure-actions').show();
          }
          // Animation is handled via CSS transition
          $('#' + type + '-import-dialog').width(700);
          $('#' + type + '-import-dialog-content').width(700);
          // Delay to let the css transition finish (hack)
          var delay = 500;
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

      var submitButton = $(this).find('button[type="submit"]');
      submitButton.attr('disabled', true);

      $('#' + type + '-import-spinner').show();
      var form = new FormData(this);
      $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
          var status = data['status'];

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
      var fieldCheckboxes = 
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
      var submitButton = $(this).find('button[type="submit"]');
      submitButton.attr('disabled', true);

      // Build export file
      var form = new FormData(this);
      $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        data: form,
        processData: false,
        contentType: false,
        success: function (data) {
          // File is built, now download
          var form = $(document.createElement('form'));
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
        var delay = 200;
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
    var form = $(document.createElement('form'));
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
    $('.mark').click(function(event) {
      var mark = $(this);
      var data = {};
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
    var data = {};
    data['markableType'] = type;
    data['markableIds'] = tableSelection.selectedIds();
    $.post('/marks', data, function(data) {
      // Render marks currently in view in the data table
      $('#' + resourceName + '-data tr[role="button"]').each(function() {
        var id = $(this).data('id');
        if ($.inArray(id, tableSelection.selectedIds()) != -1) {
          $(this).addClass('marked');
        }
      });
    });
  },

  batchUnmark: function(resourceName, type, tableSelection) {
    var data = {};
    data['markableType'] = type;
    data['markableIds'] = tableSelection.selectedIds();
    data['_method'] = 'DELETE';
    $.post('/marks', data, function(data) {
      // Remove marks currently in view in the data table
      $('#' + resourceName + '-data tr[role="button"]').each(function() {
        var id = $(this).data('id');
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
    $("input[value='<mixed>']").change(function() {
      jitterbug.handleMixedValueChange(this);
    });

    $('textarea').filter(function () {
      return $(this).val() === '<mixed>';
    }).change(function() {
      jitterbug.handleMixedValueChange(this);
    });

    $('select:has(option[value="<mixed>"]:selected)').change(function() {
      jitterbug.handleMixedValueChange(this);
    });
  },

  sequence: 0,

  handleMixedValueChange: function(that) {
    var input = $(that);
    var parent = $(that).closest('.detail-value');
    if ($(that).val() !== '<mixed>' && parent.hasClass('col-xs-7')) {
      parent.removeClass('col-xs-7');
      parent.addClass('col-xs-6');
      var divId = jitterbug.sequence++, linkId = jitterbug.sequence++;
      parent.after('\
        <div id=' + divId + ' class="col-xs-1 detail-value">\
          <a id=' + linkId + ' href="#" title="Reset">\
            <i class="fa fa-reply" aria-hidden="true"></i>\
          </a>\
        </div>\
      ');
      $('#' + linkId + '').click(function(event) {
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
      var modalOpen = false;
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
    $('.revision-history-title').click(function(event) {
      event.preventDefault();
      var icon = $('.revision-history-title i');
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

  initRelatedPreservationMasters: function() {
    $('#related-masters tr[role="button"]').click(function(event) {
      window.location.href='/masters/' + $(this).data('id');
    });
  },

  initRelatedCuts: function() {
    $('#related-cuts tr[role="button"]').click(function(event) {
      window.location.href='/masters/' + $(this).data('master') + 
      '/cuts/' + $(this).data('id');
    });
  },

  initRelatedTransfers: function() {
    $('#related-transfers tr[role="button"]').click(function(event) {
      window.location.href='/transfers/' + $(this).data('id');
    });
  },

  initIndexPage: function(resourceName) {
    var searchField = jitterbug.SearchField.load(resourceName + 'SearchField');
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

    var filterPanel = jitterbug.FilterPanel.load(resourceName + 'FilterPanel');
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

    var tableParams = jitterbug.TableParams.load(resourceName + 'TableParams');
    if (tableParams==null) {
      tableParams = new jitterbug.TableParams({
          key:resourceName + 'TableParams'});
      tableParams.store();
    }
    jitterbug.tableParams = tableParams;

    var tableSelection = 
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

    var queryManager = new jitterbug.QueryManager(searchField, filterPanel, 
                                tableParams, tableSelection, resourceName);
    jitterbug.tableSelection.setQueryManager(queryManager);

    queryManager.init();
    queryManager.executeQuery();

    jitterbug.queryManager = queryManager;
  },

  initItemsIndex: function() {
    jitterbug.initIndexPage('items');
  },

  initMastersIndex: function() {
    jitterbug.initIndexPage('masters');
  },

  initTransfersIndex: function() {
    jitterbug.initIndexPage('transfers');
  },

  QueryManager: function(searchFieldInstance, filterPanelInstance,
             tableParamsInstance, tableSelectionInstance, resourceName) {
    var searchField = searchFieldInstance,
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
      var query = {};
      query['search'] = searchField.elementValue();
      query = $.extend(query, filterPanel.selectedFilters());
      return JSON.stringify(query);
    },
    
    executeQuery = function() {
      var query = {};
      query['q'] = encodeURIComponent(queryString());
      query['page'] = tableParams.getPage();
      query['perPage'] = tableParams.getPerPage();

      $.get('/' + resource, query, function(data) {
        $('#data-container').replaceWith(data);

        var dataSelector = '#' + resource + '-data';
        // Initialize the colResizable plugin. Note that we're using a very
        // slightly modified version that doesn't set an explict width of the
        // grip container element.
        $(dataSelector).colResizable(
          {partialRefresh: true, postbackSafe: true, removePadding: false});

        tableSelection.init();

        $.publish('dataLoaded');

        // Bind click handlers to all data table rows
        $(dataSelector + ' tr[role="button"]').click(function(event) {
          tableSelection.clear();
          tableSelection.render();
          window.location.href='/' + resource + '/' + $(this).data('id');
        });

        // Bind click handlers to all data pagination links
        if ($('.pagination').length) {
          var currentPage = parseInt($('.page-item.active').text().trim());
          tableParams.setPage(currentPage);
          $('.pagination').each(function() {
            $('.page-link').each(function() {
              if ($(this).parent().hasClass('disabled') || 
                 $(this).parent().hasClass('active')) {
                return;
              } else if ($(this).hasClass('prev-page')) {
                $(this).click(function(event){
                  event.preventDefault();
                  tableParams.setPage(currentPage - 1);
                  executeQuery();
                });
              } else if ($(this).hasClass('next-page')) {
                $(this).click(function(event){
                  event.preventDefault();
                  tableParams.setPage(currentPage + 1);
                  executeQuery();
                });
              } else {
                $(this).click(function(event){
                  event.preventDefault();
                  tableParams.setPage($(this).text().trim());
                  executeQuery();
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
    var key = params.key,
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

    var key = params.key,
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
      var clearLink = $(selector).next().find('a');
      clearLink.click(function(event) {
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

    var key = params.key,
        location = params.location,
        selector = params.selector,
        listSelector = params.listSelector,
        selected = params.selectedFilters,
        lists = [],

    init = function() {
      $(selector).find(listSelector).each(function() {
        var list = new jitterbug.FilterList(this);
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
          var list = new jitterbug.FilterList(this);
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
    var list = listElement,
        checkboxes = $(list).find(':checkbox'),
    
    init = function() {
      $.each(checkboxes, function(i, checkbox) {
        $(checkbox).click(function(event) {
          // If this is an 'Any' checkbox
          if ($(this).is(checkboxes[0])) {

            // Prevent unchecking if it's already checked
            if (!$(this).is(':checked')) {
              event.preventDefault();
              return false;
            }

            // Uncheck the other filters
            for (var i = 1; i < checkboxes.length; i++) {
              checkboxes[i].checked = false;
            }
          } else {
            // Check if at least one non-Any filter is checked
            var oneIsChecked = false;
            for (var i = 1; i < checkboxes.length; i++) {
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
    },

    setSelected = function(selectedFilters) {
      var totalChecked = 0;
      $.each(checkboxes, function(i, checkbox) {
        if ($.inArray(checkbox.value, selectedFilters) != -1) {
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
      renderSelectionCount();
    },

    setDefault = function() {
      $.each(checkboxes, function(i, value) {
        if (i == 0) {
          checkboxes[i].checked = true;
        } else {
          checkboxes[i].checked = false;
        }
      });
    },

    listType = function() {
      return $(list).attr('id');
    },

    selectedFilters = function() {
      var selected = $(list).find('input:checked');
      var values = [];
      for (var i=0; i < selected.length; i++) {
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
        var countSelector = '#' + listType() + '-selection-count';
        if (count() > 0) {
          $(countSelector).html(count() + ' selected' + 
            ' <a id="' + listType() + '-clear-selection" href="#" style="color: #fff">\
                <i class="fa fa-times-circle" aria-hidden="true"></i>\
              </a>');
          $('#' + listType() + '-clear-selection').click(function(event) {
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

    var key = params.key,
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
      
      var dataTableRows = $(selector);

      // Prevent the user from selecting text in the data table
      dataTableRows.on('selectstart dragstart', function(event) {
        event.preventDefault();
      });

      // Bind click handlers to all data table rows
      dataTableRows.click(function(event) {
        // The index of the Solr search result
        var index = $(this).data('index');
        // The id of the record at the index
        var id = $(this).data('id');

        // If user is "shift-clicking" a row (i.e. selecting a range of rows)
        if (event.shiftKey) {
          resolveRange(index, id);
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
        var index = $(this).data('index'),
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
        var id = $(this).data('id');
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
        $('#clear-selection').click(function(event) {
          event.preventDefault();
          clear();
          render();
        });
      } else {
        $(countSelector).html('');
      }
    },

    // Resolve a range selection to an array of ids
    resolveRange = function(endIndex, endId) {
      if (beginIndex == null && beginId == null) {
        beginIndex = endIndex;
        beginId = endId;
        ids = [beginId];
      } else {
        var beforeCount = count();

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
            var query = {};
            query['q'] = encodeURIComponent(queryManager.queryString());
            var range = JSON.stringify({beginIndex: beginIndex, 
              beginId: beginId, endIndex: endIndex, endId: endId});
            query['r'] = encodeURIComponent(range);

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
      var table = tableToObject();
      return table[begin] != null && table[end] != null;
    },

    idsFromTable = function(begin, end) {
      var first = Math.min(begin, end),
      last = Math.max(begin, end);
      tableIds = [];
      $(selector).each(function() {
        var thisIndex = $(this).data('index'),
        thisId = $(this).data('id');
        if (thisIndex >= first && thisIndex <= last) {
          tableIds.push(thisId);
        }
      });
      return tableIds;
    },

    rangeInCache = function(begin, end) {
      var first = Math.min(begin, end),
      last = Math.max(begin, end);
      for(i = first; i <= last; i++) {
        if(cache[i] == null) {
          return false;
        }
      }
      return true;
    },

    idsFromCache = function(begin, end) {
      var first = Math.min(begin, end),
      last = Math.max(begin, end),
      cacheIds = [];
      for(i = first; i <= last; i++) {
        cacheIds.push(cache[i]);
      }
      return cacheIds;
    },

    tableToObject = function() {
      var table = {};
      $(selector).each(function() {
        table[$(this).data('index')] = $(this).data('id');
      });
      return table;
    },

    toggle = function(id) {
      var result = $.inArray(id, ids);
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
      var max = 3000;
      // This is kinda gross
      var total = parseInt($('.record-count').text().trim().split(/\s+/)[0]);
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
        for (var i = beginIndex; i <= endIndex; i++) {
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

    var key = params.key,
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
      $(filtersSelector).click(function(event) {
        event.preventDefault();
        currentFilter = $(this).data('filter');
        // when the filter changes, deselect all marks
        deselectAllMarks();
        store();
        render();
      });

      // Hook up user selection drop down
      $(usersSelector).click(function(event) {
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
        $(filtersSelector).each(function() {
          if (currentFilter == $(this).data('filter')) {
            $(this).addClass('active');
          } else {
            $(this).removeClass('active');
          }
        });
      }
      // set up delete marks button
      $('.delete-marks button').click(function() {
        var size = $('input.delete-checkbox:checkbox:checked').length;
        if (confirm('Are you sure you want to delete ' + size + ' marks?')) {
          deleteMarks();
        }
      });

      getMarks();
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
        var selectedUserFullName = selectedUserName();
        var truncatedUser = selectedUserFullName.length > 13 ? 
          selectedUserFullName.substr(0, 13) + '...' : selectedUserFullName;
        $(selectedUserSelector).text(truncatedUser);
        jitterbug.initSelectAll('#mark-checkbox-all', '.delete-checkbox:visible');
      });
    },

    deleteMarks = function() {
      var marksToDelete = {};

      // gather and sort all selected markable IDs by type
      $('input.delete-checkbox:checkbox:checked').each(function() {
        var parent = $(this).parent();
        var markId = parent.data('object-id');
        var type = parent.data('object-type');

        if (marksToDelete[type] === undefined) {
          marksToDelete[type] = [markId];
        } else {
          marksToDelete[type].push(markId);
        }
      });

      var keys = Object.keys(marksToDelete);

      for (var index in keys) {
        key = keys[index];

        // reformat names correctly
        if (key == 'item') {
          var markableType = 'AudioVisualItem';
        } else if (key == 'master') {
          var markableType = 'PreservationMaster';
        } else if (key == 'transfer') {
          var markableType = 'Transfer';
        }

        var data = {};
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
      $(marksSelector).click(function(event) {
        var type = $(this).data('object-type'),
        id = $(this).data('object-id');
        window.location.href='/' + type + 's/' + id;
      });

      // unlink delete checkboxes from the associated objects
      $('.delete-checkbox').click(function(event) {
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
      var hasOne = false;
      $(marksSelector).each(function() {
        if (currentFilter == 'all') {
          $(this).show();
          hasOne = true;
          return true;
        }
        var type = $(this).data('object-type');
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
          case 'master':
            $(noMarksSelector).text('No preservation masters are currently marked.');
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
      var currentUser = {};
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
    var string = null;
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
  var o = $({});
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

