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

    doSearch();
  });

  // Handle "enter" keypress on search input
  $('#search').keypress(function(event) {
    if(event.which == 13) {
      event.preventDefault();
      doSearch();
    }
  });
  
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
    doSearch();
  }

});

function initialize() {
  // Reset checkboxes on page load
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
  $.get('/items', query, function(data) {
    $('#data-container').replaceWith(data);
    $('#data tr').click(function(event) {
        window.location.href="/items/" + $(this).data('id');
    });

    // Bind click handlers to all data pagination links
    var currentPage = parseInt($('.page-item.active').text().trim());
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
  });
}

