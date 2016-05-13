$(function() {
  
  var search = new Search();
  var filterPanel = new FilterPanel(search);
  filterPanel.initialize();

});

function FilterPanel(filterChangeListener) {
  var panel = $("#filter-panel");
  var lists = [];
  var listener = filterChangeListener;

  var initialize = function() {
    $.each(lists, function(i, list) {
      list.initialize();
    });
  };

  var filterLists = function() {
    return lists;
  };

  panel.find('.filter-list').each(function() {
    var list = new FilterList(this,listener);
    lists.push(list);
  });

  return {
    initialize: initialize,
    filterLists: filterLists
  };

};

function FilterList(element, filterChangeListener) {
  var list = element;
  var checkboxes = $(list).find(':checkbox');
  var listener = filterChangeListener;
  
  var initialize = function() {
    $.each(checkboxes, function(i, value) {
      if(i == 0) {
        checkboxes[i].checked = true;
      } else {
        checkboxes[i].checked = false;
      }
    });
  };

  var listType = function() {
    var id = $(list).attr('id');
    return id.slice(0,id.indexOf('-filters'));
  };

  var selectedFilters = function() {
    var selectedFilters = $(list).find('input:checked');
    var values = [];
    for(var i=0; i < selectedFilters.length; i++) {
      values.push(selectedFilters[i].value);
    }
    return values;
  };

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

      listener.filterChanged(that);
    });
  });

  var that = {
    initialize: initialize,
    listType: listType,
    selectedFilters: selectedFilters
  };

  return that;
};


function Search() {


  var filterChanged = function(filterList) {
    console.log(filterList.selectedFilters());
    doSearch();
  }

  return {
    filterChanged: filterChanged
  }
}

function SearchResultHandler() {

}



