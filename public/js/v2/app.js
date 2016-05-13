$(function() {

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

  doSearch();

});

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
    $("#data-container").replaceWith(data);

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

