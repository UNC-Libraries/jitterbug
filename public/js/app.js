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
    
    localStorage.removeItem('itemSelection');
    doSearch();
  });

  // Handle "enter" keypress on search input
  $('#search').keypress(function(event) {
    if(event.which == 13) {
      event.preventDefault();

      localStorage.removeItem('itemSelection');
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
    renderSelection();

    // Disable text selection of data table row text
    var dataTableRows = $('#data tr[role="button"]');
    dataTableRows.bind('selectstart dragstart', function(event) {
      event.preventDefault();
      return;
    });
    // Bind click handlers to all data table rows
    dataTableRows.click(function(event) {
      var selection = localStorage.getItem('itemSelection');
      var rowIndex = $(this).data('index');

      // If user is "shift-clicking" a row (i.e. selecting multiple rows)
      if(event.shiftKey) {
        if (selection == null) {
          selection = {'begin':rowIndex,
                         'end':rowIndex,
                    'excludes':[],
                    'includes':[]};
        } else {
          selection = JSON.parse(selection);
          if(selection['begin']==null) {
            selection['begin'] = rowIndex;
          }
          selection['end'] = rowIndex;
          selection['excludes'] = [];
          selection['includes'] = [];
        }
        localStorage.setItem('itemSelection', JSON.stringify(selection));
        
        renderSelection();
        return;
      }
      // If user is "command-clicking" (Mac) (or control on Windows) 
      // a row (i.e. selecting/deselecting single row)
      if(event.ctrlKey || event.metaKey) {
        if (selection == null) {
          selection = {'begin':null,
                         'end':null,
                    'excludes':[rowIndex],
                    'includes':[]};
        } else {
          selection = JSON.parse(selection);
          var begin = selection['begin'];
          var end = selection['end'];
          var excludes = selection['excludes'];
          var includes = selection['includes'];

          // User is clicking within the defined range
          if(isInRange(rowIndex,begin,end)) {
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
        }
        localStorage.setItem('itemSelection', JSON.stringify(selection));
        
        renderSelection();
        return;
      }

      // User is singly clicking on a data table row
      localStorage.removeItem('itemSelection');
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

function renderSelection() {
  var selection = localStorage.getItem('itemSelection');
  if (selection == null) {
    return;
  } else {
    selection = JSON.parse(selection);
  }
  $('#data tr[role="button"]').each(function() {
    var rowIndex = $(this).data('index');
    if(isRowSelected(rowIndex, selection)) {
      $(this).addClass('selected');
    } else {
      $(this).removeClass('selected');
    }
  });
}

function isRowSelected(rowIndex,selection) {
  var begin = selection['begin'];
  var end = selection['end'];
  var excludes = selection['excludes'];
  var includes = selection['includes'];
  if((isInRange(rowIndex, begin, end) && 
       $.inArray(rowIndex, excludes) == -1) || 
       $.inArray(rowIndex, includes) != -1) {
    return true;
  } else {
    return false;
  }
}

function isInRange(number,begin,end) {
  if(number==null || begin==null || end==null) {
    return false;
  }
  if(number >= Math.min(begin, end) && 
     number <= Math.max(begin, end)) {
    return true;
  } else {
    return false;
  }
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
  $('a[data-confirm], input[data-confirm], button[data-confirm]').
                                                  click(function() {
    if (!confirm($(this).attr('data-confirm'))) {
      return false;
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


/*
 * A TableSelection contains indices of solarium search results, 
 * not a collection of record ids, because the ids are
 * potentially not known at the time of selection (i.e. in the
 * case where a user selects a few records, and then pages over
 * multiple pages, skipping a pages in between.)
 * 'selector' = jQuery selector for the table rows
 * 'begin' = beginning index of the selection range
 * 'end' = ending index of the selection range
 * 'excludes' = ids within the selection range to be excluded
 * 'includes' = ids outside of the selection range to be included
 */
function TableSelection(params) {
  var selector = params.selector;
  var begin = params.begin;
  var end = params.end;
  var excludes = params.excludes;
  var includes = params.includes;

  var init = function() {
    // Disable text selection of data table row text
    var dataTableRows = $(selector);
    dataTableRows.bind('selectstart dragstart', function(event) {
      event.preventDefault();
      return;
    });
  }

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
    var that = this;
    $(selector).each(function() {
      var rowIndex = $(this).data('index');
      if(that.selected(rowIndex)) {
        $(this).addClass('selected');
      } else {
        $(this).removeClass('selected');
      }
    });
  };

  var toggle = function(rowIndex) {
    // User is clicking within the defined range
    if(isInRange(rowIndex)) {
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

  var store = function(key, location) {
    if (location=='local') {
      localStorage.setItem(key, toString());
    } else if (location=='session') {
      sessionStorage.setItem(key, toString());
    }
  }

  var toString = function() {
    return JSON.stringify({
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
    toggle: toggle,
    store: store,
    toString: toString
  };

};

TableSelection.load = function(key, location) {
  var object;
  if (location=='local') {
    object = JSON.parse(localStorage.getItem(key));
  } else if (location=='session') {
    object = JSON.parse(sessionStorage.getItem(key));
  }
  return new Selection(object);
}




