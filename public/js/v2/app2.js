$(function() {
  // Bind click handlers to search filters
  $('#filter-panel :checkbox').click(function(event) {
    // Find all the sibling checkboxes including the one clicked
    var filterListCheckboxes = $(this).closest('.filter-list').find(':checkbox');
    // If this is an 'Any' checkbox
    if($(this).is(filterListCheckboxes[0])) {

      // Prevent unchecking if it's already checked
      if (!$(this).is(':checked')) {
        event.preventDefault();
        return false;
      }

      // Uncheck the other filters
      for(var i = 1; i < filterListCheckboxes.length; i++) {
        filterListCheckboxes[i].checked = false;
      }
    } else {
      // Check if at least one non-Any filter is checked
      var oneIsChecked = false;
      for(var i = 1; i < filterListCheckboxes.length; i++) {
        if(filterListCheckboxes[i].checked == true) {
            oneIsChecked = true;
            break;
        }
      }

      // If one is checked, turn off the Any filter
      if(oneIsChecked) {
        filterListCheckboxes[0].checked = false;
      } else {
        filterListCheckboxes[0].checked = true;
      }
    }
    
    TableSelection.load('itemSelection','session').clear();
    doSearch();
  });

  // Handle "enter" keypress on search input
  $('#search').keypress(function(event) {
    if(event.which == 13) {
      event.preventDefault();

      TableSelection.load('itemSelection','session').clear();
      doSearch();
    }
  });
  
  // Page next or previous using the keyboard
  $(document).keydown(function(event) {
    // Right arrow
    if(event.which == 39) {
      $('.next-page').first().trigger("click");
    // Left arrow
    } else if (event.which == 37) {
      $('.prev-page').first().trigger("click");
    }
  });

  if (location.pathname === '/items') {
    initialize();
    query = {};
    if(localStorage.getItem('page') != null) {
      query['page'] = localStorage.getItem('page');    
    }
    doSearch(query);
  }

});

function initialize() {
  var itemSelection = TableSelection.load('itemSelection','session');
  if(itemSelection==null) {
    itemSelection = new TableSelection({
        key:'itemSelection',
        location:'session',
        selector:'#data tr[role="button"]'});
    itemSelection.init();
    itemSelection.store();
  } else {
    itemSelection.render();
  }

  queryString = localStorage.getItem('q');
  if(queryString != null) {
    queryFilters = JSON.parse(queryString);
    $('#search').val(queryFilters['search']);
    $('#filter-panel .filter-list').each(function() {
      filterListId = this.id;
      selectedFilters = queryFilters[filterListId];
      var filterListCheckboxes = $(this).find(':checkbox');
      for(var i = 0; i < filterListCheckboxes.length; i++) {
        checkbox = filterListCheckboxes[i];
        if($.inArray(checkbox.value,selectedFilters) != -1) {
          checkbox.checked = true;
        } else {
          checkbox.checked = false;
        }
      }
    });
  } else {
    // Reset checkboxes to default state if not in storage
    $('#filter-panel .filter-list').each(function() {
      var filterListCheckboxes = $(this).find(':checkbox');
      for(var i = 0; i < filterListCheckboxes.length; i++) {
        if(i == 0) {
          filterListCheckboxes[i].checked = true;
        } else {
          filterListCheckboxes[i].checked = false;
        }
      }
    });
  }
}

function searchQuery() {
  // Find all selected filters
  var queryFilters = {};
  queryFilters['search'] = $('#search').val();
  $('#filter-panel .filter-list').each(function() {
    var checkedFilters = $(this).find('input:checked');
    var values = [];
    for(var i=0; i < checkedFilters.length; i++) {
      values.push(checkedFilters[i].value);
    }
    queryFilters[this.id] = values;

  });
  return JSON.stringify(queryFilters);
}

function doSearch(query) {
  if(query==null) {
    query = {};
  }
  var queryString = searchQuery();
  localStorage.setItem('q',queryString);
  query['q'] = encodeURIComponent(queryString);
  $.get('/items', query, function(data) {
    $('#data-container').replaceWith(data);

    var itemSelection = TableSelection.load('itemSelection','session');
    itemSelection.init();

    $.publish('dataLoaded');

    // Bind click handlers to all data table rows
    $('#data tr[role="button"]').click(function(event) {
      itemSelection.clear();
      window.location.href="/items/" + $(this).data('id');
    });

    // Bind click handlers to all data pagination links
    if($('.pagination').length) {
      var currentPage = parseInt($('.page-item.active').text().trim());
      localStorage.setItem('page',currentPage);
      $('.pagination').each(function() {
        $('.page-link').each(function() {
          if($(this).parent().hasClass('disabled') || 
             $(this).parent().hasClass('active')) {
            return;
          } else if($(this).hasClass('prev-page')) {
            $(this).click(function(){
              query['page'] = currentPage - 1;
              doSearch(query);
            });
          } else if($(this).hasClass('next-page')) {
            $(this).click(function(){
              query['page'] = currentPage + 1;
              doSearch(query);
            });
          } else {
            $(this).click(function(){
              query['page'] = $(this).text().trim();
              doSearch(query);
            });
          }
        })
      });
    }
  });
}

function displayAlert() {
  alert = $('#alert');
  if(alert.text().trim().length && alert.is(':hidden')) {
    alert.delay(500).slideDown(200).delay(8000).slideUp(200);
  }
}

$(function() {
  displayAlert();
});

$('#detail .input-group.date').datepicker({
  format: "yyyy-mm-dd"
});

$(function() {
  $('#detail #item-type-controls :radio').click(function(event) {
    if($(this).val()=='AudioItem') {
      $('#audio-form').show();
      $('#film-form').hide();
      $('#video-form').hide();
    } else if($(this).val()=='FilmItem') {
      $('#audio-form').hide();
      $('#film-form').show();
      $('#video-form').hide();
    } else if($(this).val()=='VideoItem') {
      $('#audio-form').hide();
      $('#film-form').hide();
      $('#video-form').show();
    }
  });
});

$(function() {
  $('.revision-history-title').click(function() {
    var icon = $('.revision-history-title i');
    if(icon.hasClass('fa-caret-right')) {
      icon.removeClass('fa-caret-right');
      icon.addClass('fa-caret-down');
    } else {
      icon.removeClass('fa-caret-down');
      icon.addClass('fa-caret-right');
    }
    $('.revision-history').slideToggle(200);
  });
});

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

function itemsIndex() {
  var searchField = SearchField.load('itemSearchField');
  if(searchField==null) {
    searchField = new SearchField({
        key:'itemsSearchField',
        selector:'#search'});
    searchField.init();
    searchField.store();
  }

  var filterPanel = FilterPanel.load('itemFilterPanel');
  if(filterPanel==null) {
    filterPanel = new FilterPanel({
        key:'itemsFilterPanel',
        selector:'#filter-panel',
        listSelector: '.filter-list'});
    filterPanel.init();
    filterPanel.setDefault();
    filterPanel.store();
  }

  var tableParams = TableParams.load('itemTableParams');
  if(tableParams==null) {
    tableParams = new TableParams({
        key:'itemsTableParams'});
  }

  var tableSelection = TableSelection.load('itemTableSelection','session');
  if(tableSelection==null) {
    tableSelection = new TableSelection({
        key:'itemTableSelection',
        location:'session',
        selector:'#data tr[role="button"]'});
    tableSelection.init();
    tableSelection.store();
  } else {
    tableSelection.render();
  }

  var queryManager = 
    new QueryManager(searchField, filterPanel, tableParams, tableSelection);

  queryManager.executeQuery();
}

function QueryManager(searchFieldInstance, filterPanelInstance,
                      tableParamsInstance, tableSelectionInstance) {
  var searchField = searchFieldInstance,
      filterPanel = filterPanelInstance,
      tableSelection = tableSelectionInstance,
      tableParams = tableParamsInstance,

  init = function() {
    $.subscribe('filterPanelChanged', handleFilterChanged(event, object));
    $.subscribe('searchSubmitted', handleSearchChanged(event, object));
  },

  handleFilterPanelChanged = function(event, object) {
    console.log('filter panel changed');
    tableSelection.clear();
    executeQuery();
  },

  handleSearchSubmitted = function(event, object) {
    console.log('search submitted');
    tableSelection.clear();
    executeQuery();
  },

  queryString = function() {
    var query = {};
    query['search'] = searchField.value();
    query = $.extend(query, filterPanel.selectedFilters());
    query = $.extend(query, tableParams.allParams());
    return JSON.stringify(query);
  },
  
  executeQuery = function() {
    var query = encodeURIComponent(queryString());
    $.get('/items', query, function(data) {
      $('#data-container').replaceWith(data);

      itemSelection.init();

      $.publish('dataLoaded');

      // Bind click handlers to all data table rows
      $('#data tr[role="button"]').click(function(event) {
        itemSelection.clear();
        window.location.href="/items/" + $(this).data('id');
      });

      // Bind click handlers to all data pagination links
      if($('.pagination').length) {
        var currentPage = parseInt($('.page-item.active').text().trim());
        tableParams.setPage(currentPage);
        $('.pagination').each(function() {
          $('.page-link').each(function() {
            if($(this).parent().hasClass('disabled') || 
               $(this).parent().hasClass('active')) {
              return;
            } else if($(this).hasClass('prev-page')) {
              $(this).click(function(){
                tableParams.setPage(currentPage - 1);
                executeQuery();
              });
            } else if($(this).hasClass('next-page')) {
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
}

function TableParams(params) {
  var key = params.key,
      location = params.location,
      page = params.page == null ? 1 : params.page,
      perPage = params.perPage == null ? 20 : params.page,

  allParams = function() {
    return {
      page:page,
      perPage:perPage
    };
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

  setPage = function(pageNum) {
    page = pageNum;
    store();
  },

  setPerPage = function(perPageNum) {
    perPage = perPageNum;
    store();
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
    JSON.stringify(toJson());
  };

  return {
    allParams:allParams,
    setPage:setPage,
    setPerPage:setPerPage,
    store:store,
    toJson:toJson,
    toString:toString
  };
}

TableParams.load = loader;

function SearchField(params) {
  if(params==null || params.selector == null) {
    throw new IllegalArgumentException("Param 'selector' " +
      "is required.");
  }

  var key = params.key,
      location = params.location,
      selector = params.selector,
      value = params.value,
      lastValue = params.lastValue,

  init = function() {
    $(selector).val(lastValue);

    // Handle "enter" keypress on search input
    $(selector).keypress(function(event) {
      if(enterKey(event)) {
        event.preventDefault();
        lastValue = value();
        store();

        $.publish('searchSubmitted', toJson());
      }
    });
    // Handle "delete" key on search input
    $(selector).keyup(function(event){
      if(deleteKey(event)) {
        if(searchTermsRemoved()) {
          store();

          $.publish('searchSubmitted', toJson());
        }
        lastValue = value();
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
   return lastValue != null && lastValue != '' && value() == '';
  },

  value = function() {
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
      value:value()
    };
  },

  toString = function() {
    return JSON.stringify(toJson());
  };

  return {
    init: init,
    value: value,
    store: store,
    toJson: toJson,
    toString: toString
  };

}

SearchField.load = loader;

function FilterPanel(params) {
  if(params==null || params.selector == null || params.listSelector == null) {
    throw new IllegalArgumentException("Params 'selector' " +
      "and 'listSelector' are required.");
  }

  var key = params.key,
      location = params.location,
      selector = params.selector,
      listSelector = params.listSelector,
      selected = params.selectedFilters;
      lists = [],

  init = function() {
    $(selector).find(listSelector).each(function() {
      var list = new FilterList(this);
      list.init();

      if(selected != null && selected[list.listType()] != null) {
        list.setSelected(selected[list.listType()]);
      }

      lists.push(list);
    });
    $.subscribe('filterChanged', handleFilterChanged);
  },

  handleFilterChanged = function(event) {
    store();
    $.publish('filterPanelChanged',toJson());
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
    toJson: toJson,
    toString: toString
  };
}

FilterPanel.load = loader;


function FilterList(listElement) {
  var list = listElement,
      checkboxes = $(list).find(':checkbox'),
  
  init = function() {
    $.each(checkboxes, function(i, checkbox) {
      $(checkbox).click(function(event) {
        // If this is an 'Any' checkbox
        if($(this).is(checkboxes[0])) {

          // Prevent unchecking if it's already checked
          if (!$(this).is(':checked')) {
            event.preventDefault();
            return false;
          }

          // Uncheck the other filters
          for(var i = 1; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
          }
        } else {
          // Check if at least one non-Any filter is checked
          var oneIsChecked = false;
          for(var i = 1; i < checkboxes.length; i++) {
            if(checkboxes[i].checked == true) {
              oneIsChecked = true;
              break;
            }
          }

          // If one is checked, turn off the Any filter
          if(oneIsChecked) {
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
// filterPanel = new FilterPanel({selector:'#filter-panel',listSelector:'.filter-list',selectedFilters: {"type-filters":['1','2'],"collection-filters":['20012'],"format-filters":['0']}});
    $.each(checkboxes, function(i, checkbox) {
      if($.inArray(checkbox.value,selectedFilters) != -1) {
        checkbox.checked = true;
      } else {
        checkbox.checked = false;
      }
    });
  },

  setDefault = function() {
    $.each(checkboxes, function(i, value) {
      if(i == 0) {
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
    for(var i=0; i < selected.length; i++) {
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

}

/**
 * A TableSelection models a user's selection of multiple
 * rows of a table created by 'shift-clicking' or 'command-clicking'
 * on the rows to make the selection, rather than using form
 * checkboxes.
 * 
 * Rows of the table must have the data attribute 'data-index'
 * on them that reflects the index of the record in the table
 * (or in the search result if data is paginated across multiple
 * tables) not the id of the record in the database. Internally,
 * TableSelection stores a range selection (beginning and 
 * ending indices), an array of indices that should be
 * excluded from the range (produced by a user 'command-clicking'
 * within the range), and an array of indices that should be 
 * included in the selection, also produced by a user
 * command clicking, but outside of the range.
 *
 * If storage parameters are supplied (storage key and location),
 * the table selection will persist itself to local storage when 
 * the selection changes.
 *
 * Constructor params are as follows:
 * 'key' = storage key under which the serialized selection is stored
 * 'location' = storage location (can be 'session' or 'local')
 * 'selector' = jQuery selector for the table rows *required
 * 'begin' = beginning index of the selection range
 * 'end' = ending index of the selection range
 * 'excludes' = ids within the selection range to be excluded
 * 'includes' = ids outside of the selection range to be included
 */
function TableSelection(params) {
  if(params==null) {
    throw new IllegalArgumentException("Param 'selector' " +
      "is required.");
  }

  var key = params.key,
      location = params.location,
      selector = params.selector,
      begin = params.begin,
      end = params.end,
      excludes = params.excludes != null ? params.excludes : [],
      includes = params.includes != null ? params.includes : [],

  init = function() {

    $.unsubscribe('dataLoaded');
    
    var dataTableRows = $(selector);

    // Prevent the user from selecting text in the data table
    dataTableRows.on('selectstart dragstart', function(event) {
      event.preventDefault();
    });

    // Bind click handlers to all data table rows
    dataTableRows.click(function(event) {
      // The index of the Solr search result
      var rowIndex = $(this).data('index');

      // If user is "shift-clicking" a row (i.e. selecting a range of rows)
      if(event.shiftKey) {
        setRange(rowIndex);
        finalizeEvent(event);
        return;
      }

      // If user is "command-clicking" (Mac) (or control on Windows) 
      // a row (i.e. selecting/deselecting single row)
      if(event.ctrlKey || event.metaKey) {
        toggle(rowIndex);
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
    console.log('dataLoaded handler called');
    render();
  },

  selected = function(rowIndex) {
    if((inRange(rowIndex) && 
      $.inArray(rowIndex, excludes) == -1) || 
      $.inArray(rowIndex, includes) != -1) {
      return true;
    } else {
      return false;
    }
  },

  render = function() {
    $(selector).each(function() {
      var rowIndex = $(this).data('index');
      if(selected(rowIndex)) {
        $(this).addClass('selected');
      } else {
        $(this).removeClass('selected');
      }
    });
  },

  setRange = function(rowIndex) {
    if (begin == null) {
      begin = rowIndex;
      end = rowIndex;
    } else {
      var beforeCount = count();
      end = rowIndex;
      // Allows user to deselect a range
      if(count()==1 && beforeCount==1) {
        clear();
      }
    }
    excludes = [];
    includes = [];
  },

  toggle = function(rowIndex) {
    // User is clicking within the defined range
    if(inRange(rowIndex)) {
      var result = $.inArray(rowIndex, excludes);
      // Add row index to excludes
      if(result == -1) {
        excludes.push(rowIndex);
      } else {
        excludes.splice(result, 1);
      }
    // User is clicking outside the range
    } else {
      var result = $.inArray(rowIndex, includes);
      // Add row index to includes
      if(result == -1) {
        includes.push(rowIndex);
      } else {
        includes.splice(result, 1);
      }
    }
    if(count()==0) {
      clear();
    }
  },

  inRange = function(rowIndex) {
    if(rowIndex==null || begin==null || end==null) {
      return false;
    }
    if(rowIndex >= Math.min(begin, end) && 
      rowIndex <= Math.max(begin, end)) {
      return true;
    } else {
      return false;
    }
  },

  clear = function() {
    begin = null;
    end = null;
    excludes = [];
    includes = [];
    store();
  },

  count = function() {
    var max = Math.max(begin, end);
    var min = Math.min(begin, end);
    if(begin==null) {
      rangeCount = 0;
    } else {
      rangeCount = max - min + 1;
    }
    var total = rangeCount - excludes.length + includes.length;
    return total;
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
      begin:begin,
      end:end,
      excludes:excludes,
      includes:includes
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
    count: count,
    store: store,
    toJson: toJson,
    toString: toString
  };

}

TableSelection.load = loader;

function loader(key, location) {
  if(key==null) {
    console.log("Could not load object. Param 'key' is null.");
    return null;
  }
  var string = null;
  if (location=='local' || location==null) {
    string = localStorage.getItem(key);
  } else if (location=='session') {
    string = sessionStorage.getItem(key);
  }
  if(string==null) {
    return null;
  }
  params = JSON.parse(string);
  var className = this.name;
  return new (eval(className))(params);
}

function Persistable(key, location) {

  var store = function() {
    if (key != null) {
      if (location=='local' || location==null) {
        localStorage.setItem(key, toString());
      } else if (location=='session') {
        sessionStorage.setItem(key, toString());
      }
    }
  };

  var remove = function() {
    if (key != null) {
      if (location=='local' || location==null) {
        localStorage.removeItem(key);
      } else if (location=='session') {
        sessionStorage.removeItem(key);
      }
    }
  };

  return {
    store,
    remove
  };
}

function IllegalArgumentException(message) {
   this.message = message;
}

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

