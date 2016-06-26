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
    
    Cookies.remove('itemSelection');
    doSearch();
  });

  // Handle "enter" keypress on search input
  $('#search').keypress(function(event) {
    if(event.which == 13) {
      event.preventDefault();

      Cookies.remove('itemSelection');
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
    if(Cookies.get('page') != null) {
      query['page'] = Cookies.get('page');    
    }
    doSearch(query);
  }

});

function initialize() {
  
  queryCookie = Cookies.get('q');
  if(queryCookie != null) {
    queryCookie = decodeURIComponent(queryCookie);
    queryFilters = JSON.parse(queryCookie);
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
    // Reset checkboxes to default state if no cookie
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
  query['q'] = encodeURIComponent(searchQuery());
  Cookies.set('q',query['q']);
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
      var itemSelection = Cookies.get('itemSelection');
      var rowIndex = $(this).data('index');

      // If user is "shift-clicking" a row (i.e. selecting multiple rows)
      if(event.shiftKey) {
        if (itemSelection == null) {
          itemSelection = {'begin':rowIndex,
                             'end':rowIndex,
                      'inclusions':[],
                      'exclusions':[]};
        } else {
          itemSelection = JSON.parse(itemSelection);
          if(itemSelection['begin']==null) {
            itemSelection['begin'] = rowIndex;
          }
          itemSelection['end'] = rowIndex;
          itemSelection['inclusions'] = [];
          itemSelection['exclusions'] = [];
        }
        Cookies.set('itemSelection', itemSelection);
        
        renderSelection();
        return;
      }
      // If user is "command-clicking" (Mac) (or control on Windows) 
      // a row (i.e. selecting/deselecting single row)
      if(event.ctrlKey || event.metaKey) {
        if (itemSelection == null) {
          itemSelection = {'begin':null,
                             'end':null,
                      'inclusions':[rowIndex],
                      'exclusions':[]};
        } else {
          itemSelection = JSON.parse(itemSelection);
          var begin = itemSelection['begin'];
          var end = itemSelection['end']
          var inclusions = itemSelection['inclusions'];
          var exclusions = itemSelection['exclusions'];

          // User is clicking within the defined range
          if(isInRange(rowIndex,begin,end)) {
            var result = $.inArray(rowIndex, exclusions);
            // Add row index to exclusions
            if(result == -1) {
              exclusions.push(rowIndex);
            } else {
              exclusions.splice(result, 1);
            }
          // User is clicking outside the range
          } else {
            var result = $.inArray(rowIndex, inclusions);
            // Add row index to inclusions
            if(result == -1) {
              inclusions.push(rowIndex);
            } else {
              inclusions.splice(result, 1);
            }
          }
        }
        Cookies.set('itemSelection', itemSelection);
        
        renderSelection();
        return;
      }

      // User is singly clicking on a data table row
      Cookies.remove('itemSelection');
      window.location.href="/items/" + $(this).data('id');
    });

    // Bind click handlers to all data pagination links
    if($('.pagination').length) {
      var currentPage = parseInt($('.page-item.active').text().trim());
      Cookies.set('page',currentPage);
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
  var itemSelection = Cookies.get('itemSelection');
  if (itemSelection == null) {
    return;
  } else {
    itemSelection = JSON.parse(itemSelection);
  }
  $('#data tr[role="button"]').each(function() {
    var rowIndex = $(this).data('index');
    if(isRowSelected(rowIndex, itemSelection)) {
      $(this).addClass('selected');
    } else {
      $(this).removeClass('selected');
    }
  });
}

function isRowSelected(rowIndex,itemSelection) {
  var begin = itemSelection['begin'];
  var end = itemSelection['end'];
  var inclusions = itemSelection['inclusions'];
  var exclusions = itemSelection['exclusions'];
  if((isInRange(rowIndex, begin, end) && 
       $.inArray(rowIndex, exclusions) == -1) || 
       $.inArray(rowIndex, inclusions) != -1) {
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


$('#track-configuration').autocomplete({
  serviceUrl: '/suggestions/track-configurations',
  deferRequestBy: 100
});

$('#audio-base').autocomplete({
  serviceUrl: '/suggestions/audio-bases',
  deferRequestBy: 100
});

