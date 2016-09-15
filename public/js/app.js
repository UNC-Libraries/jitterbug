junebug = {
  clearStorage: function() {
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
  },

  initAjax: function() {
    $.ajaxSetup({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
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
        junebug.displayAlert(data['type'],data['message']);
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

  initItemsNewButton: function() {
    $('#items-new').click(function(event) {
      junebug.TableSelection.load('itemsTableSelection','session').clear();
    });
  },

  initItemsBatchMenu: function() {
    $('#items-batch-edit').click(function(event) {
      var tableSelection = 
          junebug.TableSelection.load('itemsTableSelection','session');
      if (tableSelection.count() == 0) {
        junebug.displayAlert('warning',
          '<strong>Here\'s a tip:</strong> Batch actions require a table \
          selection. Make a selection by \'shift-clicking\' \
          or \'command-clicking\' on rows of the table.');
        return;
      }
      if (tableSelection.count() == 1) {
        junebug.displayAlert('warning',
          '<strong>More please!</strong> Batch actions require at least \
          2 records to be selected. Make a selection by \
          \'shift-clicking\' or \'command-clicking\' on rows of the table.');
        return;
      }

      var form = $(document.createElement('form'));
      form.attr('action', '/items/batch/edit');
      form.attr('method', 'post');
      $('<input>').attr('type', 'hidden')
        .attr('name', 'ids')
        .attr('value', tableSelection.ids)
        .appendTo(form);
      $('<input>').attr('type', 'hidden')
        .attr('name', '_token')
        .attr('value', $('meta[name="csrf-token"]').attr('content'))
        .appendTo(form);                              
      form.appendTo(document.body).submit().remove();
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

  initFileSelect: function() {
    $(':file').change(function() {
      var input = $(this),
      fileName = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.trigger('fileselect', fileName);
    });
    $('#audio-import-file').on('fileselect', function(event, fileName) {
      $('#audio-import-filename').val(fileName);
    });
    $('#vendor-import-file').on('fileselect', function(event, fileName) {
      $('#vendor-import-filename').val(fileName);
    });
  },

  initAudioImportModal: function() {
    junebug.initAudioUploadForm();
    junebug.initAudioImportForm();

    // Click handlers for 'start over' links and buttons
    $('#audio-import-modal .reset').click(function(event) {
      event.preventDefault();
      junebug.resetAudioImportModal();
    });

    // Clean up when modal is closed
    $('#audio-import-modal').on('hidden.bs.modal', function () {
      junebug.resetAudioImportModal();
    });
  },

  resetAudioImportModal: function() {
    $('#audio-import-file').val('');
    $('#audio-import-filename').val('');
    $('#audio-upload-form-error').html('').hide();
    $('#audio-import-dialog').width(400);
    $('#audio-import-dialog-content').width(400);
    $('#audio-import-step-2 .modal-body').height(80);
    // In order to scroll a div, it must not be hidden
    $('#audio-import-step-2').show();
    $('#audio-import-step-2 .modal-body').scrollTop(0);
    $('#audio-import-step-1').show();
    $('#audio-import-step-2').hide();
    $('#audio-import-step-2 .success-actions').show();
    $('#audio-import-step-2 .failure-actions').hide();
    $('#audio-import-step-3 .modal-body').scrollTop(0);
    $('#audio-import-step-3').hide();
  },

  initAudioUploadForm: function() {
    $('#audio-upload-form').submit( function(event) {
      event.preventDefault();

      if(!junebug.validateUploadForm('audio')) {
        return;
      }

      $('#audio-upload-spinner').show();
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
            $('#audio-import-step-2 .success-actions').hide();
            $('#audio-import-step-2 .failure-actions').show();
          }
          // Animation is handled via CSS transition
          $('#audio-import-dialog').width(700);
          $('#audio-import-dialog-content').width(700);
          // Delay to let the css transition finish (hack)
          var delay = 500;
          setTimeout(function() {
            $('#audio-import-step-1').hide();
            $('#audio-import-step-2').show();
            $('#audio-import-step-2 .modal-body').height(300);
          }, delay);

          $('#audio-upload-data-container').replaceWith(data['html']);
        },
        error: function (jqXHR, textStatus, error) {
          console.log('upload failure: ' + textStatus);
          if (jqXHR.status==500) {
            $('#audio-upload-form-error').html('<small>An error occurred \
              while parsing your file. Check that it\'s a \
              valid .csv file.</small>').show();
          } else {
            $('#audio-upload-form-error').html('<small>An error occurred \
              while uploading your file. Refresh the page and try \
              again.</small>').show();
          }
        },
        complete: function() {
          $('#audio-upload-spinner').hide();
        }
      });
    });
  },

  initAudioImportForm: function() {
    $('#audio-import-form').submit( function(event) {
      event.preventDefault();

      $('#audio-import-spinner').show();
      var form = new FormData(this);
      $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        data: form,
        processData: false,
        contentType: false, 
        success: function (data) {
          var status = data['status'];

          $('#audio-import-result-container').replaceWith(data['html']);
          $('#audio-import-step-2').hide();
          $('#audio-import-step-3 .modal-body').height(300);
          $('#audio-import-step-3').show();
          if (status=='success') {
            $('#audio-import-step-3 .modal-body').height(50); 
          }
          // Initialize popovers which contain any errors
          junebug.initPopovers();
        },
        error: function (jqXHR, textStatus, error) {
          console.log('import failure: ' + textStatus);
        },
        complete: function() {
          $('#audio-import-spinner').hide();
        }
      });
    });
  },

  validateUploadForm: function(type) {
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
      junebug.handleMixedValueChange(this);
    });

    $('textarea').filter(function () {
      return $(this).val() === '<mixed>';
    }).change(function() {
      junebug.handleMixedValueChange(this);
    });

    $('select:has(option[value="<mixed>"]:selected)').change(function() {
      junebug.handleMixedValueChange(this);
    });
  },

  sequence: 0,

  handleMixedValueChange: function(that) {
    var input = $(that);
    var parent = $(that).closest('.detail-value');
    if ($(that).val() !== '<mixed>' && parent.hasClass('col-xs-7')) {
      parent.removeClass('col-xs-7');
      parent.addClass('col-xs-6');
      var divId = junebug.sequence++, linkId = junebug.sequence++;
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
    // Page next or previous using the keyboard
    $(document).keydown(function(event) {
      // Right arrow
      if (event.which == 39) {
        $('.next-page').first().trigger("click");
      // Left arrow
      } else if (event.which == 37) {
        $('.prev-page').first().trigger("click");
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
    var searchField = junebug.SearchField.load(resourceName + 'SearchField');
    if (searchField==null) {
      searchField = new junebug.SearchField({
          key:resourceName + 'SearchField',
          selector:'#search'});
      searchField.init();
      searchField.store();
    } else {
      searchField.init();
    }

    var filterPanel = junebug.FilterPanel.load(resourceName + 'FilterPanel');
    if (filterPanel==null) {
      filterPanel = new junebug.FilterPanel({
          key:resourceName + 'FilterPanel',
          selector:'#filter-panel',
          listSelector: '.filter-list'});
      filterPanel.init();
      filterPanel.store();
    } else {
      filterPanel.init();
    }

    var tableParams = junebug.TableParams.load(resourceName + 'TableParams');
    if (tableParams==null) {
      tableParams = new junebug.TableParams({
          key:resourceName + 'TableParams'});
      tableParams.store();
    }

    var tableSelection = 
      junebug.TableSelection.load(resourceName + 'TableSelection','session');
    if (tableSelection==null) {
      tableSelection = new junebug.TableSelection({
          key:resourceName + 'TableSelection',
          resource: resourceName,
          location:'session',
          selector:'#data tr[role="button"]',
          countSelector:'.selection-count'});
      tableSelection.init();
      tableSelection.store();
    } else {
      tableSelection.init();
      tableSelection.render();
    }

    var queryManager = new junebug.QueryManager(searchField, filterPanel, 
                                tableParams, tableSelection, resourceName);
    tableSelection.setQueryManager(queryManager);

    queryManager.init();
    queryManager.executeQuery();
  },

  initItemsIndex: function() {
    junebug.initIndexPage('items');
  },

  initMastersIndex: function() {
    junebug.initIndexPage('masters');
  },

  initTransfersIndex: function() {
    junebug.initIndexPage('transfers');
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

        tableSelection.init();

        $.publish('dataLoaded');

        // Bind click handlers to all data table rows
        $('#data tr[role="button"]').click(function(event) {
          tableSelection.clear();
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
                $(this).click(function(){
                  tableParams.setPage(currentPage - 1);
                  executeQuery();
                });
              } else if ($(this).hasClass('next-page')) {
                $(this).click(function(){
                  tableParams.setPage(currentPage + 1);
                  executeQuery();
                });
              } else {
                $(this).click(function(){
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
      throw new junebug.IllegalArgumentException("Param 'selector' " +
        "is required.");
    }

    var key = params.key,
        location = params.location,
        selector = params.selector,
        value = params.value,
        lastValue = params.lastValue,

    init = function() {
      $(selector).val(value);

      // Handle "enter" keypress on search input
      $(selector).keypress(function(event) {
        if (enterKey(event)) {
          event.preventDefault();
          lastValue = elementValue();
          store();

          $.publish('searchSubmitted');
        }
      });
      // Handle "delete" key on search input
      $(selector).keyup(function(event){
        if (deleteKey(event)) {
          if (searchTermsRemoved()) {
            store();

            $.publish('searchSubmitted');
          }
          lastValue = elementValue();
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
      throw new junebug.IllegalArgumentException("Params 'selector' " +
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
        var list = new junebug.FilterList(this);
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
          var list = new junebug.FilterList(this);
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

          $.publish('filterChanged');
        });
      });
    },

    setSelected = function(selectedFilters) {
      $.each(checkboxes, function(i, checkbox) {
        if ($.inArray(checkbox.value,selectedFilters) != -1) {
          checkbox.checked = true;
        } else {
          checkbox.checked = false;
        }
      });
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
      throw new junebug.IllegalArgumentException("Params 'resource', " +
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
          clear();
          render();
        });
      } else {
        $(countSelector).html('');
      }
    },

    // Resolve a range selection to an array of ids
    resolveRange = function(endIndex, endId) {
      if (beginIndex == null || beginId == null) {
        beginIndex = endIndex;
        beginId = endId;
        ids = [beginId];
      } else {
        var beforeCount = count();

        // Check if full range is currently within the table on screen
        if (rangeInTable(beginIndex, endIndex)) {
          console.log('Getting range from table');
          var firstIndex = Math.min(beginIndex, endIndex),
          lastIndex = Math.max(beginIndex, endIndex);
          ids = [];
          $(selector).each(function() {
            var thisIndex = $(this).data('index'),
            thisId = $(this).data('id');
            if (thisIndex >= firstIndex && thisIndex <= lastIndex) {
              ids.push(thisId);
            }
          });
        // Full range is not in the table, so check to see if it's in cache
        } else if (rangeInCache(beginIndex, endIndex)) {
          console.log('Getting range from cache');
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
                  junebug.displayAlert('danger',
                    '<strong>Sorry to interrupt!</strong> It appears someone \
                    has changed the data you\'re viewing. Please reload your \
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

    rangeInTable = function(begin, end) {
      var table = tableToObject();
      return table[begin] != null && table[end] != null;
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
      if (count()==0) {
        clear();
      }
    },

    setQueryManager = function(manager) {
      queryManager = manager;
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
      ids: ids,
      render: render,
      clear: clear,
      count: count,
      setQueryManager: setQueryManager,
      store: store,
      toJson: toJson,
      toString: toString      
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

junebug.SearchField.load = junebug.loader;
junebug.TableParams.load = junebug.loader;
junebug.FilterPanel.load = junebug.loader;
junebug.TableSelection.load = junebug.loader;

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

