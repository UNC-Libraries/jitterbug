junebug = {
  clearStorage: function() {
    // clear items state
    localStorage.removeItem('itemSearchField');
    localStorage.removeItem('itemFilterPanel');
    sessionStorage.removeItem('itemTableSelection');
    localStorage.removeItem('itemTableParams');
    // clear masters state
    localStorage.removeItem('masterSearchField');
    localStorage.removeItem('masterFilterPanel');
    sessionStorage.removeItem('masterTableSelection');
    localStorage.removeItem('masterTableParams');
  },

  initAjax: function() {
    $.ajaxSetup({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
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

  initDatepicker: function() {
    $('#detail .input-group.date').datepicker({
      format: "yyyy-mm-dd"
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

  initItemsNewButton: function() {
    $('#items-new').click(function(event) {
      junebug.TableSelection.load('itemTableSelection','session').clear();
    });
  },

  initItemsBatchMenu: function() {
    $('#items-batch-edit').click(function(event) {
      var tableSelection = 
          junebug.TableSelection.load('itemTableSelection','session');
      if (tableSelection.count() == 0) {
        junebug.displayAlert('warning',
          '<strong>Here\'s a tip:</strong> Batch actions require a table selection. \
          Make a selection by \'shift-clicking\' or \'command-clicking\' \
          on rows of the table.');
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
    $('.revision-history-title').click(function() {
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

  initItemSuggestions: function() {
    $('#recording-location').autocomplete({
      serviceUrl: '/suggestions/recording-locations',
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

  initItemPreservationMasters: function() {
    $('#related-masters tr[role="button"]').click(function(event) {
      window.location.href='/masters/' + $(this).data('id');
    });
  },

  initItemsIndex: function() {
    var searchField = junebug.SearchField.load('itemSearchField');
    if (searchField==null) {
      searchField = new junebug.SearchField({
          key:'itemSearchField',
          selector:'#search'});
      searchField.init();
      searchField.store();
    } else {
      searchField.init();
    }

    var filterPanel = junebug.FilterPanel.load('itemFilterPanel');
    if (filterPanel==null) {
      filterPanel = new junebug.FilterPanel({
          key:'itemFilterPanel',
          selector:'#filter-panel',
          listSelector: '.filter-list'});
      filterPanel.init();
      filterPanel.store();
    } else {
      filterPanel.init();
    }

    var tableParams = junebug.TableParams.load('itemTableParams');
    if (tableParams==null) {
      tableParams = new junebug.TableParams({
          key:'itemTableParams'});
      tableParams.store();
    }

    var tableSelection = 
      junebug.TableSelection.load('itemTableSelection','session');
    if (tableSelection==null) {
      tableSelection = new junebug.TableSelection({
          key:'itemTableSelection',
          location:'session',
          resource: 'items',
          selector:'#data tr[role="button"]',
          countSelector:'.selection-count'});
      tableSelection.init();
      tableSelection.store();
    } else {
      tableSelection.init();
      tableSelection.render();
    }

    var queryManager = new junebug.QueryManager(searchField, filterPanel, 
                                tableParams, tableSelection, 'items');
    tableSelection.setQueryManager(queryManager);

    queryManager.init();
    queryManager.executeQuery();
  },

  initMastersIndex: function() {
    var searchField = junebug.SearchField.load('masterSearchField');
    if (searchField==null) {
      searchField = new junebug.SearchField({
          key:'masterSearchField',
          selector:'#search'});
      searchField.init();
      searchField.store();
    } else {
      searchField.init();
    }

    var filterPanel = junebug.FilterPanel.load('masterFilterPanel');
    if (filterPanel==null) {
      filterPanel = new junebug.FilterPanel({
          key:'masterFilterPanel',
          selector:'#filter-panel',
          listSelector: '.filter-list'});
      filterPanel.init();
      filterPanel.store();
    } else {
      filterPanel.init();
    }

    var tableParams = junebug.TableParams.load('masterTableParams');
    if (tableParams==null) {
      tableParams = new junebug.TableParams({
          key:'masterTableParams'});
      tableParams.store();
    }

    var tableSelection = 
      junebug.TableSelection.load('masterTableSelection','session');
    if (tableSelection==null) {
      tableSelection = new junebug.TableSelection({
          key:'masterTableSelection',
          resource: 'masters',
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
                                tableParams, tableSelection, 'masters');
    tableSelection.setQueryManager(queryManager);

    queryManager.init();
    queryManager.executeQuery();
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

