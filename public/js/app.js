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
  itemSelection = TableSelection.load('itemSelection','session');
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

    itemSelection = TableSelection.load('itemSelection','session');
    itemSelection.init();
    itemSelection.render();

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


/**
 * A TableSelection models a user's selection of multiple
 * rows of a table by 'shift-clicking' or 'command-clicking'
 * on rows to make the selection, rather than using form
 * checkboxes.
 * 
 * Rows of the table must have the data attribute 'data-index'
 * on them that reflects the index of the record in the table,
 * not the id of the record in the database. Internally,
 * TableSelection stores a range selection (beginning and 
 * ending indices), an array of indices that should be
 * excluded from the range (produced by a user 'command-clicking')
 * within the range, and an array of indices that should be 
 * included in the selection, also produced by a user
 * command clicking, but outside of the range.
 *
 * If storage parameters are supplied (storage key and location),
 * the table selection will persist itself when the selection
 * changes.
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
  var key = params.key,
      location = params.location,
      selector = params.selector,
      begin = params.begin,
      end = params.end,
      excludes = params.excludes != null ? params.excludes : [],
      includes = params.includes != null ? params.includes : [];

  var init = function() {
    var dataTableRows = $(selector);

    // Prevent the user from selecting text in the data table
    dataTableRows.on('selectstart dragstart', function(event) {
      event.preventDefault();
    });

    // Bind click handlers to all data table rows
    dataTableRows.click(function(event) {
      // The index of the Solr search result, not the table
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
  }

  var finalizeEvent = function(event) {
    store();
    render();
    event.stopImmediatePropagation();
  };

  var selected = function(rowIndex) {
    if((inRange(rowIndex) && 
      $.inArray(rowIndex, excludes) == -1) || 
      $.inArray(rowIndex, includes) != -1) {
      return true;
    } else {
      return false;
    }
  };

  var render = function() {
    $(selector).each(function() {
      var rowIndex = $(this).data('index');
      if(selected(rowIndex)) {
        $(this).addClass('selected');
      } else {
        $(this).removeClass('selected');
      }
    });
  };

  var setRange = function(rowIndex) {
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
  }

  var toggle = function(rowIndex) {
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
  }

  var inRange = function(rowIndex) {
    if(rowIndex==null || begin==null || end==null) {
      return false;
    }
    if(rowIndex >= Math.min(begin, end) && 
      rowIndex <= Math.max(begin, end)) {
      return true;
    } else {
      return false;
    }
  };

  var store = function() {
    if (key != null) {
      if (location=='local' || location==null) {
        localStorage.setItem(key, toString());
      } else if (location=='session') {
        sessionStorage.setItem(key, toString());
      }
    }
  }

  var remove = function() {
    if (key != null) {
      if (location=='local' || location==null) {
        localStorage.removeItem(key);
      } else if (location=='session') {
        sessionStorage.removeItem(key);
      }
    }
  };

  var clear = function() {
    begin = null;
    end = null;
    excludes = [];
    includes = [];
    store();
  };

  var count = function() {
    var max = Math.max(begin, end);
    var min = Math.min(begin, end);
    if(begin==null) {
      rangeCount = 0;
    } else {
      rangeCount = max - min + 1;
    }
    var total = rangeCount - excludes.length + includes.length;
    return total;
  };

  var toString = function() {
    return JSON.stringify({
      key:key,
      location:location,
      selector:selector,
      begin:begin,
      end:end,
      excludes:excludes,
      includes:includes
    });
  };

  return {
    init: init,
    selected: selected,
    render: render,
    store: store,
    clear: clear,
    count: count,
    toString: toString
  };

};

TableSelection.load = function(key, location) {
  if(key==null) {
    console.log('Could not load table selection. Key is null');
    return null;
  }
  var string;
  if (location=='local' || location==null) {
    string = localStorage.getItem(key);
  } else if (location=='session') {
    string = sessionStorage.getItem(key);
  }
  if(string==null) {
    return null;
  }
  params = JSON.parse(string);

  return new TableSelection(params);
}




