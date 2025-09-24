import { $ as $$1, j as jitterbug } from "./jitterbug-C7z39nYE.js";
/*! DataTables 2.3.4
 * © SpryMedia Ltd - datatables.net/license
 */
var $ = $$1;
var DataTable = function(selector, options) {
  if (DataTable.factory(selector, options)) {
    return DataTable;
  }
  if (this instanceof DataTable) {
    return $(selector).DataTable(options);
  } else {
    options = selector;
  }
  var _that = this;
  var emptyInit = options === void 0;
  var len = this.length;
  if (emptyInit) {
    options = {};
  }
  this.api = function() {
    return new _Api(this);
  };
  this.each(function() {
    var o = {};
    var oInit = len > 1 ? (
      // optimisation for single table case
      _fnExtend(o, options, true)
    ) : options;
    var i = 0, iLen;
    var sId = this.getAttribute("id");
    var defaults = DataTable.defaults;
    var $this = $(this);
    if (this.nodeName.toLowerCase() != "table") {
      _fnLog(null, 0, "Non-table node initialisation (" + this.nodeName + ")", 2);
      return;
    }
    if (oInit.on && oInit.on.options) {
      _fnListener($this, "options", oInit.on.options);
    }
    $this.trigger("options.dt", oInit);
    _fnCompatOpts(defaults);
    _fnCompatCols(defaults.column);
    _fnCamelToHungarian(defaults, defaults, true);
    _fnCamelToHungarian(defaults.column, defaults.column, true);
    _fnCamelToHungarian(defaults, $.extend(oInit, _fnEscapeObject($this.data())), true);
    var allSettings = DataTable.settings;
    for (i = 0, iLen = allSettings.length; i < iLen; i++) {
      var s = allSettings[i];
      if (s.nTable == this || s.nTHead && s.nTHead.parentNode == this || s.nTFoot && s.nTFoot.parentNode == this) {
        var bRetrieve = oInit.bRetrieve !== void 0 ? oInit.bRetrieve : defaults.bRetrieve;
        var bDestroy = oInit.bDestroy !== void 0 ? oInit.bDestroy : defaults.bDestroy;
        if (emptyInit || bRetrieve) {
          return s.oInstance;
        } else if (bDestroy) {
          new DataTable.Api(s).destroy();
          break;
        } else {
          _fnLog(s, 0, "Cannot reinitialise DataTable", 3);
          return;
        }
      }
      if (s.sTableId == this.id) {
        allSettings.splice(i, 1);
        break;
      }
    }
    if (sId === null || sId === "") {
      sId = "DataTables_Table_" + DataTable.ext._unique++;
      this.id = sId;
    }
    $this.children("colgroup").remove();
    var oSettings = $.extend(true, {}, DataTable.models.oSettings, {
      "sDestroyWidth": $this[0].style.width,
      "sInstance": sId,
      "sTableId": sId,
      colgroup: $("<colgroup>").prependTo(this),
      fastData: function(row, column, type) {
        return _fnGetCellData(oSettings, row, column, type);
      }
    });
    oSettings.nTable = this;
    oSettings.oInit = oInit;
    allSettings.push(oSettings);
    oSettings.api = new _Api(oSettings);
    oSettings.oInstance = _that.length === 1 ? _that : $this.dataTable();
    _fnCompatOpts(oInit);
    if (oInit.aLengthMenu && !oInit.iDisplayLength) {
      oInit.iDisplayLength = Array.isArray(oInit.aLengthMenu[0]) ? oInit.aLengthMenu[0][0] : $.isPlainObject(oInit.aLengthMenu[0]) ? oInit.aLengthMenu[0].value : oInit.aLengthMenu[0];
    }
    oInit = _fnExtend($.extend(true, {}, defaults), oInit);
    _fnMap(oSettings.oFeatures, oInit, [
      "bPaginate",
      "bLengthChange",
      "bFilter",
      "bSort",
      "bSortMulti",
      "bInfo",
      "bProcessing",
      "bAutoWidth",
      "bSortClasses",
      "bServerSide",
      "bDeferRender"
    ]);
    _fnMap(oSettings, oInit, [
      "ajax",
      "fnFormatNumber",
      "sServerMethod",
      "aaSorting",
      "aaSortingFixed",
      "aLengthMenu",
      "sPaginationType",
      "iStateDuration",
      "bSortCellsTop",
      "iTabIndex",
      "sDom",
      "fnStateLoadCallback",
      "fnStateSaveCallback",
      "renderer",
      "searchDelay",
      "rowId",
      "caption",
      "layout",
      "orderDescReverse",
      "orderIndicators",
      "orderHandler",
      "titleRow",
      "typeDetect",
      ["iCookieDuration", "iStateDuration"],
      // backwards compat
      ["oSearch", "oPreviousSearch"],
      ["aoSearchCols", "aoPreSearchCols"],
      ["iDisplayLength", "_iDisplayLength"]
    ]);
    _fnMap(oSettings.oScroll, oInit, [
      ["sScrollX", "sX"],
      ["sScrollXInner", "sXInner"],
      ["sScrollY", "sY"],
      ["bScrollCollapse", "bCollapse"]
    ]);
    _fnMap(oSettings.oLanguage, oInit, "fnInfoCallback");
    _fnCallbackReg(oSettings, "aoDrawCallback", oInit.fnDrawCallback);
    _fnCallbackReg(oSettings, "aoStateSaveParams", oInit.fnStateSaveParams);
    _fnCallbackReg(oSettings, "aoStateLoadParams", oInit.fnStateLoadParams);
    _fnCallbackReg(oSettings, "aoStateLoaded", oInit.fnStateLoaded);
    _fnCallbackReg(oSettings, "aoRowCallback", oInit.fnRowCallback);
    _fnCallbackReg(oSettings, "aoRowCreatedCallback", oInit.fnCreatedRow);
    _fnCallbackReg(oSettings, "aoHeaderCallback", oInit.fnHeaderCallback);
    _fnCallbackReg(oSettings, "aoFooterCallback", oInit.fnFooterCallback);
    _fnCallbackReg(oSettings, "aoInitComplete", oInit.fnInitComplete);
    _fnCallbackReg(oSettings, "aoPreDrawCallback", oInit.fnPreDrawCallback);
    oSettings.rowIdFn = _fnGetObjectDataFn(oInit.rowId);
    if (oInit.on) {
      Object.keys(oInit.on).forEach(function(key) {
        _fnListener($this, key, oInit.on[key]);
      });
    }
    _fnBrowserDetect(oSettings);
    var oClasses = oSettings.oClasses;
    $.extend(oClasses, DataTable.ext.classes, oInit.oClasses);
    $this.addClass(oClasses.table);
    if (!oSettings.oFeatures.bPaginate) {
      oInit.iDisplayStart = 0;
    }
    if (oSettings.iInitDisplayStart === void 0) {
      oSettings.iInitDisplayStart = oInit.iDisplayStart;
      oSettings._iDisplayStart = oInit.iDisplayStart;
    }
    var defer = oInit.iDeferLoading;
    if (defer !== null) {
      oSettings.deferLoading = true;
      var tmp = Array.isArray(defer);
      oSettings._iRecordsDisplay = tmp ? defer[0] : defer;
      oSettings._iRecordsTotal = tmp ? defer[1] : defer;
    }
    var columnsInit = [];
    var thead = this.getElementsByTagName("thead");
    var initHeaderLayout = _fnDetectHeader(oSettings, thead[0]);
    if (oInit.aoColumns) {
      columnsInit = oInit.aoColumns;
    } else if (initHeaderLayout.length) {
      for (i = 0, iLen = initHeaderLayout[0].length; i < iLen; i++) {
        columnsInit.push(null);
      }
    }
    for (i = 0, iLen = columnsInit.length; i < iLen; i++) {
      _fnAddColumn(oSettings);
    }
    _fnApplyColumnDefs(oSettings, oInit.aoColumnDefs, columnsInit, initHeaderLayout, function(iCol, oDef) {
      _fnColumnOptions(oSettings, iCol, oDef);
    });
    var rowOne = $this.children("tbody").find("tr:first-child").eq(0);
    if (rowOne.length) {
      var a = function(cell, name) {
        return cell.getAttribute("data-" + name) !== null ? name : null;
      };
      $(rowOne[0]).children("th, td").each(function(i2, cell) {
        var col = oSettings.aoColumns[i2];
        if (!col) {
          _fnLog(oSettings, 0, "Incorrect column count", 18);
        }
        if (col.mData === i2) {
          var sort = a(cell, "sort") || a(cell, "order");
          var filter = a(cell, "filter") || a(cell, "search");
          if (sort !== null || filter !== null) {
            col.mData = {
              _: i2 + ".display",
              sort: sort !== null ? i2 + ".@data-" + sort : void 0,
              type: sort !== null ? i2 + ".@data-" + sort : void 0,
              filter: filter !== null ? i2 + ".@data-" + filter : void 0
            };
            col._isArrayHost = true;
            _fnColumnOptions(oSettings, i2);
          }
        }
      });
    }
    _fnCallbackReg(oSettings, "aoDrawCallback", _fnSaveState);
    var features = oSettings.oFeatures;
    if (oInit.bStateSave) {
      features.bStateSave = true;
    }
    if (oInit.aaSorting === void 0) {
      var sorting = oSettings.aaSorting;
      for (i = 0, iLen = sorting.length; i < iLen; i++) {
        sorting[i][1] = oSettings.aoColumns[i].asSorting[0];
      }
    }
    _fnSortingClasses(oSettings);
    _fnCallbackReg(oSettings, "aoDrawCallback", function() {
      if (oSettings.bSorted || _fnDataSource(oSettings) === "ssp" || features.bDeferRender) {
        _fnSortingClasses(oSettings);
      }
    });
    var caption = $this.children("caption");
    if (oSettings.caption) {
      if (caption.length === 0) {
        caption = $("<caption/>").appendTo($this);
      }
      caption.html(oSettings.caption);
    }
    if (caption.length) {
      caption[0]._captionSide = caption.css("caption-side");
      oSettings.captionNode = caption[0];
    }
    if (thead.length === 0) {
      thead = $("<thead/>").appendTo($this);
    }
    oSettings.nTHead = thead[0];
    var tbody = $this.children("tbody");
    if (tbody.length === 0) {
      tbody = $("<tbody/>").insertAfter(thead);
    }
    oSettings.nTBody = tbody[0];
    var tfoot = $this.children("tfoot");
    if (tfoot.length === 0) {
      tfoot = $("<tfoot/>").appendTo($this);
    }
    oSettings.nTFoot = tfoot[0];
    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
    oSettings.bInitialised = true;
    var oLanguage = oSettings.oLanguage;
    $.extend(true, oLanguage, oInit.oLanguage);
    if (oLanguage.sUrl) {
      $.ajax({
        dataType: "json",
        url: oLanguage.sUrl,
        success: function(json) {
          _fnCamelToHungarian(defaults.oLanguage, json);
          $.extend(true, oLanguage, json, oSettings.oInit.oLanguage);
          _fnCallbackFire(oSettings, null, "i18n", [oSettings], true);
          _fnInitialise(oSettings);
        },
        error: function() {
          _fnLog(oSettings, 0, "i18n file loading error", 21);
          _fnInitialise(oSettings);
        }
      });
    } else {
      _fnCallbackFire(oSettings, null, "i18n", [oSettings], true);
      _fnInitialise(oSettings);
    }
  });
  _that = null;
  return this;
};
DataTable.ext = _ext = {
  /**
   * DataTables build type (expanded by the download builder)
   *
   *  @type string
   */
  builder: "-source-",
  /**
   * Buttons. For use with the Buttons extension for DataTables. This is
   * defined here so other extensions can define buttons regardless of load
   * order. It is _not_ used by DataTables core.
   *
   *  @type object
   *  @default {}
   */
  buttons: {},
  /**
   * ColumnControl buttons and content
   *
   *  @type object
   */
  ccContent: {},
  /**
   * Element class names
   *
   *  @type object
   *  @default {}
   */
  classes: {},
  /**
   * Error reporting.
   * 
   * How should DataTables report an error. Can take the value 'alert',
   * 'throw', 'none' or a function.
   *
   *  @type string|function
   *  @default alert
   */
  errMode: "alert",
  /** HTML entity escaping */
  escape: {
    /** When reading data-* attributes for initialisation options */
    attributes: false
  },
  /**
   * Legacy so v1 plug-ins don't throw js errors on load
   */
  feature: [],
  /**
   * Feature plug-ins.
   * 
   * This is an object of callbacks which provide the features for DataTables
   * to be initialised via the `layout` option.
   */
  features: {},
  /**
   * Row searching.
   * 
   * This method of searching is complimentary to the default type based
   * searching, and a lot more comprehensive as it allows you complete control
   * over the searching logic. Each element in this array is a function
   * (parameters described below) that is called for every row in the table,
   * and your logic decides if it should be included in the searching data set
   * or not.
   *
   * Searching functions have the following input parameters:
   *
   * 1. `{object}` DataTables settings object: see
   *    {@link DataTable.models.oSettings}
   * 2. `{array|object}` Data for the row to be processed (same as the
   *    original format that was passed in as the data source, or an array
   *    from a DOM data source
   * 3. `{int}` Row index ({@link DataTable.models.oSettings.aoData}), which
   *    can be useful to retrieve the `TR` element if you need DOM interaction.
   *
   * And the following return is expected:
   *
   * * {boolean} Include the row in the searched result set (true) or not
   *   (false)
   *
   * Note that as with the main search ability in DataTables, technically this
   * is "filtering", since it is subtractive. However, for consistency in
   * naming we call it searching here.
   *
   *  @type array
   *  @default []
   *
   *  @example
   *    // The following example shows custom search being applied to the
   *    // fourth column (i.e. the data[3] index) based on two input values
   *    // from the end-user, matching the data in a certain range.
   *    $.fn.dataTable.ext.search.push(
   *      function( settings, data, dataIndex ) {
   *        var min = document.getElementById('min').value * 1;
   *        var max = document.getElementById('max').value * 1;
   *        var version = data[3] == "-" ? 0 : data[3]*1;
   *
   *        if ( min == "" && max == "" ) {
   *          return true;
   *        }
   *        else if ( min == "" && version < max ) {
   *          return true;
   *        }
   *        else if ( min < version && "" == max ) {
   *          return true;
   *        }
   *        else if ( min < version && version < max ) {
   *          return true;
   *        }
   *        return false;
   *      }
   *    );
   */
  search: [],
  /**
   * Selector extensions
   *
   * The `selector` option can be used to extend the options available for the
   * selector modifier options (`selector-modifier` object data type) that
   * each of the three built in selector types offer (row, column and cell +
   * their plural counterparts). For example the Select extension uses this
   * mechanism to provide an option to select only rows, columns and cells
   * that have been marked as selected by the end user (`{selected: true}`),
   * which can be used in conjunction with the existing built in selector
   * options.
   *
   * Each property is an array to which functions can be pushed. The functions
   * take three attributes:
   *
   * * Settings object for the host table
   * * Options object (`selector-modifier` object type)
   * * Array of selected item indexes
   *
   * The return is an array of the resulting item indexes after the custom
   * selector has been applied.
   *
   *  @type object
   */
  selector: {
    cell: [],
    column: [],
    row: []
  },
  /**
   * Legacy configuration options. Enable and disable legacy options that
   * are available in DataTables.
   *
   *  @type object
   */
  legacy: {
    /**
     * Enable / disable DataTables 1.9 compatible server-side processing
     * requests
     *
     *  @type boolean
     *  @default null
     */
    ajax: null
  },
  /**
   * Pagination plug-in methods.
   * 
   * Each entry in this object is a function and defines which buttons should
   * be shown by the pagination rendering method that is used for the table:
   * {@link DataTable.ext.renderer.pageButton}. The renderer addresses how the
   * buttons are displayed in the document, while the functions here tell it
   * what buttons to display. This is done by returning an array of button
   * descriptions (what each button will do).
   *
   * Pagination types (the four built in options and any additional plug-in
   * options defined here) can be used through the `paginationType`
   * initialisation parameter.
   *
   * The functions defined take two parameters:
   *
   * 1. `{int} page` The current page index
   * 2. `{int} pages` The number of pages in the table
   *
   * Each function is expected to return an array where each element of the
   * array can be one of:
   *
   * * `first` - Jump to first page when activated
   * * `last` - Jump to last page when activated
   * * `previous` - Show previous page when activated
   * * `next` - Show next page when activated
   * * `{int}` - Show page of the index given
   * * `{array}` - A nested array containing the above elements to add a
   *   containing 'DIV' element (might be useful for styling).
   *
   * Note that DataTables v1.9- used this object slightly differently whereby
   * an object with two functions would be defined for each plug-in. That
   * ability is still supported by DataTables 1.10+ to provide backwards
   * compatibility, but this option of use is now decremented and no longer
   * documented in DataTables 1.10+.
   *
   *  @type object
   *  @default {}
   *
   *  @example
   *    // Show previous, next and current page buttons only
   *    $.fn.dataTableExt.oPagination.current = function ( page, pages ) {
   *      return [ 'previous', page, 'next' ];
   *    };
   */
  pager: {},
  renderer: {
    pageButton: {},
    header: {}
  },
  /**
   * Ordering plug-ins - custom data source
   * 
   * The extension options for ordering of data available here is complimentary
   * to the default type based ordering that DataTables typically uses. It
   * allows much greater control over the data that is being used to
   * order a column, but is necessarily therefore more complex.
   * 
   * This type of ordering is useful if you want to do ordering based on data
   * live from the DOM (for example the contents of an 'input' element) rather
   * than just the static string that DataTables knows of.
   * 
   * The way these plug-ins work is that you create an array of the values you
   * wish to be ordering for the column in question and then return that
   * array. The data in the array much be in the index order of the rows in
   * the table (not the currently ordering order!). Which order data gathering
   * function is run here depends on the `dt-init columns.orderDataType`
   * parameter that is used for the column (if any).
   *
   * The functions defined take two parameters:
   *
   * 1. `{object}` DataTables settings object: see
   *    {@link DataTable.models.oSettings}
   * 2. `{int}` Target column index
   *
   * Each function is expected to return an array:
   *
   * * `{array}` Data for the column to be ordering upon
   *
   *  @type array
   *
   *  @example
   *    // Ordering using `input` node values
   *    $.fn.dataTable.ext.order['dom-text'] = function  ( settings, col )
   *    {
   *      return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
   *        return $('input', td).val();
   *      } );
   *    }
   */
  order: {},
  /**
   * Type based plug-ins.
   *
   * Each column in DataTables has a type assigned to it, either by automatic
   * detection or by direct assignment using the `type` option for the column.
   * The type of a column will effect how it is ordering and search (plug-ins
   * can also make use of the column type if required).
   *
   * @namespace
   */
  type: {
    /**
     * Automatic column class assignment
     */
    className: {},
    /**
     * Type detection functions.
     *
     * The functions defined in this object are used to automatically detect
     * a column's type, making initialisation of DataTables super easy, even
     * when complex data is in the table.
     *
     * The functions defined take two parameters:
     *
        *  1. `{*}` Data from the column cell to be analysed
        *  2. `{settings}` DataTables settings object. This can be used to
        *     perform context specific type detection - for example detection
        *     based on language settings such as using a comma for a decimal
        *     place. Generally speaking the options from the settings will not
        *     be required
     *
     * Each function is expected to return:
     *
     * * `{string|null}` Data type detected, or null if unknown (and thus
     *   pass it on to the other type detection functions.
     *
     *  @type array
     *
     *  @example
     *    // Currency type detection plug-in:
     *    $.fn.dataTable.ext.type.detect.push(
     *      function ( data, settings ) {
     *        // Check the numeric part
     *        if ( ! data.substring(1).match(/[0-9]/) ) {
     *          return null;
     *        }
     *
     *        // Check prefixed by currency
     *        if ( data.charAt(0) == '$' || data.charAt(0) == '&pound;' ) {
     *          return 'currency';
     *        }
     *        return null;
     *      }
     *    );
     */
    detect: [],
    /**
     * Automatic renderer assignment
     */
    render: {},
    /**
     * Type based search formatting.
     *
     * The type based searching functions can be used to pre-format the
     * data to be search on. For example, it can be used to strip HTML
     * tags or to de-format telephone numbers for numeric only searching.
     *
     * Note that is a search is not defined for a column of a given type,
     * no search formatting will be performed.
     * 
     * Pre-processing of searching data plug-ins - When you assign the sType
     * for a column (or have it automatically detected for you by DataTables
     * or a type detection plug-in), you will typically be using this for
     * custom sorting, but it can also be used to provide custom searching
     * by allowing you to pre-processing the data and returning the data in
     * the format that should be searched upon. This is done by adding
     * functions this object with a parameter name which matches the sType
     * for that target column. This is the corollary of <i>afnSortData</i>
     * for searching data.
     *
     * The functions defined take a single parameter:
     *
        *  1. `{*}` Data from the column cell to be prepared for searching
     *
     * Each function is expected to return:
     *
     * * `{string|null}` Formatted string that will be used for the searching.
     *
     *  @type object
     *  @default {}
     *
     *  @example
     *    $.fn.dataTable.ext.type.search['title-numeric'] = function ( d ) {
     *      return d.replace(/\n/g," ").replace( /<.*?>/g, "" );
     *    }
     */
    search: {},
    /**
     * Type based ordering.
     *
     * The column type tells DataTables what ordering to apply to the table
     * when a column is sorted upon. The order for each type that is defined,
     * is defined by the functions available in this object.
     *
     * Each ordering option can be described by three properties added to
     * this object:
     *
     * * `{type}-pre` - Pre-formatting function
     * * `{type}-asc` - Ascending order function
     * * `{type}-desc` - Descending order function
     *
     * All three can be used together, only `{type}-pre` or only
     * `{type}-asc` and `{type}-desc` together. It is generally recommended
     * that only `{type}-pre` is used, as this provides the optimal
     * implementation in terms of speed, although the others are provided
     * for compatibility with existing JavaScript sort functions.
     *
     * `{type}-pre`: Functions defined take a single parameter:
     *
        *  1. `{*}` Data from the column cell to be prepared for ordering
     *
     * And return:
     *
     * * `{*}` Data to be sorted upon
     *
     * `{type}-asc` and `{type}-desc`: Functions are typical JavaScript sort
     * functions, taking two parameters:
     *
        *  1. `{*}` Data to compare to the second parameter
        *  2. `{*}` Data to compare to the first parameter
     *
     * And returning:
     *
     * * `{*}` Ordering match: <0 if first parameter should be sorted lower
     *   than the second parameter, ===0 if the two parameters are equal and
     *   >0 if the first parameter should be sorted height than the second
     *   parameter.
     * 
     *  @type object
     *  @default {}
     *
     *  @example
     *    // Numeric ordering of formatted numbers with a pre-formatter
     *    $.extend( $.fn.dataTable.ext.type.order, {
     *      "string-pre": function(x) {
     *        a = (a === "-" || a === "") ? 0 : a.replace( /[^\d\-\.]/g, "" );
     *        return parseFloat( a );
     *      }
     *    } );
     *
     *  @example
     *    // Case-sensitive string ordering, with no pre-formatting method
     *    $.extend( $.fn.dataTable.ext.order, {
     *      "string-case-asc": function(x,y) {
     *        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
     *      },
     *      "string-case-desc": function(x,y) {
     *        return ((x < y) ? 1 : ((x > y) ? -1 : 0));
     *      }
     *    } );
     */
    order: {}
  },
  /**
   * Unique DataTables instance counter
   *
   * @type int
   * @private
   */
  _unique: 0,
  //
  // Depreciated
  // The following properties are retained for backwards compatibility only.
  // The should not be used in new projects and will be removed in a future
  // version
  //
  /**
   * Version check function.
   *  @type function
   *  @depreciated Since 1.10
   */
  fnVersionCheck: DataTable.fnVersionCheck,
  /**
   * Index for what 'this' index API functions should use
   *  @type int
   *  @deprecated Since v1.10
   */
  iApiIndex: 0,
  /**
   * Software version
   *  @type string
   *  @deprecated Since v1.10
   */
  sVersion: DataTable.version
};
$.extend(_ext, {
  afnFiltering: _ext.search,
  aTypes: _ext.type.detect,
  ofnSearch: _ext.type.search,
  oSort: _ext.type.order,
  afnSortData: _ext.order,
  aoFeatures: _ext.feature,
  oStdClasses: _ext.classes,
  oPagination: _ext.pager
});
$.extend(DataTable.ext.classes, {
  container: "dt-container",
  empty: {
    row: "dt-empty"
  },
  info: {
    container: "dt-info"
  },
  layout: {
    row: "dt-layout-row",
    cell: "dt-layout-cell",
    tableRow: "dt-layout-table",
    tableCell: "",
    start: "dt-layout-start",
    end: "dt-layout-end",
    full: "dt-layout-full"
  },
  length: {
    container: "dt-length",
    select: "dt-input"
  },
  order: {
    canAsc: "dt-orderable-asc",
    canDesc: "dt-orderable-desc",
    isAsc: "dt-ordering-asc",
    isDesc: "dt-ordering-desc",
    none: "dt-orderable-none",
    position: "sorting_"
  },
  processing: {
    container: "dt-processing"
  },
  scrolling: {
    body: "dt-scroll-body",
    container: "dt-scroll",
    footer: {
      self: "dt-scroll-foot",
      inner: "dt-scroll-footInner"
    },
    header: {
      self: "dt-scroll-head",
      inner: "dt-scroll-headInner"
    }
  },
  search: {
    container: "dt-search",
    input: "dt-input"
  },
  table: "dataTable",
  tbody: {
    cell: "",
    row: ""
  },
  thead: {
    cell: "",
    row: ""
  },
  tfoot: {
    cell: "",
    row: ""
  },
  paging: {
    active: "current",
    button: "dt-paging-button",
    container: "dt-paging",
    disabled: "disabled",
    nav: ""
  }
});
var _ext;
var _Api;
var _api_register;
var _api_registerPlural;
var _re_dic = {};
var _re_new_lines = /[\r\n\u2028]/g;
var _re_html = /<([^>]*>)/g;
var _max_str_len = Math.pow(2, 28);
var _re_date = /^\d{2,4}[./-]\d{1,2}[./-]\d{1,2}([T ]{1}\d{1,2}[:.]\d{2}([.:]\d{2})?)?$/;
var _re_escape_regex = new RegExp("(\\" + ["/", ".", "*", "+", "?", "|", "(", ")", "[", "]", "{", "}", "\\", "$", "^", "-"].join("|\\") + ")", "g");
var _re_formatted_numeric = /['\u00A0,$£€¥%\u2009\u202F\u20BD\u20a9\u20BArfkɃΞ]/gi;
var _empty = function(d) {
  return !d || d === true || d === "-" ? true : false;
};
var _intVal = function(s) {
  var integer = parseInt(s, 10);
  return !isNaN(integer) && isFinite(s) ? integer : null;
};
var _numToDecimal = function(num, decimalPoint) {
  if (!_re_dic[decimalPoint]) {
    _re_dic[decimalPoint] = new RegExp(_fnEscapeRegex(decimalPoint), "g");
  }
  return typeof num === "string" && decimalPoint !== "." ? num.replace(/\./g, "").replace(_re_dic[decimalPoint], ".") : num;
};
var _isNumber = function(d, decimalPoint, formatted, allowEmpty) {
  var type = typeof d;
  var strType = type === "string";
  if (type === "number" || type === "bigint") {
    return true;
  }
  if (allowEmpty && _empty(d)) {
    return true;
  }
  if (decimalPoint && strType) {
    d = _numToDecimal(d, decimalPoint);
  }
  if (formatted && strType) {
    d = d.replace(_re_formatted_numeric, "");
  }
  return !isNaN(parseFloat(d)) && isFinite(d);
};
var _isHtml = function(d) {
  return _empty(d) || typeof d === "string";
};
var _htmlNumeric = function(d, decimalPoint, formatted, allowEmpty) {
  if (allowEmpty && _empty(d)) {
    return true;
  }
  if (typeof d === "string" && d.match(/<(input|select)/i)) {
    return null;
  }
  var html = _isHtml(d);
  return !html ? null : _isNumber(_stripHtml(d), decimalPoint, formatted, allowEmpty) ? true : null;
};
var _pluck = function(a, prop, prop2) {
  var out = [];
  var i = 0, iLen = a.length;
  if (prop2 !== void 0) {
    for (; i < iLen; i++) {
      if (a[i] && a[i][prop]) {
        out.push(a[i][prop][prop2]);
      }
    }
  } else {
    for (; i < iLen; i++) {
      if (a[i]) {
        out.push(a[i][prop]);
      }
    }
  }
  return out;
};
var _pluck_order = function(a, order, prop, prop2) {
  var out = [];
  var i = 0, iLen = order.length;
  if (prop2 !== void 0) {
    for (; i < iLen; i++) {
      if (a[order[i]] && a[order[i]][prop]) {
        out.push(a[order[i]][prop][prop2]);
      }
    }
  } else {
    for (; i < iLen; i++) {
      if (a[order[i]]) {
        out.push(a[order[i]][prop]);
      }
    }
  }
  return out;
};
var _range = function(len, start) {
  var out = [];
  var end;
  if (start === void 0) {
    start = 0;
    end = len;
  } else {
    end = start;
    start = len;
  }
  for (var i = start; i < end; i++) {
    out.push(i);
  }
  return out;
};
var _removeEmpty = function(a) {
  var out = [];
  for (var i = 0, iLen = a.length; i < iLen; i++) {
    if (a[i]) {
      out.push(a[i]);
    }
  }
  return out;
};
var _stripHtml = function(input) {
  if (!input || typeof input !== "string") {
    return input;
  }
  if (input.length > _max_str_len) {
    throw new Error("Exceeded max str len");
  }
  var previous;
  input = input.replace(_re_html, "");
  do {
    previous = input;
    input = input.replace(/<script/i, "");
  } while (input !== previous);
  return previous;
};
var _escapeHtml = function(d) {
  if (Array.isArray(d)) {
    d = d.join(",");
  }
  return typeof d === "string" ? d.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;") : d;
};
var _normalize = function(str, both) {
  if (typeof str !== "string") {
    return str;
  }
  var res = str.normalize ? str.normalize("NFD") : str;
  return res.length !== str.length ? (both === true ? str + " " : "") + res.replace(/[\u0300-\u036f]/g, "") : res;
};
var _areAllUnique = function(src) {
  if (src.length < 2) {
    return true;
  }
  var sorted = src.slice().sort();
  var last = sorted[0];
  for (var i = 1, iLen = sorted.length; i < iLen; i++) {
    if (sorted[i] === last) {
      return false;
    }
    last = sorted[i];
  }
  return true;
};
var _unique = function(src) {
  if (Array.from && Set) {
    return Array.from(new Set(src));
  }
  if (_areAllUnique(src)) {
    return src.slice();
  }
  var out = [], val, i, iLen = src.length, j, k = 0;
  again: for (i = 0; i < iLen; i++) {
    val = src[i];
    for (j = 0; j < k; j++) {
      if (out[j] === val) {
        continue again;
      }
    }
    out.push(val);
    k++;
  }
  return out;
};
var _flatten = function(out, val) {
  if (Array.isArray(val)) {
    for (var i = 0; i < val.length; i++) {
      _flatten(out, val[i]);
    }
  } else {
    out.push(val);
  }
  return out;
};
function _addClass(el, name) {
  if (name) {
    name.split(" ").forEach(function(n) {
      if (n) {
        el.classList.add(n);
      }
    });
  }
}
DataTable.util = {
  /**
   * Return a string with diacritic characters decomposed
   * @param {*} mixed Function or string to normalize
   * @param {*} both Return original string and the normalized string
   * @returns String or undefined
   */
  diacritics: function(mixed, both) {
    var type = typeof mixed;
    if (type !== "function") {
      return _normalize(mixed, both);
    }
    _normalize = mixed;
  },
  /**
   * Debounce a function
   *
   * @param {function} fn Function to be called
   * @param {integer} freq Call frequency in mS
   * @return {function} Wrapped function
   */
  debounce: function(fn, timeout) {
    var timer;
    return function() {
      var that = this;
      var args = arguments;
      clearTimeout(timer);
      timer = setTimeout(function() {
        fn.apply(that, args);
      }, timeout || 250);
    };
  },
  /**
   * Throttle the calls to a function. Arguments and context are maintained
   * for the throttled function.
   *
   * @param {function} fn Function to be called
   * @param {integer} freq Call frequency in mS
   * @return {function} Wrapped function
   */
  throttle: function(fn, freq) {
    var frequency = freq !== void 0 ? freq : 200, last, timer;
    return function() {
      var that = this, now = +/* @__PURE__ */ new Date(), args = arguments;
      if (last && now < last + frequency) {
        clearTimeout(timer);
        timer = setTimeout(function() {
          last = void 0;
          fn.apply(that, args);
        }, frequency);
      } else {
        last = now;
        fn.apply(that, args);
      }
    };
  },
  /**
   * Escape a string such that it can be used in a regular expression
   *
   *  @param {string} val string to escape
   *  @returns {string} escaped string
   */
  escapeRegex: function(val) {
    return val.replace(_re_escape_regex, "\\$1");
  },
  /**
   * Create a function that will write to a nested object or array
   * @param {*} source JSON notation string
   * @returns Write function
   */
  set: function(source) {
    if ($.isPlainObject(source)) {
      return DataTable.util.set(source._);
    } else if (source === null) {
      return function() {
      };
    } else if (typeof source === "function") {
      return function(data, val, meta) {
        source(data, "set", val, meta);
      };
    } else if (typeof source === "string" && (source.indexOf(".") !== -1 || source.indexOf("[") !== -1 || source.indexOf("(") !== -1)) {
      var setData = function(data, val, src) {
        var a = _fnSplitObjNotation(src), b;
        var aLast = a[a.length - 1];
        var arrayNotation, funcNotation, o, innerSrc;
        for (var i = 0, iLen = a.length - 1; i < iLen; i++) {
          if (a[i] === "__proto__" || a[i] === "constructor") {
            throw new Error("Cannot set prototype values");
          }
          arrayNotation = a[i].match(__reArray);
          funcNotation = a[i].match(__reFn);
          if (arrayNotation) {
            a[i] = a[i].replace(__reArray, "");
            data[a[i]] = [];
            b = a.slice();
            b.splice(0, i + 1);
            innerSrc = b.join(".");
            if (Array.isArray(val)) {
              for (var j = 0, jLen = val.length; j < jLen; j++) {
                o = {};
                setData(o, val[j], innerSrc);
                data[a[i]].push(o);
              }
            } else {
              data[a[i]] = val;
            }
            return;
          } else if (funcNotation) {
            a[i] = a[i].replace(__reFn, "");
            data = data[a[i]](val);
          }
          if (data[a[i]] === null || data[a[i]] === void 0) {
            data[a[i]] = {};
          }
          data = data[a[i]];
        }
        if (aLast.match(__reFn)) {
          data = data[aLast.replace(__reFn, "")](val);
        } else {
          data[aLast.replace(__reArray, "")] = val;
        }
      };
      return function(data, val) {
        return setData(data, val, source);
      };
    } else {
      return function(data, val) {
        data[source] = val;
      };
    }
  },
  /**
   * Create a function that will read nested objects from arrays, based on JSON notation
   * @param {*} source JSON notation string
   * @returns Value read
   */
  get: function(source) {
    if ($.isPlainObject(source)) {
      var o = {};
      $.each(source, function(key, val) {
        if (val) {
          o[key] = DataTable.util.get(val);
        }
      });
      return function(data, type, row, meta) {
        var t = o[type] || o._;
        return t !== void 0 ? t(data, type, row, meta) : data;
      };
    } else if (source === null) {
      return function(data) {
        return data;
      };
    } else if (typeof source === "function") {
      return function(data, type, row, meta) {
        return source(data, type, row, meta);
      };
    } else if (typeof source === "string" && (source.indexOf(".") !== -1 || source.indexOf("[") !== -1 || source.indexOf("(") !== -1)) {
      var fetchData = function(data, type, src) {
        var arrayNotation, funcNotation, out, innerSrc;
        if (src !== "") {
          var a = _fnSplitObjNotation(src);
          for (var i = 0, iLen = a.length; i < iLen; i++) {
            arrayNotation = a[i].match(__reArray);
            funcNotation = a[i].match(__reFn);
            if (arrayNotation) {
              a[i] = a[i].replace(__reArray, "");
              if (a[i] !== "") {
                data = data[a[i]];
              }
              out = [];
              a.splice(0, i + 1);
              innerSrc = a.join(".");
              if (Array.isArray(data)) {
                for (var j = 0, jLen = data.length; j < jLen; j++) {
                  out.push(fetchData(data[j], type, innerSrc));
                }
              }
              var join = arrayNotation[0].substring(1, arrayNotation[0].length - 1);
              data = join === "" ? out : out.join(join);
              break;
            } else if (funcNotation) {
              a[i] = a[i].replace(__reFn, "");
              data = data[a[i]]();
              continue;
            }
            if (data === null || data[a[i]] === null) {
              return null;
            } else if (data === void 0 || data[a[i]] === void 0) {
              return void 0;
            }
            data = data[a[i]];
          }
        }
        return data;
      };
      return function(data, type) {
        return fetchData(data, type, source);
      };
    } else {
      return function(data) {
        return data[source];
      };
    }
  },
  stripHtml: function(mixed) {
    var type = typeof mixed;
    if (type === "function") {
      _stripHtml = mixed;
      return;
    } else if (type === "string") {
      return _stripHtml(mixed);
    }
    return mixed;
  },
  escapeHtml: function(mixed) {
    var type = typeof mixed;
    if (type === "function") {
      _escapeHtml = mixed;
      return;
    } else if (type === "string" || Array.isArray(mixed)) {
      return _escapeHtml(mixed);
    }
    return mixed;
  },
  unique: _unique
};
function _fnHungarianMap(o) {
  var hungarian = "a aa ai ao as b fn i m o s ", match, newKey, map = {};
  $.each(o, function(key) {
    match = key.match(/^([^A-Z]+?)([A-Z])/);
    if (match && hungarian.indexOf(match[1] + " ") !== -1) {
      newKey = key.replace(match[0], match[2].toLowerCase());
      map[newKey] = key;
      if (match[1] === "o") {
        _fnHungarianMap(o[key]);
      }
    }
  });
  o._hungarianMap = map;
}
function _fnCamelToHungarian(src, user, force) {
  if (!src._hungarianMap) {
    _fnHungarianMap(src);
  }
  var hungarianKey;
  $.each(user, function(key) {
    hungarianKey = src._hungarianMap[key];
    if (hungarianKey !== void 0 && (force || user[hungarianKey] === void 0)) {
      if (hungarianKey.charAt(0) === "o") {
        if (!user[hungarianKey]) {
          user[hungarianKey] = {};
        }
        $.extend(true, user[hungarianKey], user[key]);
        _fnCamelToHungarian(src[hungarianKey], user[hungarianKey], force);
      } else {
        user[hungarianKey] = user[key];
      }
    }
  });
}
var _fnCompatMap = function(o, knew, old) {
  if (o[knew] !== void 0) {
    o[old] = o[knew];
  }
};
function _fnCompatOpts(init) {
  _fnCompatMap(init, "ordering", "bSort");
  _fnCompatMap(init, "orderMulti", "bSortMulti");
  _fnCompatMap(init, "orderClasses", "bSortClasses");
  _fnCompatMap(init, "orderCellsTop", "bSortCellsTop");
  _fnCompatMap(init, "order", "aaSorting");
  _fnCompatMap(init, "orderFixed", "aaSortingFixed");
  _fnCompatMap(init, "paging", "bPaginate");
  _fnCompatMap(init, "pagingType", "sPaginationType");
  _fnCompatMap(init, "pageLength", "iDisplayLength");
  _fnCompatMap(init, "searching", "bFilter");
  if (typeof init.sScrollX === "boolean") {
    init.sScrollX = init.sScrollX ? "100%" : "";
  }
  if (typeof init.scrollX === "boolean") {
    init.scrollX = init.scrollX ? "100%" : "";
  }
  if (typeof init.bSort === "object") {
    init.orderIndicators = init.bSort.indicators !== void 0 ? init.bSort.indicators : true;
    init.orderHandler = init.bSort.handler !== void 0 ? init.bSort.handler : true;
    init.bSort = true;
  } else if (init.bSort === false) {
    init.orderIndicators = false;
    init.orderHandler = false;
  } else if (init.bSort === true) {
    init.orderIndicators = true;
    init.orderHandler = true;
  }
  if (typeof init.bSortCellsTop === "boolean") {
    init.titleRow = init.bSortCellsTop;
  }
  var searchCols = init.aoSearchCols;
  if (searchCols) {
    for (var i = 0, iLen = searchCols.length; i < iLen; i++) {
      if (searchCols[i]) {
        _fnCamelToHungarian(DataTable.models.oSearch, searchCols[i]);
      }
    }
  }
  if (init.serverSide && !init.searchDelay) {
    init.searchDelay = 400;
  }
}
function _fnCompatCols(init) {
  _fnCompatMap(init, "orderable", "bSortable");
  _fnCompatMap(init, "orderData", "aDataSort");
  _fnCompatMap(init, "orderSequence", "asSorting");
  _fnCompatMap(init, "orderDataType", "sortDataType");
  var dataSort = init.aDataSort;
  if (typeof dataSort === "number" && !Array.isArray(dataSort)) {
    init.aDataSort = [dataSort];
  }
}
function _fnBrowserDetect(settings) {
  if (!DataTable.__browser) {
    var browser = {};
    DataTable.__browser = browser;
    var n = $("<div/>").css({
      position: "fixed",
      top: 0,
      left: -1 * window.pageXOffset,
      // allow for scrolling
      height: 1,
      width: 1,
      overflow: "hidden"
    }).append(
      $("<div/>").css({
        position: "absolute",
        top: 1,
        left: 1,
        width: 100,
        overflow: "scroll"
      }).append(
        $("<div/>").css({
          width: "100%",
          height: 10
        })
      )
    ).appendTo("body");
    var outer = n.children();
    var inner = outer.children();
    browser.barWidth = outer[0].offsetWidth - outer[0].clientWidth;
    browser.bScrollbarLeft = Math.round(inner.offset().left) !== 1;
    n.remove();
  }
  $.extend(settings.oBrowser, DataTable.__browser);
  settings.oScroll.iBarWidth = DataTable.__browser.barWidth;
}
function _fnAddColumn(oSettings) {
  var oDefaults = DataTable.defaults.column;
  var iCol = oSettings.aoColumns.length;
  var oCol = $.extend({}, DataTable.models.oColumn, oDefaults, {
    "aDataSort": oDefaults.aDataSort ? oDefaults.aDataSort : [iCol],
    "mData": oDefaults.mData ? oDefaults.mData : iCol,
    idx: iCol,
    searchFixed: {},
    colEl: $("<col>").attr("data-dt-column", iCol)
  });
  oSettings.aoColumns.push(oCol);
  var searchCols = oSettings.aoPreSearchCols;
  searchCols[iCol] = $.extend({}, DataTable.models.oSearch, searchCols[iCol]);
}
function _fnColumnOptions(oSettings, iCol, oOptions) {
  var oCol = oSettings.aoColumns[iCol];
  if (oOptions !== void 0 && oOptions !== null) {
    _fnCompatCols(oOptions);
    _fnCamelToHungarian(DataTable.defaults.column, oOptions, true);
    if (oOptions.mDataProp !== void 0 && !oOptions.mData) {
      oOptions.mData = oOptions.mDataProp;
    }
    if (oOptions.sType) {
      oCol._sManualType = oOptions.sType;
    }
    if (oOptions.className && !oOptions.sClass) {
      oOptions.sClass = oOptions.className;
    }
    var origClass = oCol.sClass;
    $.extend(oCol, oOptions);
    _fnMap(oCol, oOptions, "sWidth", "sWidthOrig");
    if (origClass !== oCol.sClass) {
      oCol.sClass = origClass + " " + oCol.sClass;
    }
    if (oOptions.iDataSort !== void 0) {
      oCol.aDataSort = [oOptions.iDataSort];
    }
    _fnMap(oCol, oOptions, "aDataSort");
  }
  var mDataSrc = oCol.mData;
  var mData = _fnGetObjectDataFn(mDataSrc);
  if (oCol.mRender && Array.isArray(oCol.mRender)) {
    var copy = oCol.mRender.slice();
    var name = copy.shift();
    oCol.mRender = DataTable.render[name].apply(window, copy);
  }
  oCol._render = oCol.mRender ? _fnGetObjectDataFn(oCol.mRender) : null;
  var attrTest = function(src) {
    return typeof src === "string" && src.indexOf("@") !== -1;
  };
  oCol._bAttrSrc = $.isPlainObject(mDataSrc) && (attrTest(mDataSrc.sort) || attrTest(mDataSrc.type) || attrTest(mDataSrc.filter));
  oCol._setter = null;
  oCol.fnGetData = function(rowData, type, meta) {
    var innerData = mData(rowData, type, void 0, meta);
    return oCol._render && type ? oCol._render(innerData, type, rowData, meta) : innerData;
  };
  oCol.fnSetData = function(rowData, val, meta) {
    return _fnSetObjectDataFn(mDataSrc)(rowData, val, meta);
  };
  if (typeof mDataSrc !== "number" && !oCol._isArrayHost) {
    oSettings._rowReadObject = true;
  }
  if (!oSettings.oFeatures.bSort) {
    oCol.bSortable = false;
  }
}
function _fnAdjustColumnSizing(settings) {
  _fnCalculateColumnWidths(settings);
  _fnColumnSizes(settings);
  var scroll = settings.oScroll;
  if (scroll.sY !== "" || scroll.sX !== "") {
    _fnScrollDraw(settings);
  }
  _fnCallbackFire(settings, null, "column-sizing", [settings]);
}
function _fnColumnSizes(settings) {
  var cols = settings.aoColumns;
  for (var i = 0; i < cols.length; i++) {
    var width = _fnColumnsSumWidth(settings, [i], false);
    cols[i].colEl.css("width", width);
    if (settings.oScroll.sX) {
      cols[i].colEl.css("min-width", width);
    }
  }
}
function _fnVisibleToColumnIndex(oSettings, iMatch) {
  var aiVis = _fnGetColumns(oSettings, "bVisible");
  return typeof aiVis[iMatch] === "number" ? aiVis[iMatch] : null;
}
function _fnColumnIndexToVisible(oSettings, iMatch) {
  var aiVis = _fnGetColumns(oSettings, "bVisible");
  var iPos = aiVis.indexOf(iMatch);
  return iPos !== -1 ? iPos : null;
}
function _fnVisibleColumns(settings) {
  var layout = settings.aoHeader;
  var columns = settings.aoColumns;
  var vis = 0;
  if (layout.length) {
    for (var i = 0, iLen = layout[0].length; i < iLen; i++) {
      if (columns[i].bVisible && $(layout[0][i].cell).css("display") !== "none") {
        vis++;
      }
    }
  }
  return vis;
}
function _fnGetColumns(oSettings, sParam) {
  var a = [];
  oSettings.aoColumns.map(function(val, i) {
    if (val[sParam]) {
      a.push(i);
    }
  });
  return a;
}
function _typeResult(typeDetect, res) {
  return res === true ? typeDetect._name : res;
}
function _fnColumnTypes(settings) {
  var columns = settings.aoColumns;
  var data = settings.aoData;
  var types = DataTable.ext.type.detect;
  var i, iLen, j, jen, k, ken;
  var col, detectedType, cache;
  for (i = 0, iLen = columns.length; i < iLen; i++) {
    col = columns[i];
    cache = [];
    if (!col.sType && col._sManualType) {
      col.sType = col._sManualType;
    } else if (!col.sType) {
      if (!settings.typeDetect) {
        return;
      }
      for (j = 0, jen = types.length; j < jen; j++) {
        var typeDetect = types[j];
        var oneOf = typeDetect.oneOf;
        var allOf = typeDetect.allOf || typeDetect;
        var init = typeDetect.init;
        var one = false;
        detectedType = null;
        if (init) {
          detectedType = _typeResult(typeDetect, init(settings, col, i));
          if (detectedType) {
            col.sType = detectedType;
            break;
          }
        }
        for (k = 0, ken = data.length; k < ken; k++) {
          if (!data[k]) {
            continue;
          }
          if (cache[k] === void 0) {
            cache[k] = _fnGetCellData(settings, k, i, "type");
          }
          if (oneOf && !one) {
            one = _typeResult(typeDetect, oneOf(cache[k], settings));
          }
          detectedType = _typeResult(typeDetect, allOf(cache[k], settings));
          if (!detectedType && j !== types.length - 3) {
            break;
          }
          if (detectedType === "html" && !_empty(cache[k])) {
            break;
          }
        }
        if (oneOf && one && detectedType || !oneOf && detectedType) {
          col.sType = detectedType;
          break;
        }
      }
      if (!col.sType) {
        col.sType = "string";
      }
    }
    var autoClass = _ext.type.className[col.sType];
    if (autoClass) {
      _columnAutoClass(settings.aoHeader, i, autoClass);
      _columnAutoClass(settings.aoFooter, i, autoClass);
    }
    var renderer = _ext.type.render[col.sType];
    if (renderer && !col._render) {
      col._render = DataTable.util.get(renderer);
      _columnAutoRender(settings, i);
    }
  }
}
function _columnAutoRender(settings, colIdx) {
  var data = settings.aoData;
  for (var i = 0; i < data.length; i++) {
    if (data[i].nTr) {
      var display = _fnGetCellData(settings, i, colIdx, "display");
      data[i].displayData[colIdx] = display;
      _fnWriteCell(data[i].anCells[colIdx], display);
    }
  }
}
function _columnAutoClass(container, colIdx, className) {
  container.forEach(function(row) {
    if (row[colIdx] && row[colIdx].unique) {
      _addClass(row[colIdx].cell, className);
    }
  });
}
function _fnApplyColumnDefs(oSettings, aoColDefs, aoCols, headerLayout, fn) {
  var i, iLen, j, jLen, k, kLen, def;
  var columns = oSettings.aoColumns;
  if (aoCols) {
    for (i = 0, iLen = aoCols.length; i < iLen; i++) {
      if (aoCols[i] && aoCols[i].name) {
        columns[i].sName = aoCols[i].name;
      }
    }
  }
  if (aoColDefs) {
    for (i = aoColDefs.length - 1; i >= 0; i--) {
      def = aoColDefs[i];
      var aTargets = def.target !== void 0 ? def.target : def.targets !== void 0 ? def.targets : def.aTargets;
      if (!Array.isArray(aTargets)) {
        aTargets = [aTargets];
      }
      for (j = 0, jLen = aTargets.length; j < jLen; j++) {
        var target = aTargets[j];
        if (typeof target === "number" && target >= 0) {
          while (columns.length <= target) {
            _fnAddColumn(oSettings);
          }
          fn(target, def);
        } else if (typeof target === "number" && target < 0) {
          fn(columns.length + target, def);
        } else if (typeof target === "string") {
          for (k = 0, kLen = columns.length; k < kLen; k++) {
            if (target === "_all") {
              fn(k, def);
            } else if (target.indexOf(":name") !== -1) {
              if (columns[k].sName === target.replace(":name", "")) {
                fn(k, def);
              }
            } else {
              headerLayout.forEach(function(row) {
                if (row[k]) {
                  var cell = $(row[k].cell);
                  if (target.match(/^[a-z][\w-]*$/i)) {
                    target = "." + target;
                  }
                  if (cell.is(target)) {
                    fn(k, def);
                  }
                }
              });
            }
          }
        }
      }
    }
  }
  if (aoCols) {
    for (i = 0, iLen = aoCols.length; i < iLen; i++) {
      fn(i, aoCols[i]);
    }
  }
}
function _fnColumnsSumWidth(settings, targets, original, incVisible) {
  if (!Array.isArray(targets)) {
    targets = _fnColumnsFromHeader(targets);
  }
  var sum = 0;
  var unit;
  var columns = settings.aoColumns;
  for (var i = 0, iLen = targets.length; i < iLen; i++) {
    var column = columns[targets[i]];
    var definedWidth = original ? column.sWidthOrig : column.sWidth;
    if (column.bVisible === false) {
      continue;
    }
    if (definedWidth === null || definedWidth === void 0) {
      return null;
    } else if (typeof definedWidth === "number") {
      unit = "px";
      sum += definedWidth;
    } else {
      var matched = definedWidth.match(/([\d\.]+)([^\d]*)/);
      if (matched) {
        sum += matched[1] * 1;
        unit = matched.length === 3 ? matched[2] : "px";
      }
    }
  }
  return sum + unit;
}
function _fnColumnsFromHeader(cell) {
  var attr = $(cell).closest("[data-dt-column]").attr("data-dt-column");
  if (!attr) {
    return [];
  }
  return attr.split(",").map(function(val) {
    return val * 1;
  });
}
function _fnAddData(settings, dataIn, tr, tds) {
  var rowIdx = settings.aoData.length;
  var rowModel = $.extend(true, {}, DataTable.models.oRow, {
    src: tr ? "dom" : "data",
    idx: rowIdx
  });
  rowModel._aData = dataIn;
  settings.aoData.push(rowModel);
  var columns = settings.aoColumns;
  for (var i = 0, iLen = columns.length; i < iLen; i++) {
    columns[i].sType = null;
  }
  settings.aiDisplayMaster.push(rowIdx);
  var id = settings.rowIdFn(dataIn);
  if (id !== void 0) {
    settings.aIds[id] = rowModel;
  }
  if (tr || !settings.oFeatures.bDeferRender) {
    _fnCreateTr(settings, rowIdx, tr, tds);
  }
  return rowIdx;
}
function _fnAddTr(settings, trs) {
  var row;
  if (!(trs instanceof $)) {
    trs = $(trs);
  }
  return trs.map(function(i, el) {
    row = _fnGetRowElements(settings, el);
    return _fnAddData(settings, row.data, el, row.cells);
  });
}
function _fnGetCellData(settings, rowIdx, colIdx, type) {
  if (type === "search") {
    type = "filter";
  } else if (type === "order") {
    type = "sort";
  }
  var row = settings.aoData[rowIdx];
  if (!row) {
    return void 0;
  }
  var draw = settings.iDraw;
  var col = settings.aoColumns[colIdx];
  var rowData = row._aData;
  var defaultContent = col.sDefaultContent;
  var cellData = col.fnGetData(rowData, type, {
    settings,
    row: rowIdx,
    col: colIdx
  });
  if (type !== "display" && cellData && typeof cellData === "object" && cellData.nodeName) {
    cellData = cellData.innerHTML;
  }
  if (cellData === void 0) {
    if (settings.iDrawError != draw && defaultContent === null) {
      _fnLog(settings, 0, "Requested unknown parameter " + (typeof col.mData == "function" ? "{function}" : "'" + col.mData + "'") + " for row " + rowIdx + ", column " + colIdx, 4);
      settings.iDrawError = draw;
    }
    return defaultContent;
  }
  if ((cellData === rowData || cellData === null) && defaultContent !== null && type !== void 0) {
    cellData = defaultContent;
  } else if (typeof cellData === "function") {
    return cellData.call(rowData);
  }
  if (cellData === null && type === "display") {
    return "";
  }
  if (type === "filter") {
    var formatters = DataTable.ext.type.search;
    if (formatters[col.sType]) {
      cellData = formatters[col.sType](cellData);
    }
  }
  return cellData;
}
function _fnSetCellData(settings, rowIdx, colIdx, val) {
  var col = settings.aoColumns[colIdx];
  var rowData = settings.aoData[rowIdx]._aData;
  col.fnSetData(rowData, val, {
    settings,
    row: rowIdx,
    col: colIdx
  });
}
function _fnWriteCell(td, val) {
  if (val && typeof val === "object" && val.nodeName) {
    $(td).empty().append(val);
  } else {
    td.innerHTML = val;
  }
}
var __reArray = /\[.*?\]$/;
var __reFn = /\(\)$/;
function _fnSplitObjNotation(str) {
  var parts = str.match(/(\\.|[^.])+/g) || [""];
  return parts.map(function(s) {
    return s.replace(/\\\./g, ".");
  });
}
var _fnGetObjectDataFn = DataTable.util.get;
var _fnSetObjectDataFn = DataTable.util.set;
function _fnGetDataMaster(settings) {
  return _pluck(settings.aoData, "_aData");
}
function _fnClearTable(settings) {
  settings.aoData.length = 0;
  settings.aiDisplayMaster.length = 0;
  settings.aiDisplay.length = 0;
  settings.aIds = {};
}
function _fnInvalidate(settings, rowIdx, src, colIdx) {
  var row = settings.aoData[rowIdx];
  var i, iLen;
  row._aSortData = null;
  row._aFilterData = null;
  row.displayData = null;
  if (src === "dom" || (!src || src === "auto") && row.src === "dom") {
    row._aData = _fnGetRowElements(
      settings,
      row,
      colIdx,
      colIdx === void 0 ? void 0 : row._aData
    ).data;
  } else {
    var cells = row.anCells;
    var display = _fnGetRowDisplay(settings, rowIdx);
    if (cells) {
      if (colIdx !== void 0) {
        _fnWriteCell(cells[colIdx], display[colIdx]);
      } else {
        for (i = 0, iLen = cells.length; i < iLen; i++) {
          _fnWriteCell(cells[i], display[i]);
        }
      }
    }
  }
  var cols = settings.aoColumns;
  if (colIdx !== void 0) {
    cols[colIdx].sType = null;
    cols[colIdx].maxLenString = null;
  } else {
    for (i = 0, iLen = cols.length; i < iLen; i++) {
      cols[i].sType = null;
      cols[i].maxLenString = null;
    }
    _fnRowAttributes(settings, row);
  }
}
function _fnGetRowElements(settings, row, colIdx, d) {
  var tds = [], td = row.firstChild, name, col, i = 0, contents, columns = settings.aoColumns, objectRead = settings._rowReadObject;
  d = d !== void 0 ? d : objectRead ? {} : [];
  var attr = function(str, td2) {
    if (typeof str === "string") {
      var idx = str.indexOf("@");
      if (idx !== -1) {
        var attr2 = str.substring(idx + 1);
        var setter = _fnSetObjectDataFn(str);
        setter(d, td2.getAttribute(attr2));
      }
    }
  };
  var cellProcess = function(cell) {
    if (colIdx === void 0 || colIdx === i) {
      col = columns[i];
      contents = cell.innerHTML.trim();
      if (col && col._bAttrSrc) {
        var setter = _fnSetObjectDataFn(col.mData._);
        setter(d, contents);
        attr(col.mData.sort, cell);
        attr(col.mData.type, cell);
        attr(col.mData.filter, cell);
      } else {
        if (objectRead) {
          if (!col._setter) {
            col._setter = _fnSetObjectDataFn(col.mData);
          }
          col._setter(d, contents);
        } else {
          d[i] = contents;
        }
      }
    }
    i++;
  };
  if (td) {
    while (td) {
      name = td.nodeName.toUpperCase();
      if (name == "TD" || name == "TH") {
        cellProcess(td);
        tds.push(td);
      }
      td = td.nextSibling;
    }
  } else {
    tds = row.anCells;
    for (var j = 0, jen = tds.length; j < jen; j++) {
      cellProcess(tds[j]);
    }
  }
  var rowNode = row.firstChild ? row : row.nTr;
  if (rowNode) {
    var id = rowNode.getAttribute("id");
    if (id) {
      _fnSetObjectDataFn(settings.rowId)(d, id);
    }
  }
  return {
    data: d,
    cells: tds
  };
}
function _fnGetRowDisplay(settings, rowIdx) {
  var rowModal = settings.aoData[rowIdx];
  var columns = settings.aoColumns;
  if (!rowModal.displayData) {
    rowModal.displayData = [];
    for (var colIdx = 0, len = columns.length; colIdx < len; colIdx++) {
      rowModal.displayData.push(
        _fnGetCellData(settings, rowIdx, colIdx, "display")
      );
    }
  }
  return rowModal.displayData;
}
function _fnCreateTr(oSettings, iRow, nTrIn, anTds) {
  var row = oSettings.aoData[iRow], rowData = row._aData, cells = [], nTr, nTd, oCol, i, iLen, create, trClass = oSettings.oClasses.tbody.row;
  if (row.nTr === null) {
    nTr = nTrIn || document.createElement("tr");
    row.nTr = nTr;
    row.anCells = cells;
    _addClass(nTr, trClass);
    nTr._DT_RowIndex = iRow;
    _fnRowAttributes(oSettings, row);
    for (i = 0, iLen = oSettings.aoColumns.length; i < iLen; i++) {
      oCol = oSettings.aoColumns[i];
      create = nTrIn && anTds[i] ? false : true;
      nTd = create ? document.createElement(oCol.sCellType) : anTds[i];
      if (!nTd) {
        _fnLog(oSettings, 0, "Incorrect column count", 18);
      }
      nTd._DT_CellIndex = {
        row: iRow,
        column: i
      };
      cells.push(nTd);
      var display = _fnGetRowDisplay(oSettings, iRow);
      if (create || (oCol.mRender || oCol.mData !== i) && (!$.isPlainObject(oCol.mData) || oCol.mData._ !== i + ".display")) {
        _fnWriteCell(nTd, display[i]);
      }
      _addClass(nTd, oCol.sClass);
      if (oCol.bVisible && create) {
        nTr.appendChild(nTd);
      } else if (!oCol.bVisible && !create) {
        nTd.parentNode.removeChild(nTd);
      }
      if (oCol.fnCreatedCell) {
        oCol.fnCreatedCell.call(
          oSettings.oInstance,
          nTd,
          _fnGetCellData(oSettings, iRow, i),
          rowData,
          iRow,
          i
        );
      }
    }
    _fnCallbackFire(oSettings, "aoRowCreatedCallback", "row-created", [nTr, rowData, iRow, cells]);
  } else {
    _addClass(row.nTr, trClass);
  }
}
function _fnRowAttributes(settings, row) {
  var tr = row.nTr;
  var data = row._aData;
  if (tr) {
    var id = settings.rowIdFn(data);
    if (id) {
      tr.id = id;
    }
    if (data.DT_RowClass) {
      var a = data.DT_RowClass.split(" ");
      row.__rowc = row.__rowc ? _unique(row.__rowc.concat(a)) : a;
      $(tr).removeClass(row.__rowc.join(" ")).addClass(data.DT_RowClass);
    }
    if (data.DT_RowAttr) {
      $(tr).attr(data.DT_RowAttr);
    }
    if (data.DT_RowData) {
      $(tr).data(data.DT_RowData);
    }
  }
}
function _fnBuildHead(settings, side) {
  var classes = settings.oClasses;
  var columns = settings.aoColumns;
  var i, iLen, row;
  var target = side === "header" ? settings.nTHead : settings.nTFoot;
  var titleProp = side === "header" ? "sTitle" : side;
  if (!target) {
    return;
  }
  if (side === "header" || _pluck(settings.aoColumns, titleProp).join("")) {
    row = $("tr", target);
    if (!row.length) {
      row = $("<tr/>").appendTo(target);
    }
    if (row.length === 1) {
      var cellCount = 0;
      $("td, th", row).each(function() {
        cellCount += this.colSpan;
      });
      for (i = cellCount, iLen = columns.length; i < iLen; i++) {
        $("<th/>").html(columns[i][titleProp] || "").appendTo(row);
      }
    }
  }
  var detected = _fnDetectHeader(settings, target, true);
  if (side === "header") {
    settings.aoHeader = detected;
    $("tr", target).addClass(classes.thead.row);
  } else {
    settings.aoFooter = detected;
    $("tr", target).addClass(classes.tfoot.row);
  }
  $(target).children("tr").children("th, td").each(function() {
    _fnRenderer(settings, side)(
      settings,
      $(this),
      classes
    );
  });
}
function _fnHeaderLayout(settings, source, incColumns) {
  var row, column, cell;
  var local = [];
  var structure = [];
  var columns = settings.aoColumns;
  var columnCount = columns.length;
  var rowspan, colspan;
  if (!source) {
    return;
  }
  if (!incColumns) {
    incColumns = _range(columnCount).filter(function(idx) {
      return columns[idx].bVisible;
    });
  }
  for (row = 0; row < source.length; row++) {
    local[row] = source[row].slice().filter(function(cell2, i) {
      return incColumns.includes(i);
    });
    structure.push([]);
  }
  for (row = 0; row < local.length; row++) {
    for (column = 0; column < local[row].length; column++) {
      rowspan = 1;
      colspan = 1;
      if (structure[row][column] === void 0) {
        cell = local[row][column].cell;
        while (local[row + rowspan] !== void 0 && local[row][column].cell == local[row + rowspan][column].cell) {
          structure[row + rowspan][column] = null;
          rowspan++;
        }
        while (local[row][column + colspan] !== void 0 && local[row][column].cell == local[row][column + colspan].cell) {
          for (var k = 0; k < rowspan; k++) {
            structure[row + k][column + colspan] = null;
          }
          colspan++;
        }
        var titleSpan = $("span.dt-column-title", cell);
        structure[row][column] = {
          cell,
          colspan,
          rowspan,
          title: titleSpan.length ? titleSpan.html() : $(cell).html()
        };
      }
    }
  }
  return structure;
}
function _fnDrawHead(settings, source) {
  var layout = _fnHeaderLayout(settings, source);
  var tr, n;
  for (var row = 0; row < source.length; row++) {
    tr = source[row].row;
    if (tr) {
      while (n = tr.firstChild) {
        tr.removeChild(n);
      }
    }
    for (var column = 0; column < layout[row].length; column++) {
      var point = layout[row][column];
      if (point) {
        $(point.cell).appendTo(tr).attr("rowspan", point.rowspan).attr("colspan", point.colspan);
      }
    }
  }
}
function _fnDraw(oSettings, ajaxComplete) {
  _fnStart(oSettings);
  var aPreDraw = _fnCallbackFire(oSettings, "aoPreDrawCallback", "preDraw", [oSettings]);
  if (aPreDraw.indexOf(false) !== -1) {
    _fnProcessingDisplay(oSettings, false);
    return;
  }
  var anRows = [];
  var iRowCount = 0;
  var bServerSide = _fnDataSource(oSettings) == "ssp";
  var aiDisplay = oSettings.aiDisplay;
  var iDisplayStart = oSettings._iDisplayStart;
  var iDisplayEnd = oSettings.fnDisplayEnd();
  var columns = oSettings.aoColumns;
  var body = $(oSettings.nTBody);
  oSettings.bDrawing = true;
  if (oSettings.deferLoading) {
    oSettings.deferLoading = false;
    oSettings.iDraw++;
    _fnProcessingDisplay(oSettings, false);
  } else if (!bServerSide) {
    oSettings.iDraw++;
  } else if (!oSettings.bDestroying && !ajaxComplete) {
    if (oSettings.iDraw === 0) {
      body.empty().append(_emptyRow(oSettings));
    }
    _fnAjaxUpdate(oSettings);
    return;
  }
  if (aiDisplay.length !== 0) {
    var iStart = bServerSide ? 0 : iDisplayStart;
    var iEnd = bServerSide ? oSettings.aoData.length : iDisplayEnd;
    for (var j = iStart; j < iEnd; j++) {
      var iDataIndex = aiDisplay[j];
      var aoData = oSettings.aoData[iDataIndex];
      if (aoData.nTr === null) {
        _fnCreateTr(oSettings, iDataIndex);
      }
      var nRow = aoData.nTr;
      for (var i = 0; i < columns.length; i++) {
        var col = columns[i];
        var td = aoData.anCells[i];
        _addClass(td, _ext.type.className[col.sType]);
        _addClass(td, oSettings.oClasses.tbody.cell);
      }
      _fnCallbackFire(
        oSettings,
        "aoRowCallback",
        null,
        [nRow, aoData._aData, iRowCount, j, iDataIndex]
      );
      anRows.push(nRow);
      iRowCount++;
    }
  } else {
    anRows[0] = _emptyRow(oSettings);
  }
  _fnCallbackFire(oSettings, "aoHeaderCallback", "header", [
    $(oSettings.nTHead).children("tr")[0],
    _fnGetDataMaster(oSettings),
    iDisplayStart,
    iDisplayEnd,
    aiDisplay
  ]);
  _fnCallbackFire(oSettings, "aoFooterCallback", "footer", [
    $(oSettings.nTFoot).children("tr")[0],
    _fnGetDataMaster(oSettings),
    iDisplayStart,
    iDisplayEnd,
    aiDisplay
  ]);
  if (body[0].replaceChildren) {
    body[0].replaceChildren.apply(body[0], anRows);
  } else {
    body.children().detach();
    body.append($(anRows));
  }
  $(oSettings.nTableWrapper).toggleClass("dt-empty-footer", $("tr", oSettings.nTFoot).length === 0);
  _fnCallbackFire(oSettings, "aoDrawCallback", "draw", [oSettings], true);
  oSettings.bSorted = false;
  oSettings.bFiltered = false;
  oSettings.bDrawing = false;
}
function _fnReDraw(settings, holdPosition, recompute) {
  var features = settings.oFeatures, sort = features.bSort, filter = features.bFilter;
  if (recompute === void 0 || recompute === true) {
    _fnColumnTypes(settings);
    if (sort) {
      _fnSort(settings);
    }
    if (filter) {
      _fnFilterComplete(settings, settings.oPreviousSearch);
    } else {
      settings.aiDisplay = settings.aiDisplayMaster.slice();
    }
  }
  if (holdPosition !== true) {
    settings._iDisplayStart = 0;
  }
  settings._drawHold = holdPosition;
  _fnDraw(settings);
  settings.api.one("draw", function() {
    settings._drawHold = false;
  });
}
function _emptyRow(settings) {
  var oLang = settings.oLanguage;
  var zero = oLang.sZeroRecords;
  var dataSrc = _fnDataSource(settings);
  if ((dataSrc === "ssp" || dataSrc === "ajax") && !settings.json) {
    zero = oLang.sLoadingRecords;
  } else if (oLang.sEmptyTable && settings.fnRecordsTotal() === 0) {
    zero = oLang.sEmptyTable;
  }
  return $("<tr/>").append($("<td />", {
    "colSpan": _fnVisibleColumns(settings),
    "class": settings.oClasses.empty.row
  }).html(zero))[0];
}
function _layoutItems(row, align, items) {
  if (Array.isArray(items)) {
    for (var i = 0; i < items.length; i++) {
      _layoutItems(row, align, items[i]);
    }
    return;
  }
  var rowCell = row[align];
  if ($.isPlainObject(items)) {
    if (items.features) {
      if (items.rowId) {
        row.id = items.rowId;
      }
      if (items.rowClass) {
        row.className = items.rowClass;
      }
      rowCell.id = items.id;
      rowCell.className = items.className;
      _layoutItems(row, align, items.features);
    } else {
      Object.keys(items).map(function(key) {
        rowCell.contents.push({
          feature: key,
          opts: items[key]
        });
      });
    }
  } else {
    rowCell.contents.push(items);
  }
}
function _layoutGetRow(rows, rowNum, align) {
  var row;
  for (var i = 0; i < rows.length; i++) {
    row = rows[i];
    if (row.rowNum === rowNum) {
      if (align === "full" && row.full || (align === "start" || align === "end") && (row.start || row.end)) {
        if (!row[align]) {
          row[align] = {
            contents: []
          };
        }
        return row;
      }
    }
  }
  row = {
    rowNum
  };
  row[align] = {
    contents: []
  };
  rows.push(row);
  return row;
}
function _layoutArray(settings, layout, side) {
  var rows = [];
  $.each(layout, function(pos, items) {
    if (items === null) {
      return;
    }
    var parts = pos.match(/^([a-z]+)([0-9]*)([A-Za-z]*)$/);
    var rowNum = parts[2] ? parts[2] * 1 : 0;
    var align = parts[3] ? parts[3].toLowerCase() : "full";
    if (parts[1] !== side) {
      return;
    }
    var row2 = _layoutGetRow(rows, rowNum, align);
    _layoutItems(row2, align, items);
  });
  rows.sort(function(a, b) {
    var order1 = a.rowNum;
    var order2 = b.rowNum;
    if (order1 === order2) {
      var ret = a.full && !b.full ? -1 : 1;
      return side === "bottom" ? ret * -1 : ret;
    }
    return order2 - order1;
  });
  if (side === "bottom") {
    rows.reverse();
  }
  for (var row = 0; row < rows.length; row++) {
    delete rows[row].rowNum;
    _layoutResolve(settings, rows[row]);
  }
  return rows;
}
function _layoutResolve(settings, row) {
  var getFeature = function(feature, opts) {
    if (!_ext.features[feature]) {
      _fnLog(settings, 0, "Unknown feature: " + feature);
    }
    return _ext.features[feature].apply(this, [settings, opts]);
  };
  var resolve = function(item) {
    if (!row[item]) {
      return;
    }
    var line = row[item].contents;
    for (var i = 0, iLen = line.length; i < iLen; i++) {
      if (!line[i]) {
        continue;
      } else if (typeof line[i] === "string") {
        line[i] = getFeature(line[i], null);
      } else if ($.isPlainObject(line[i])) {
        line[i] = getFeature(line[i].feature, line[i].opts);
      } else if (typeof line[i].node === "function") {
        line[i] = line[i].node(settings);
      } else if (typeof line[i] === "function") {
        var inst = line[i](settings);
        line[i] = typeof inst.node === "function" ? inst.node() : inst;
      }
    }
  };
  resolve("start");
  resolve("end");
  resolve("full");
}
function _fnAddOptionsHtml(settings) {
  var classes = settings.oClasses;
  var table = $(settings.nTable);
  var insert = $("<div/>").attr({
    id: settings.sTableId + "_wrapper",
    "class": classes.container
  }).insertBefore(table);
  settings.nTableWrapper = insert[0];
  if (settings.sDom) {
    _fnLayoutDom(settings, settings.sDom, insert);
  } else {
    var top = _layoutArray(settings, settings.layout, "top");
    var bottom = _layoutArray(settings, settings.layout, "bottom");
    var renderer = _fnRenderer(settings, "layout");
    top.forEach(function(item) {
      renderer(settings, insert, item);
    });
    renderer(settings, insert, {
      full: {
        table: true,
        contents: [_fnFeatureHtmlTable(settings)]
      }
    });
    bottom.forEach(function(item) {
      renderer(settings, insert, item);
    });
  }
  _processingHtml(settings);
}
function _fnLayoutDom(settings, dom, insert) {
  var parts = dom.match(/(".*?")|('.*?')|./g);
  var featureNode, option, newNode, next, attr;
  for (var i = 0; i < parts.length; i++) {
    featureNode = null;
    option = parts[i];
    if (option == "<") {
      newNode = $("<div/>");
      next = parts[i + 1];
      if (next[0] == "'" || next[0] == '"') {
        attr = next.replace(/['"]/g, "");
        var id = "", className;
        if (attr.indexOf(".") != -1) {
          var split = attr.split(".");
          id = split[0];
          className = split[1];
        } else if (attr[0] == "#") {
          id = attr;
        } else {
          className = attr;
        }
        newNode.attr("id", id.substring(1)).addClass(className);
        i++;
      }
      insert.append(newNode);
      insert = newNode;
    } else if (option == ">") {
      insert = insert.parent();
    } else if (option == "t") {
      featureNode = _fnFeatureHtmlTable(settings);
    } else {
      DataTable.ext.feature.forEach(function(feature) {
        if (option == feature.cFeature) {
          featureNode = feature.fnInit(settings);
        }
      });
    }
    if (featureNode) {
      insert.append(featureNode);
    }
  }
}
function _fnDetectHeader(settings, thead, write) {
  var columns = settings.aoColumns;
  var rows = $(thead).children("tr");
  var row, cell;
  var i, k, l, iLen, shifted, column, colspan, rowspan;
  var titleRow = settings.titleRow;
  var isHeader = thead && thead.nodeName.toLowerCase() === "thead";
  var layout = [];
  var unique;
  var shift = function(a, i2, j) {
    var k2 = a[i2];
    while (k2[j]) {
      j++;
    }
    return j;
  };
  for (i = 0, iLen = rows.length; i < iLen; i++) {
    layout.push([]);
  }
  for (i = 0, iLen = rows.length; i < iLen; i++) {
    row = rows[i];
    column = 0;
    cell = row.firstChild;
    while (cell) {
      if (cell.nodeName.toUpperCase() == "TD" || cell.nodeName.toUpperCase() == "TH") {
        var cols = [];
        var jqCell = $(cell);
        colspan = cell.getAttribute("colspan") * 1;
        rowspan = cell.getAttribute("rowspan") * 1;
        colspan = !colspan || colspan === 0 || colspan === 1 ? 1 : colspan;
        rowspan = !rowspan || rowspan === 0 || rowspan === 1 ? 1 : rowspan;
        shifted = shift(layout, i, column);
        unique = colspan === 1 ? true : false;
        if (write) {
          if (unique) {
            _fnColumnOptions(settings, shifted, _fnEscapeObject(jqCell.data()));
            var columnDef = columns[shifted];
            var width = cell.getAttribute("width") || null;
            var t = cell.style.width.match(/width:\s*(\d+[pxem%]+)/);
            if (t) {
              width = t[1];
            }
            columnDef.sWidthOrig = columnDef.sWidth || width;
            if (isHeader) {
              if (columnDef.sTitle !== null && !columnDef.autoTitle) {
                if (titleRow === true && i === 0 || // top row
                titleRow === false && i === rows.length - 1 || // bottom row
                titleRow === i || // specific row
                titleRow === null) {
                  cell.innerHTML = columnDef.sTitle;
                }
              }
              if (!columnDef.sTitle && unique) {
                columnDef.sTitle = _stripHtml(cell.innerHTML);
                columnDef.autoTitle = true;
              }
            } else {
              if (columnDef.footer) {
                cell.innerHTML = columnDef.footer;
              }
            }
            if (!columnDef.ariaTitle) {
              columnDef.ariaTitle = jqCell.attr("aria-label") || columnDef.sTitle;
            }
            if (columnDef.className) {
              jqCell.addClass(columnDef.className);
            }
          }
          if ($("span.dt-column-title", cell).length === 0) {
            $("<span>").addClass("dt-column-title").append(cell.childNodes).appendTo(cell);
          }
          if (settings.orderIndicators && isHeader && jqCell.filter(":not([data-dt-order=disable])").length !== 0 && jqCell.parent(":not([data-dt-order=disable])").length !== 0 && $("span.dt-column-order", cell).length === 0) {
            $("<span>").addClass("dt-column-order").appendTo(cell);
          }
          var headerFooter = isHeader ? "header" : "footer";
          if ($("span.dt-column-" + headerFooter, cell).length === 0) {
            $("<div>").addClass("dt-column-" + headerFooter).append(cell.childNodes).appendTo(cell);
          }
        }
        for (l = 0; l < colspan; l++) {
          for (k = 0; k < rowspan; k++) {
            layout[i + k][shifted + l] = {
              cell,
              unique
            };
            layout[i + k].row = row;
          }
          cols.push(shifted + l);
        }
        cell.setAttribute("data-dt-column", _unique(cols).join(","));
      }
      cell = cell.nextSibling;
    }
  }
  return layout;
}
function _fnStart(oSettings) {
  var bServerSide = _fnDataSource(oSettings) == "ssp";
  var iInitDisplayStart = oSettings.iInitDisplayStart;
  if (iInitDisplayStart !== void 0 && iInitDisplayStart !== -1) {
    oSettings._iDisplayStart = bServerSide ? iInitDisplayStart : iInitDisplayStart >= oSettings.fnRecordsDisplay() ? 0 : iInitDisplayStart;
    oSettings.iInitDisplayStart = -1;
  }
}
function _fnBuildAjax(oSettings, data, fn) {
  var ajaxData;
  var ajax = oSettings.ajax;
  var instance = oSettings.oInstance;
  var callback = function(json) {
    var status = oSettings.jqXHR ? oSettings.jqXHR.status : null;
    if (json === null || typeof status === "number" && status == 204) {
      json = {};
      _fnAjaxDataSrc(oSettings, json, []);
    }
    var error = json.error || json.sError;
    if (error) {
      _fnLog(oSettings, 0, error);
    }
    if (json.d && typeof json.d === "string") {
      try {
        json = JSON.parse(json.d);
      } catch (e) {
      }
    }
    oSettings.json = json;
    _fnCallbackFire(oSettings, null, "xhr", [oSettings, json, oSettings.jqXHR], true);
    fn(json);
  };
  if ($.isPlainObject(ajax) && ajax.data) {
    ajaxData = ajax.data;
    var newData = typeof ajaxData === "function" ? ajaxData(data, oSettings) : ajaxData;
    data = typeof ajaxData === "function" && newData ? newData : $.extend(true, data, newData);
    delete ajax.data;
  }
  var baseAjax = {
    url: typeof ajax === "string" ? ajax : "",
    data,
    success: callback,
    dataType: "json",
    cache: false,
    type: oSettings.sServerMethod,
    error: function(xhr, error) {
      var ret = _fnCallbackFire(
        oSettings,
        null,
        "xhr",
        [oSettings, null, oSettings.jqXHR],
        true
      );
      if (ret.indexOf(true) === -1) {
        if (error == "parsererror") {
          _fnLog(oSettings, 0, "Invalid JSON response", 1);
        } else if (xhr.readyState === 4) {
          _fnLog(oSettings, 0, "Ajax error", 7);
        }
      }
      _fnProcessingDisplay(oSettings, false);
    }
  };
  if ($.isPlainObject(ajax)) {
    $.extend(baseAjax, ajax);
  }
  oSettings.oAjaxData = data;
  _fnCallbackFire(oSettings, null, "preXhr", [oSettings, data, baseAjax], true);
  if (baseAjax.submitAs === "json" && typeof data === "object") {
    baseAjax.data = JSON.stringify(data);
  }
  if (typeof ajax === "function") {
    oSettings.jqXHR = ajax.call(instance, data, callback, oSettings);
  } else if (ajax.url === "") {
    var empty = {};
    _fnAjaxDataSrc(oSettings, empty, []);
    callback(empty);
  } else {
    oSettings.jqXHR = $.ajax(baseAjax);
  }
  if (ajaxData) {
    ajax.data = ajaxData;
  }
}
function _fnAjaxUpdate(settings) {
  settings.iDraw++;
  _fnProcessingDisplay(settings, true);
  _fnBuildAjax(settings, _fnAjaxParameters(settings), function(json) {
    _fnAjaxUpdateDraw(settings, json);
  });
}
function _fnAjaxParameters(settings) {
  var columns = settings.aoColumns, features = settings.oFeatures, preSearch = settings.oPreviousSearch, preColSearch = settings.aoPreSearchCols, colData = function(idx, prop) {
    return typeof columns[idx][prop] === "function" ? "function" : columns[idx][prop];
  };
  return {
    draw: settings.iDraw,
    columns: columns.map(function(column, i) {
      return {
        data: colData(i, "mData"),
        name: column.sName,
        searchable: column.bSearchable,
        orderable: column.bSortable,
        search: {
          value: preColSearch[i].search,
          regex: preColSearch[i].regex,
          fixed: Object.keys(column.searchFixed).map(function(name) {
            return {
              name,
              term: typeof column.searchFixed[name] !== "function" ? column.searchFixed[name].toString() : "function"
            };
          })
        }
      };
    }),
    order: _fnSortFlatten(settings).map(function(val) {
      return {
        column: val.col,
        dir: val.dir,
        name: colData(val.col, "sName")
      };
    }),
    start: settings._iDisplayStart,
    length: features.bPaginate ? settings._iDisplayLength : -1,
    search: {
      value: preSearch.search,
      regex: preSearch.regex,
      fixed: Object.keys(settings.searchFixed).map(function(name) {
        return {
          name,
          term: typeof settings.searchFixed[name] !== "function" ? settings.searchFixed[name].toString() : "function"
        };
      })
    }
  };
}
function _fnAjaxUpdateDraw(settings, json) {
  var data = _fnAjaxDataSrc(settings, json);
  var draw = _fnAjaxDataSrcParam(settings, "draw", json);
  var recordsTotal = _fnAjaxDataSrcParam(settings, "recordsTotal", json);
  var recordsFiltered = _fnAjaxDataSrcParam(settings, "recordsFiltered", json);
  if (draw !== void 0) {
    if (draw * 1 < settings.iDraw) {
      return;
    }
    settings.iDraw = draw * 1;
  }
  if (!data) {
    data = [];
  }
  _fnClearTable(settings);
  settings._iRecordsTotal = parseInt(recordsTotal, 10);
  settings._iRecordsDisplay = parseInt(recordsFiltered, 10);
  for (var i = 0, iLen = data.length; i < iLen; i++) {
    _fnAddData(settings, data[i]);
  }
  settings.aiDisplay = settings.aiDisplayMaster.slice();
  _fnColumnTypes(settings);
  _fnDraw(settings, true);
  _fnInitComplete(settings);
  _fnProcessingDisplay(settings, false);
}
function _fnAjaxDataSrc(settings, json, write) {
  var dataProp = "data";
  if ($.isPlainObject(settings.ajax) && settings.ajax.dataSrc !== void 0) {
    var dataSrc = settings.ajax.dataSrc;
    if (typeof dataSrc === "string" || typeof dataSrc === "function") {
      dataProp = dataSrc;
    } else if (dataSrc.data !== void 0) {
      dataProp = dataSrc.data;
    }
  }
  if (!write) {
    if (dataProp === "data") {
      return json.aaData || json[dataProp];
    }
    return dataProp !== "" ? _fnGetObjectDataFn(dataProp)(json) : json;
  }
  _fnSetObjectDataFn(dataProp)(json, write);
}
function _fnAjaxDataSrcParam(settings, param, json) {
  var dataSrc = $.isPlainObject(settings.ajax) ? settings.ajax.dataSrc : null;
  if (dataSrc && dataSrc[param]) {
    return _fnGetObjectDataFn(dataSrc[param])(json);
  }
  var old = "";
  if (param === "draw") {
    old = "sEcho";
  } else if (param === "recordsTotal") {
    old = "iTotalRecords";
  } else if (param === "recordsFiltered") {
    old = "iTotalDisplayRecords";
  }
  return json[old] !== void 0 ? json[old] : json[param];
}
function _fnFilterComplete(settings, input) {
  var columnsSearch = settings.aoPreSearchCols;
  if (_fnDataSource(settings) != "ssp") {
    _fnFilterData(settings);
    settings.aiDisplay = settings.aiDisplayMaster.slice();
    _fnFilter(settings.aiDisplay, settings, input.search, input);
    $.each(settings.searchFixed, function(name, term) {
      _fnFilter(settings.aiDisplay, settings, term, {});
    });
    for (var i = 0; i < columnsSearch.length; i++) {
      var col = columnsSearch[i];
      _fnFilter(
        settings.aiDisplay,
        settings,
        col.search,
        col,
        i
      );
      $.each(settings.aoColumns[i].searchFixed, function(name, term) {
        _fnFilter(settings.aiDisplay, settings, term, {}, i);
      });
    }
    _fnFilterCustom(settings);
  }
  settings.bFiltered = true;
  _fnCallbackFire(settings, null, "search", [settings]);
}
function _fnFilterCustom(settings) {
  var filters = DataTable.ext.search;
  var displayRows = settings.aiDisplay;
  var row, rowIdx;
  for (var i = 0, iLen = filters.length; i < iLen; i++) {
    var rows = [];
    for (var j = 0, jen = displayRows.length; j < jen; j++) {
      rowIdx = displayRows[j];
      row = settings.aoData[rowIdx];
      if (filters[i](settings, row._aFilterData, rowIdx, row._aData, j)) {
        rows.push(rowIdx);
      }
    }
    displayRows.length = 0;
    _fnArrayApply(displayRows, rows);
  }
}
function _fnFilter(searchRows, settings, input, options, column) {
  if (input === "") {
    return;
  }
  var i = 0;
  var matched = [];
  var searchFunc = typeof input === "function" ? input : null;
  var rpSearch = input instanceof RegExp ? input : searchFunc ? null : _fnFilterCreateSearch(input, options);
  for (i = 0; i < searchRows.length; i++) {
    var row = settings.aoData[searchRows[i]];
    var data = column === void 0 ? row._sFilterRow : row._aFilterData[column];
    if (searchFunc && searchFunc(data, row._aData, searchRows[i], column) || rpSearch && rpSearch.test(data)) {
      matched.push(searchRows[i]);
    }
  }
  searchRows.length = matched.length;
  for (i = 0; i < matched.length; i++) {
    searchRows[i] = matched[i];
  }
}
function _fnFilterCreateSearch(search, inOpts) {
  var not = [];
  var options = $.extend({}, {
    boundary: false,
    caseInsensitive: true,
    exact: false,
    regex: false,
    smart: true
  }, inOpts);
  if (typeof search !== "string") {
    search = search.toString();
  }
  search = _normalize(search);
  if (options.exact) {
    return new RegExp(
      "^" + _fnEscapeRegex(search) + "$",
      options.caseInsensitive ? "i" : ""
    );
  }
  search = options.regex ? search : _fnEscapeRegex(search);
  if (options.smart) {
    var parts = search.match(/!?["\u201C][^"\u201D]+["\u201D]|[^ ]+/g) || [""];
    var a = parts.map(function(word) {
      var negative = false;
      var m;
      if (word.charAt(0) === "!") {
        negative = true;
        word = word.substring(1);
      }
      if (word.charAt(0) === '"') {
        m = word.match(/^"(.*)"$/);
        word = m ? m[1] : word;
      } else if (word.charAt(0) === "“") {
        m = word.match(/^\u201C(.*)\u201D$/);
        word = m ? m[1] : word;
      }
      if (negative) {
        if (word.length > 1) {
          not.push("(?!" + word + ")");
        }
        word = "";
      }
      return word.replace(/"/g, "");
    });
    var match = not.length ? not.join("") : "";
    var boundary = options.boundary ? "\\b" : "";
    search = "^(?=.*?" + boundary + a.join(")(?=.*?" + boundary) + ")(" + match + ".)*$";
  }
  return new RegExp(search, options.caseInsensitive ? "i" : "");
}
var _fnEscapeRegex = DataTable.util.escapeRegex;
var __filter_div = $("<div>")[0];
var __filter_div_textContent = __filter_div.textContent !== void 0;
function _fnFilterData(settings) {
  var columns = settings.aoColumns;
  var data = settings.aoData;
  var column;
  var j, jen, filterData, cellData, row;
  var wasInvalidated = false;
  for (var rowIdx = 0; rowIdx < data.length; rowIdx++) {
    if (!data[rowIdx]) {
      continue;
    }
    row = data[rowIdx];
    if (!row._aFilterData) {
      filterData = [];
      for (j = 0, jen = columns.length; j < jen; j++) {
        column = columns[j];
        if (column.bSearchable) {
          cellData = _fnGetCellData(settings, rowIdx, j, "filter");
          if (cellData === null) {
            cellData = "";
          }
          if (typeof cellData !== "string" && cellData.toString) {
            cellData = cellData.toString();
          }
        } else {
          cellData = "";
        }
        if (cellData.indexOf && cellData.indexOf("&") !== -1) {
          __filter_div.innerHTML = cellData;
          cellData = __filter_div_textContent ? __filter_div.textContent : __filter_div.innerText;
        }
        if (cellData.replace) {
          cellData = cellData.replace(/[\r\n\u2028]/g, "");
        }
        filterData.push(cellData);
      }
      row._aFilterData = filterData;
      row._sFilterRow = filterData.join("  ");
      wasInvalidated = true;
    }
  }
  return wasInvalidated;
}
function _fnInitialise(settings) {
  var i;
  var init = settings.oInit;
  var deferLoading = settings.deferLoading;
  var dataSrc = _fnDataSource(settings);
  if (!settings.bInitialised) {
    setTimeout(function() {
      _fnInitialise(settings);
    }, 200);
    return;
  }
  _fnBuildHead(settings, "header");
  _fnBuildHead(settings, "footer");
  _fnLoadState(settings, init, function() {
    _fnDrawHead(settings, settings.aoHeader);
    _fnDrawHead(settings, settings.aoFooter);
    var iAjaxStart = settings.iInitDisplayStart;
    if (init.aaData) {
      for (i = 0; i < init.aaData.length; i++) {
        _fnAddData(settings, init.aaData[i]);
      }
    } else if (deferLoading || dataSrc == "dom") {
      _fnAddTr(settings, $(settings.nTBody).children("tr"));
    }
    settings.aiDisplay = settings.aiDisplayMaster.slice();
    _fnAddOptionsHtml(settings);
    _fnSortInit(settings);
    _colGroup(settings);
    _fnProcessingDisplay(settings, true);
    _fnCallbackFire(settings, null, "preInit", [settings], true);
    _fnReDraw(settings);
    if (dataSrc != "ssp" || deferLoading) {
      if (dataSrc == "ajax") {
        _fnBuildAjax(settings, {}, function(json) {
          var aData = _fnAjaxDataSrc(settings, json);
          for (i = 0; i < aData.length; i++) {
            _fnAddData(settings, aData[i]);
          }
          settings.iInitDisplayStart = iAjaxStart;
          _fnReDraw(settings);
          _fnProcessingDisplay(settings, false);
          _fnInitComplete(settings);
        });
      } else {
        _fnInitComplete(settings);
        _fnProcessingDisplay(settings, false);
      }
    }
  });
}
function _fnInitComplete(settings) {
  if (settings._bInitComplete) {
    return;
  }
  var args = [settings, settings.json];
  settings._bInitComplete = true;
  _fnAdjustColumnSizing(settings);
  _fnCallbackFire(settings, null, "plugin-init", args, true);
  _fnCallbackFire(settings, "aoInitComplete", "init", args, true);
}
function _fnLengthChange(settings, val) {
  var len = parseInt(val, 10);
  settings._iDisplayLength = len;
  _fnLengthOverflow(settings);
  _fnCallbackFire(settings, null, "length", [settings, len]);
}
function _fnPageChange(settings, action, redraw) {
  var start = settings._iDisplayStart, len = settings._iDisplayLength, records = settings.fnRecordsDisplay();
  if (records === 0 || len === -1) {
    start = 0;
  } else if (typeof action === "number") {
    start = action * len;
    if (start > records) {
      start = 0;
    }
  } else if (action == "first") {
    start = 0;
  } else if (action == "previous") {
    start = len >= 0 ? start - len : 0;
    if (start < 0) {
      start = 0;
    }
  } else if (action == "next") {
    if (start + len < records) {
      start += len;
    }
  } else if (action == "last") {
    start = Math.floor((records - 1) / len) * len;
  } else if (action === "ellipsis") {
    return;
  } else {
    _fnLog(settings, 0, "Unknown paging action: " + action, 5);
  }
  var changed = settings._iDisplayStart !== start;
  settings._iDisplayStart = start;
  _fnCallbackFire(settings, null, changed ? "page" : "page-nc", [settings]);
  if (changed && redraw) {
    _fnDraw(settings);
  }
  return changed;
}
function _processingHtml(settings) {
  var table = settings.nTable;
  var scrolling = settings.oScroll.sX !== "" || settings.oScroll.sY !== "";
  if (settings.oFeatures.bProcessing) {
    var n = $("<div/>", {
      "id": settings.sTableId + "_processing",
      "class": settings.oClasses.processing.container,
      "role": "status"
    }).html(settings.oLanguage.sProcessing).append("<div><div></div><div></div><div></div><div></div></div>");
    if (scrolling) {
      n.prependTo($("div.dt-scroll", settings.nTableWrapper));
    } else {
      n.insertBefore(table);
    }
    $(table).on("processing.dt.DT", function(e, s, show) {
      n.css("display", show ? "block" : "none");
    });
  }
}
function _fnProcessingDisplay(settings, show) {
  if (settings.bDrawing && show === false) {
    return;
  }
  _fnCallbackFire(settings, null, "processing", [settings, show]);
}
function _fnProcessingRun(settings, enable, run) {
  if (!enable) {
    run();
  } else {
    _fnProcessingDisplay(settings, true);
    setTimeout(function() {
      run();
      _fnProcessingDisplay(settings, false);
    }, 0);
  }
}
function _fnFeatureHtmlTable(settings) {
  var table = $(settings.nTable);
  var scroll = settings.oScroll;
  if (scroll.sX === "" && scroll.sY === "") {
    return settings.nTable;
  }
  var scrollX = scroll.sX;
  var scrollY = scroll.sY;
  var classes = settings.oClasses.scrolling;
  var caption = settings.captionNode;
  var captionSide = caption ? caption._captionSide : null;
  var headerClone = $(table[0].cloneNode(false));
  var footerClone = $(table[0].cloneNode(false));
  var footer = table.children("tfoot");
  var _div = "<div/>";
  var size = function(s) {
    return !s ? null : _fnStringToCss(s);
  };
  if (!footer.length) {
    footer = null;
  }
  var scroller = $(_div, { "class": classes.container }).append(
    $(_div, { "class": classes.header.self }).css({
      overflow: "hidden",
      position: "relative",
      border: 0,
      width: scrollX ? size(scrollX) : "100%"
    }).append(
      $(_div, { "class": classes.header.inner }).css({
        "box-sizing": "content-box",
        width: scroll.sXInner || "100%"
      }).append(
        headerClone.removeAttr("id").css("margin-left", 0).append(captionSide === "top" ? caption : null).append(
          table.children("thead")
        )
      )
    )
  ).append(
    $(_div, { "class": classes.body }).css({
      position: "relative",
      overflow: "auto",
      width: size(scrollX)
    }).append(table)
  );
  if (footer) {
    scroller.append(
      $(_div, { "class": classes.footer.self }).css({
        overflow: "hidden",
        border: 0,
        width: scrollX ? size(scrollX) : "100%"
      }).append(
        $(_div, { "class": classes.footer.inner }).append(
          footerClone.removeAttr("id").css("margin-left", 0).append(captionSide === "bottom" ? caption : null).append(
            table.children("tfoot")
          )
        )
      )
    );
  }
  var children = scroller.children();
  var scrollHead = children[0];
  var scrollBody = children[1];
  var scrollFoot = footer ? children[2] : null;
  $(scrollBody).on("scroll.DT", function() {
    var scrollLeft = this.scrollLeft;
    scrollHead.scrollLeft = scrollLeft;
    if (footer) {
      scrollFoot.scrollLeft = scrollLeft;
    }
  });
  $("th, td", scrollHead).on("focus", function() {
    var scrollLeft = scrollHead.scrollLeft;
    scrollBody.scrollLeft = scrollLeft;
    if (footer) {
      scrollBody.scrollLeft = scrollLeft;
    }
  });
  $(scrollBody).css("max-height", scrollY);
  if (!scroll.bCollapse) {
    $(scrollBody).css("height", scrollY);
  }
  settings.nScrollHead = scrollHead;
  settings.nScrollBody = scrollBody;
  settings.nScrollFoot = scrollFoot;
  settings.aoDrawCallback.push(_fnScrollDraw);
  return scroller[0];
}
function _fnScrollDraw(settings) {
  var scroll = settings.oScroll, barWidth = scroll.iBarWidth, divHeader = $(settings.nScrollHead), divHeaderInner = divHeader.children("div"), divHeaderTable = divHeaderInner.children("table"), divBodyEl = settings.nScrollBody, divBody = $(divBodyEl), divFooter = $(settings.nScrollFoot), divFooterInner = divFooter.children("div"), divFooterTable = divFooterInner.children("table"), header = $(settings.nTHead), table = $(settings.nTable), footer = settings.nTFoot && $("th, td", settings.nTFoot).length ? $(settings.nTFoot) : null, browser = settings.oBrowser, headerCopy, footerCopy;
  var scrollBarVis = divBodyEl.scrollHeight > divBodyEl.clientHeight;
  if (settings.scrollBarVis !== scrollBarVis && settings.scrollBarVis !== void 0) {
    settings.scrollBarVis = scrollBarVis;
    _fnAdjustColumnSizing(settings);
    return;
  } else {
    settings.scrollBarVis = scrollBarVis;
  }
  table.children("thead, tfoot").remove();
  headerCopy = header.clone().prependTo(table);
  headerCopy.find("th, td").removeAttr("tabindex");
  headerCopy.find("[id]").removeAttr("id");
  if (footer) {
    footerCopy = footer.clone().prependTo(table);
    footerCopy.find("[id]").removeAttr("id");
  }
  if (settings.aiDisplay.length) {
    var firstTr = null;
    var start = _fnDataSource(settings) !== "ssp" ? settings._iDisplayStart : 0;
    for (i = start; i < start + settings.aiDisplay.length; i++) {
      var idx = settings.aiDisplay[i];
      var tr = settings.aoData[idx].nTr;
      if (tr) {
        firstTr = tr;
        break;
      }
    }
    if (firstTr) {
      var colSizes = $(firstTr).children("th, td").map(function(vis) {
        return {
          idx: _fnVisibleToColumnIndex(settings, vis),
          width: $(this).outerWidth()
        };
      });
      for (var i = 0; i < colSizes.length; i++) {
        var colEl = settings.aoColumns[colSizes[i].idx].colEl[0];
        var colWidth = colEl.style.width.replace("px", "");
        if (colWidth !== colSizes[i].width) {
          colEl.style.width = colSizes[i].width + "px";
          if (scroll.sX) {
            colEl.style.minWidth = colSizes[i].width + "px";
          }
        }
      }
    }
  }
  divHeaderTable.find("colgroup").remove();
  divHeaderTable.append(settings.colgroup.clone());
  if (footer) {
    divFooterTable.find("colgroup").remove();
    divFooterTable.append(settings.colgroup.clone());
  }
  $("th, td", headerCopy).each(function() {
    $(this.childNodes).wrapAll('<div class="dt-scroll-sizing">');
  });
  if (footer) {
    $("th, td", footerCopy).each(function() {
      $(this.childNodes).wrapAll('<div class="dt-scroll-sizing">');
    });
  }
  var isScrolling = Math.floor(table.height()) > divBodyEl.clientHeight || divBody.css("overflow-y") == "scroll";
  var paddingSide = "padding" + (browser.bScrollbarLeft ? "Left" : "Right");
  var outerWidth = table.outerWidth();
  divHeaderTable.css("width", _fnStringToCss(outerWidth));
  divHeaderInner.css("width", _fnStringToCss(outerWidth)).css(paddingSide, isScrolling ? barWidth + "px" : "0px");
  if (footer) {
    divFooterTable.css("width", _fnStringToCss(outerWidth));
    divFooterInner.css("width", _fnStringToCss(outerWidth)).css(paddingSide, isScrolling ? barWidth + "px" : "0px");
  }
  table.children("colgroup").prependTo(table);
  divBody.trigger("scroll");
  if ((settings.bSorted || settings.bFiltered) && !settings._drawHold) {
    divBodyEl.scrollTop = 0;
  }
}
function _fnCalculateColumnWidths(settings) {
  if (!settings.oFeatures.bAutoWidth) {
    return;
  }
  var table = settings.nTable, columns = settings.aoColumns, scroll = settings.oScroll, scrollY = scroll.sY, scrollX = scroll.sX, scrollXInner = scroll.sXInner, visibleColumns = _fnGetColumns(settings, "bVisible"), tableWidthAttr = table.getAttribute("width"), tableContainer = table.parentNode, i, column, columnIdx;
  var styleWidth = table.style.width;
  var containerWidth = _fnWrapperWidth(settings);
  if (containerWidth === settings.containerWidth) {
    return false;
  }
  settings.containerWidth = containerWidth;
  if (!styleWidth && !tableWidthAttr) {
    table.style.width = "100%";
    styleWidth = "100%";
  }
  if (styleWidth && styleWidth.indexOf("%") !== -1) {
    tableWidthAttr = styleWidth;
  }
  _fnCallbackFire(
    settings,
    null,
    "column-calc",
    { visible: visibleColumns },
    false
  );
  var tmpTable = $(table.cloneNode()).css("visibility", "hidden").removeAttr("id");
  tmpTable.append("<tbody/>");
  var tr = $("<tr/>").appendTo(tmpTable.find("tbody"));
  tmpTable.append($(settings.nTHead).clone()).append($(settings.nTFoot).clone());
  tmpTable.find("tfoot th, tfoot td").css("width", "");
  tmpTable.find("thead th, thead td").each(function() {
    var width = _fnColumnsSumWidth(settings, this, true);
    if (width) {
      this.style.width = width;
      if (scrollX) {
        this.style.minWidth = width;
        $(this).append($("<div/>").css({
          width,
          margin: 0,
          padding: 0,
          border: 0,
          height: 1
        }));
      }
    } else {
      this.style.width = "";
    }
  });
  for (i = 0; i < visibleColumns.length; i++) {
    columnIdx = visibleColumns[i];
    column = columns[columnIdx];
    var longest = _fnGetMaxLenString(settings, columnIdx);
    var autoClass = _ext.type.className[column.sType];
    var text = longest + column.sContentPadding;
    var insert = longest.indexOf("<") === -1 ? document.createTextNode(text) : text;
    $("<td/>").addClass(autoClass).addClass(column.sClass).append(insert).appendTo(tr);
  }
  $("[name]", tmpTable).removeAttr("name");
  var holder = $("<div/>").css(
    scrollX || scrollY ? {
      position: "absolute",
      top: 0,
      left: 0,
      height: 1,
      right: 0,
      overflow: "hidden"
    } : {}
  ).append(tmpTable).appendTo(tableContainer);
  if (scrollX && scrollXInner) {
    tmpTable.width(scrollXInner);
  } else if (scrollX) {
    tmpTable.css("width", "auto");
    tmpTable.removeAttr("width");
    if (tmpTable.outerWidth() < tableContainer.clientWidth && tableWidthAttr) {
      tmpTable.outerWidth(tableContainer.clientWidth);
    }
  } else if (scrollY) {
    tmpTable.outerWidth(tableContainer.clientWidth);
  } else if (tableWidthAttr) {
    tmpTable.outerWidth(tableWidthAttr);
  }
  var total = 0;
  var bodyCells = tmpTable.find("tbody tr").eq(0).children();
  for (i = 0; i < visibleColumns.length; i++) {
    var bounding = bodyCells[i].getBoundingClientRect().width;
    total += bounding;
    columns[visibleColumns[i]].sWidth = _fnStringToCss(bounding);
  }
  table.style.width = _fnStringToCss(total);
  holder.remove();
  if (tableWidthAttr) {
    table.style.width = _fnStringToCss(tableWidthAttr);
  }
  if ((tableWidthAttr || scrollX) && !settings._reszEvt) {
    var resize = DataTable.util.throttle(function() {
      var newWidth = _fnWrapperWidth(settings);
      if (!settings.bDestroying && newWidth !== 0) {
        _fnAdjustColumnSizing(settings);
      }
    });
    if (window.ResizeObserver) {
      var first = $(settings.nTableWrapper).is(":visible");
      var resizer = $("<div>").css({
        width: "100%",
        height: 0
      }).addClass("dt-autosize").appendTo(settings.nTableWrapper);
      settings.resizeObserver = new ResizeObserver(function(e) {
        if (first) {
          first = false;
        } else {
          resize();
        }
      });
      settings.resizeObserver.observe(resizer[0]);
    } else {
      $(window).on("resize.DT-" + settings.sInstance, resize);
    }
    settings._reszEvt = true;
  }
}
function _fnWrapperWidth(settings) {
  return $(settings.nTableWrapper).is(":visible") ? $(settings.nTableWrapper).width() : 0;
}
function _fnGetMaxLenString(settings, colIdx) {
  var column = settings.aoColumns[colIdx];
  if (!column.maxLenString) {
    var s, max = "", maxLen = -1;
    for (var i = 0, iLen = settings.aiDisplayMaster.length; i < iLen; i++) {
      var rowIdx = settings.aiDisplayMaster[i];
      var data = _fnGetRowDisplay(settings, rowIdx)[colIdx];
      var cellString = data && typeof data === "object" && data.nodeType ? data.innerHTML : data + "";
      cellString = cellString.replace(/id=".*?"/g, "").replace(/name=".*?"/g, "");
      s = _stripHtml(cellString).replace(/&nbsp;/g, " ");
      if (s.length > maxLen) {
        max = cellString;
        maxLen = s.length;
      }
    }
    column.maxLenString = max;
  }
  return column.maxLenString;
}
function _fnStringToCss(s) {
  if (s === null) {
    return "0px";
  }
  if (typeof s == "number") {
    return s < 0 ? "0px" : s + "px";
  }
  return s.match(/\d$/) ? s + "px" : s;
}
function _colGroup(settings) {
  var cols = settings.aoColumns;
  settings.colgroup.empty();
  for (i = 0; i < cols.length; i++) {
    if (cols[i].bVisible) {
      settings.colgroup.append(cols[i].colEl);
    }
  }
}
function _fnSortInit(settings) {
  var target = settings.nTHead;
  var headerRows = target.querySelectorAll("tr");
  var titleRow = settings.titleRow;
  var notSelector = ':not([data-dt-order="disable"]):not([data-dt-order="icon-only"])';
  if (titleRow === true) {
    target = headerRows[0];
  } else if (titleRow === false) {
    target = headerRows[headerRows.length - 1];
  } else if (titleRow !== null) {
    target = headerRows[titleRow];
  }
  if (settings.orderHandler) {
    _fnSortAttachListener(
      settings,
      target,
      target === settings.nTHead ? "tr" + notSelector + " th" + notSelector + ", tr" + notSelector + " td" + notSelector : "th" + notSelector + ", td" + notSelector
    );
  }
  var order = [];
  _fnSortResolve(settings, order, settings.aaSorting);
  settings.aaSorting = order;
}
function _fnSortAttachListener(settings, node, selector, column, callback) {
  _fnBindAction(node, selector, function(e) {
    var run = false;
    var columns = column === void 0 ? _fnColumnsFromHeader(e.target) : typeof column === "function" ? column() : Array.isArray(column) ? column : [column];
    if (columns.length) {
      for (var i = 0, iLen = columns.length; i < iLen; i++) {
        var ret = _fnSortAdd(settings, columns[i], i, e.shiftKey);
        if (ret !== false) {
          run = true;
        }
        if (settings.aaSorting.length === 1 && settings.aaSorting[0][1] === "") {
          break;
        }
      }
      if (run) {
        _fnProcessingRun(settings, true, function() {
          _fnSort(settings);
          _fnSortDisplay(settings, settings.aiDisplay);
          _fnReDraw(settings, false, false);
          if (callback) {
            callback();
          }
        });
      }
    }
  });
}
function _fnSortDisplay(settings, display) {
  if (display.length < 2) {
    return;
  }
  var master = settings.aiDisplayMaster;
  var masterMap = {};
  var map = {};
  var i;
  for (i = 0; i < master.length; i++) {
    masterMap[master[i]] = i;
  }
  for (i = 0; i < display.length; i++) {
    map[display[i]] = masterMap[display[i]];
  }
  display.sort(function(a, b) {
    return map[a] - map[b];
  });
}
function _fnSortResolve(settings, nestedSort, sort) {
  var push = function(a) {
    if ($.isPlainObject(a)) {
      if (a.idx !== void 0) {
        nestedSort.push([a.idx, a.dir]);
      } else if (a.name) {
        var cols = _pluck(settings.aoColumns, "sName");
        var idx = cols.indexOf(a.name);
        if (idx !== -1) {
          nestedSort.push([idx, a.dir]);
        }
      }
    } else {
      nestedSort.push(a);
    }
  };
  if ($.isPlainObject(sort)) {
    push(sort);
  } else if (sort.length && typeof sort[0] === "number") {
    push(sort);
  } else if (sort.length) {
    for (var z = 0; z < sort.length; z++) {
      push(sort[z]);
    }
  }
}
function _fnSortFlatten(settings) {
  var i, k, kLen, aSort = [], extSort = DataTable.ext.type.order, aoColumns = settings.aoColumns, aDataSort, iCol, sType, srcCol, fixed = settings.aaSortingFixed, fixedObj = $.isPlainObject(fixed), nestedSort = [];
  if (!settings.oFeatures.bSort) {
    return aSort;
  }
  if (Array.isArray(fixed)) {
    _fnSortResolve(settings, nestedSort, fixed);
  }
  if (fixedObj && fixed.pre) {
    _fnSortResolve(settings, nestedSort, fixed.pre);
  }
  _fnSortResolve(settings, nestedSort, settings.aaSorting);
  if (fixedObj && fixed.post) {
    _fnSortResolve(settings, nestedSort, fixed.post);
  }
  for (i = 0; i < nestedSort.length; i++) {
    srcCol = nestedSort[i][0];
    if (aoColumns[srcCol]) {
      aDataSort = aoColumns[srcCol].aDataSort;
      for (k = 0, kLen = aDataSort.length; k < kLen; k++) {
        iCol = aDataSort[k];
        sType = aoColumns[iCol].sType || "string";
        if (nestedSort[i]._idx === void 0) {
          nestedSort[i]._idx = aoColumns[iCol].asSorting.indexOf(nestedSort[i][1]);
        }
        if (nestedSort[i][1]) {
          aSort.push({
            src: srcCol,
            col: iCol,
            dir: nestedSort[i][1],
            index: nestedSort[i]._idx,
            type: sType,
            formatter: extSort[sType + "-pre"],
            sorter: extSort[sType + "-" + nestedSort[i][1]]
          });
        }
      }
    }
  }
  return aSort;
}
function _fnSort(oSettings, col, dir) {
  var i, iLen, aiOrig = [], extSort = DataTable.ext.type.order, aoData = oSettings.aoData, sortCol, displayMaster = oSettings.aiDisplayMaster, aSort;
  _fnColumnTypes(oSettings);
  if (col !== void 0) {
    var srcCol = oSettings.aoColumns[col];
    aSort = [{
      src: col,
      col,
      dir,
      index: 0,
      type: srcCol.sType,
      formatter: extSort[srcCol.sType + "-pre"],
      sorter: extSort[srcCol.sType + "-" + dir]
    }];
    displayMaster = displayMaster.slice();
  } else {
    aSort = _fnSortFlatten(oSettings);
  }
  for (i = 0, iLen = aSort.length; i < iLen; i++) {
    sortCol = aSort[i];
    _fnSortData(oSettings, sortCol.col);
  }
  if (_fnDataSource(oSettings) != "ssp" && aSort.length !== 0) {
    for (i = 0, iLen = displayMaster.length; i < iLen; i++) {
      aiOrig[i] = i;
    }
    if (aSort.length && aSort[0].dir === "desc" && oSettings.orderDescReverse) {
      aiOrig.reverse();
    }
    displayMaster.sort(function(a, b) {
      var x, y, k, test, sort, len = aSort.length, dataA = aoData[a]._aSortData, dataB = aoData[b]._aSortData;
      for (k = 0; k < len; k++) {
        sort = aSort[k];
        x = dataA[sort.col];
        y = dataB[sort.col];
        if (sort.sorter) {
          test = sort.sorter(x, y);
          if (test !== 0) {
            return test;
          }
        } else {
          test = x < y ? -1 : x > y ? 1 : 0;
          if (test !== 0) {
            return sort.dir === "asc" ? test : -test;
          }
        }
      }
      x = aiOrig[a];
      y = aiOrig[b];
      return x < y ? -1 : x > y ? 1 : 0;
    });
  } else if (aSort.length === 0) {
    displayMaster.sort(function(x, y) {
      return x < y ? -1 : x > y ? 1 : 0;
    });
  }
  if (col === void 0) {
    oSettings.bSorted = true;
    oSettings.sortDetails = aSort;
    _fnCallbackFire(oSettings, null, "order", [oSettings, aSort]);
  }
  return displayMaster;
}
function _fnSortAdd(settings, colIdx, addIndex, shift) {
  var col = settings.aoColumns[colIdx];
  var sorting = settings.aaSorting;
  var asSorting = col.asSorting;
  var nextSortIdx;
  var next = function(a, overflow) {
    var idx = a._idx;
    if (idx === void 0) {
      idx = asSorting.indexOf(a[1]);
    }
    return idx + 1 < asSorting.length ? idx + 1 : overflow ? null : 0;
  };
  if (!col.bSortable) {
    return false;
  }
  if (typeof sorting[0] === "number") {
    sorting = settings.aaSorting = [sorting];
  }
  if ((shift || addIndex) && settings.oFeatures.bSortMulti) {
    var sortIdx = _pluck(sorting, "0").indexOf(colIdx);
    if (sortIdx !== -1) {
      nextSortIdx = next(sorting[sortIdx], true);
      if (nextSortIdx === null && sorting.length === 1) {
        nextSortIdx = 0;
      }
      if (nextSortIdx === null || asSorting[nextSortIdx] === "") {
        sorting.splice(sortIdx, 1);
      } else {
        sorting[sortIdx][1] = asSorting[nextSortIdx];
        sorting[sortIdx]._idx = nextSortIdx;
      }
    } else if (shift) {
      sorting.push([colIdx, asSorting[0], 0]);
      sorting[sorting.length - 1]._idx = 0;
    } else {
      sorting.push([colIdx, sorting[0][1], 0]);
      sorting[sorting.length - 1]._idx = 0;
    }
  } else if (sorting.length && sorting[0][0] == colIdx) {
    nextSortIdx = next(sorting[0]);
    sorting.length = 1;
    sorting[0][1] = asSorting[nextSortIdx];
    sorting[0]._idx = nextSortIdx;
  } else {
    sorting.length = 0;
    sorting.push([colIdx, asSorting[0]]);
    sorting[0]._idx = 0;
  }
}
function _fnSortingClasses(settings) {
  var oldSort = settings.aLastSort;
  var sortClass = settings.oClasses.order.position;
  var sort = _fnSortFlatten(settings);
  var features = settings.oFeatures;
  var i, iLen, colIdx;
  if (features.bSort && features.bSortClasses) {
    for (i = 0, iLen = oldSort.length; i < iLen; i++) {
      colIdx = oldSort[i].src;
      $(_pluck(settings.aoData, "anCells", colIdx)).removeClass(sortClass + (i < 2 ? i + 1 : 3));
    }
    for (i = 0, iLen = sort.length; i < iLen; i++) {
      colIdx = sort[i].src;
      $(_pluck(settings.aoData, "anCells", colIdx)).addClass(sortClass + (i < 2 ? i + 1 : 3));
    }
  }
  settings.aLastSort = sort;
}
function _fnSortData(settings, colIdx) {
  var column = settings.aoColumns[colIdx];
  var customSort = DataTable.ext.order[column.sSortDataType];
  var customData;
  if (customSort) {
    customData = customSort.call(
      settings.oInstance,
      settings,
      colIdx,
      _fnColumnIndexToVisible(settings, colIdx)
    );
  }
  var row, cellData;
  var formatter = DataTable.ext.type.order[column.sType + "-pre"];
  var data = settings.aoData;
  for (var rowIdx = 0; rowIdx < data.length; rowIdx++) {
    if (!data[rowIdx]) {
      continue;
    }
    row = data[rowIdx];
    if (!row._aSortData) {
      row._aSortData = [];
    }
    if (!row._aSortData[colIdx] || customSort) {
      cellData = customSort ? customData[rowIdx] : (
        // If there was a custom sort function, use data from there
        _fnGetCellData(settings, rowIdx, colIdx, "sort")
      );
      row._aSortData[colIdx] = formatter ? formatter(cellData, settings) : cellData;
    }
  }
}
function _fnSaveState(settings) {
  if (settings._bLoadingState) {
    return;
  }
  var sorting = [];
  _fnSortResolve(settings, sorting, settings.aaSorting);
  var columns = settings.aoColumns;
  var state = {
    time: +/* @__PURE__ */ new Date(),
    start: settings._iDisplayStart,
    length: settings._iDisplayLength,
    order: sorting.map(function(sort) {
      return columns[sort[0]] && columns[sort[0]].sName ? [columns[sort[0]].sName, sort[1]] : sort.slice();
    }),
    search: $.extend({}, settings.oPreviousSearch),
    columns: settings.aoColumns.map(function(col, i) {
      return {
        name: col.sName,
        visible: col.bVisible,
        search: $.extend({}, settings.aoPreSearchCols[i])
      };
    })
  };
  settings.oSavedState = state;
  _fnCallbackFire(settings, "aoStateSaveParams", "stateSaveParams", [settings, state]);
  if (settings.oFeatures.bStateSave && !settings.bDestroying) {
    settings.fnStateSaveCallback.call(settings.oInstance, settings, state);
  }
}
function _fnLoadState(settings, init, callback) {
  if (!settings.oFeatures.bStateSave) {
    callback();
    return;
  }
  var loaded = function(state2) {
    _fnImplementState(settings, state2, callback);
  };
  var state = settings.fnStateLoadCallback.call(settings.oInstance, settings, loaded);
  if (state !== void 0) {
    _fnImplementState(settings, state, callback);
  }
  return true;
}
function _fnImplementState(settings, s, callback) {
  var i, iLen;
  var columns = settings.aoColumns;
  var currentNames = _pluck(settings.aoColumns, "sName");
  settings._bLoadingState = true;
  var api = settings._bInitComplete ? new DataTable.Api(settings) : null;
  if (!s || !s.time) {
    settings._bLoadingState = false;
    callback();
    return;
  }
  var duration = settings.iStateDuration;
  if (duration > 0 && s.time < +/* @__PURE__ */ new Date() - duration * 1e3) {
    settings._bLoadingState = false;
    callback();
    return;
  }
  var abStateLoad = _fnCallbackFire(settings, "aoStateLoadParams", "stateLoadParams", [settings, s]);
  if (abStateLoad.indexOf(false) !== -1) {
    settings._bLoadingState = false;
    callback();
    return;
  }
  settings.oLoadedState = $.extend(true, {}, s);
  _fnCallbackFire(settings, null, "stateLoadInit", [settings, s], true);
  if (s.length !== void 0) {
    if (api) {
      api.page.len(s.length);
    } else {
      settings._iDisplayLength = s.length;
    }
  }
  if (s.start !== void 0) {
    if (api === null) {
      settings._iDisplayStart = s.start;
      settings.iInitDisplayStart = s.start;
    } else {
      _fnPageChange(settings, s.start / settings._iDisplayLength);
    }
  }
  if (s.order !== void 0) {
    settings.aaSorting = [];
    $.each(s.order, function(i2, col2) {
      var set2 = [col2[0], col2[1]];
      if (typeof col2[0] === "string") {
        var idx2 = currentNames.indexOf(col2[0]);
        if (idx2 < 0) {
          return;
        }
        set2[0] = idx2;
      } else if (set2[0] >= columns.length) {
        return;
      }
      settings.aaSorting.push(set2);
    });
  }
  if (s.search !== void 0) {
    $.extend(settings.oPreviousSearch, s.search);
  }
  if (s.columns) {
    var set = s.columns;
    var incoming = _pluck(s.columns, "name");
    if (incoming.join("").length && incoming.join("") !== currentNames.join("")) {
      set = [];
      for (i = 0; i < currentNames.length; i++) {
        if (currentNames[i] != "") {
          var idx = incoming.indexOf(currentNames[i]);
          if (idx >= 0) {
            set.push(s.columns[idx]);
          } else {
            set.push({});
          }
        } else {
          set.push({});
        }
      }
    }
    if (set.length === columns.length) {
      for (i = 0, iLen = set.length; i < iLen; i++) {
        var col = set[i];
        if (col.visible !== void 0) {
          if (api) {
            api.column(i).visible(col.visible, false);
          } else {
            columns[i].bVisible = col.visible;
          }
        }
        if (col.search !== void 0) {
          $.extend(settings.aoPreSearchCols[i], col.search);
        }
      }
      if (api) {
        api.one("draw", function() {
          api.columns.adjust();
        });
      }
    }
  }
  settings._bLoadingState = false;
  _fnCallbackFire(settings, "aoStateLoaded", "stateLoaded", [settings, s]);
  callback();
}
function _fnLog(settings, level, msg, tn) {
  msg = "DataTables warning: " + (settings ? "table id=" + settings.sTableId + " - " : "") + msg;
  if (tn) {
    msg += ". For more information about this error, please see https://datatables.net/tn/" + tn;
  }
  {
    var ext = DataTable.ext;
    var type = ext.sErrMode || ext.errMode;
    if (settings) {
      _fnCallbackFire(settings, null, "dt-error", [settings, tn, msg], true);
    }
    if (type == "alert") {
      alert(msg);
    } else if (type == "throw") {
      throw new Error(msg);
    } else if (typeof type == "function") {
      type(settings, tn, msg);
    }
  }
}
function _fnMap(ret, src, name, mappedName) {
  if (Array.isArray(name)) {
    $.each(name, function(i, val) {
      if (Array.isArray(val)) {
        _fnMap(ret, src, val[0], val[1]);
      } else {
        _fnMap(ret, src, val);
      }
    });
    return;
  }
  if (mappedName === void 0) {
    mappedName = name;
  }
  if (src[name] !== void 0) {
    ret[mappedName] = src[name];
  }
}
function _fnExtend(out, extender, breakRefs) {
  var val;
  for (var prop in extender) {
    if (Object.prototype.hasOwnProperty.call(extender, prop)) {
      val = extender[prop];
      if ($.isPlainObject(val)) {
        if (!$.isPlainObject(out[prop])) {
          out[prop] = {};
        }
        $.extend(true, out[prop], val);
      } else if (breakRefs && prop !== "data" && prop !== "aaData" && Array.isArray(val)) {
        out[prop] = val.slice();
      } else {
        out[prop] = val;
      }
    }
  }
  return out;
}
function _fnBindAction(n, selector, fn) {
  $(n).on("click.DT", selector, function(e) {
    fn(e);
  }).on("keypress.DT", selector, function(e) {
    if (e.which === 13) {
      e.preventDefault();
      fn(e);
    }
  }).on("selectstart.DT", selector, function() {
    return false;
  });
}
function _fnCallbackReg(settings, store, fn) {
  if (fn) {
    settings[store].push(fn);
  }
}
function _fnCallbackFire(settings, callbackArr, eventName, args, bubbles) {
  var ret = [];
  if (callbackArr) {
    ret = settings[callbackArr].slice().reverse().map(function(val) {
      return val.apply(settings.oInstance, args);
    });
  }
  if (eventName !== null) {
    var e = $.Event(eventName + ".dt");
    var table = $(settings.nTable);
    e.dt = settings.api;
    table[bubbles ? "trigger" : "triggerHandler"](e, args);
    if (bubbles && table.parents("body").length === 0) {
      $("body").trigger(e, args);
    }
    ret.push(e.result);
  }
  return ret;
}
function _fnLengthOverflow(settings) {
  var start = settings._iDisplayStart, end = settings.fnDisplayEnd(), len = settings._iDisplayLength;
  if (start >= end) {
    start = end - len;
  }
  start -= start % len;
  if (len === -1 || start < 0) {
    start = 0;
  }
  settings._iDisplayStart = start;
}
function _fnRenderer(settings, type) {
  var renderer = settings.renderer;
  var host = DataTable.ext.renderer[type];
  if ($.isPlainObject(renderer) && renderer[type]) {
    return host[renderer[type]] || host._;
  } else if (typeof renderer === "string") {
    return host[renderer] || host._;
  }
  return host._;
}
function _fnDataSource(settings) {
  if (settings.oFeatures.bServerSide) {
    return "ssp";
  } else if (settings.ajax) {
    return "ajax";
  }
  return "dom";
}
function _fnMacros(settings, str, entries) {
  var formatter = settings.fnFormatNumber, start = settings._iDisplayStart + 1, len = settings._iDisplayLength, vis = settings.fnRecordsDisplay(), max = settings.fnRecordsTotal(), all = len === -1;
  return str.replace(/_START_/g, formatter.call(settings, start)).replace(/_END_/g, formatter.call(settings, settings.fnDisplayEnd())).replace(/_MAX_/g, formatter.call(settings, max)).replace(/_TOTAL_/g, formatter.call(settings, vis)).replace(/_PAGE_/g, formatter.call(settings, all ? 1 : Math.ceil(start / len))).replace(/_PAGES_/g, formatter.call(settings, all ? 1 : Math.ceil(vis / len))).replace(/_ENTRIES_/g, settings.api.i18n("entries", "", entries)).replace(/_ENTRIES-MAX_/g, settings.api.i18n("entries", "", max)).replace(/_ENTRIES-TOTAL_/g, settings.api.i18n("entries", "", vis));
}
function _fnArrayApply(arr, data) {
  if (!data) {
    return;
  }
  if (data.length < 1e4) {
    arr.push.apply(arr, data);
  } else {
    for (i = 0; i < data.length; i++) {
      arr.push(data[i]);
    }
  }
}
function _fnListener(that, name, src) {
  if (!Array.isArray(src)) {
    src = [src];
  }
  for (i = 0; i < src.length; i++) {
    that.on(name + ".dt", src[i]);
  }
}
function _fnEscapeObject(obj) {
  if (DataTable.ext.escape.attributes) {
    $.each(obj, function(key, val) {
      obj[key] = _escapeHtml(val);
    });
  }
  return obj;
}
var __apiStruct = [];
var __arrayProto = Array.prototype;
var _toSettings = function(mixed) {
  var idx, jq;
  var settings = DataTable.settings;
  var tables = _pluck(settings, "nTable");
  if (!mixed) {
    return [];
  } else if (mixed.nTable && mixed.oFeatures) {
    return [mixed];
  } else if (mixed.nodeName && mixed.nodeName.toLowerCase() === "table") {
    idx = tables.indexOf(mixed);
    return idx !== -1 ? [settings[idx]] : null;
  } else if (mixed && typeof mixed.settings === "function") {
    return mixed.settings().toArray();
  } else if (typeof mixed === "string") {
    jq = $(mixed).get();
  } else if (mixed instanceof $) {
    jq = mixed.get();
  }
  if (jq) {
    return settings.filter(function(v, idx2) {
      return jq.includes(tables[idx2]);
    });
  }
};
_Api = function(context, data) {
  if (!(this instanceof _Api)) {
    return new _Api(context, data);
  }
  var i;
  var settings = [];
  var ctxSettings = function(o) {
    var a = _toSettings(o);
    if (a) {
      settings.push.apply(settings, a);
    }
  };
  if (Array.isArray(context)) {
    for (i = 0; i < context.length; i++) {
      ctxSettings(context[i]);
    }
  } else {
    ctxSettings(context);
  }
  this.context = settings.length > 1 ? _unique(settings) : settings;
  _fnArrayApply(this, data);
  this.selector = {
    rows: null,
    cols: null,
    opts: null
  };
  _Api.extend(this, this, __apiStruct);
};
DataTable.Api = _Api;
$.extend(_Api.prototype, {
  any: function() {
    return this.count() !== 0;
  },
  context: [],
  // array of table settings objects
  count: function() {
    return this.flatten().length;
  },
  each: function(fn) {
    for (var i = 0, iLen = this.length; i < iLen; i++) {
      fn.call(this, this[i], i, this);
    }
    return this;
  },
  eq: function(idx) {
    var ctx = this.context;
    return ctx.length > idx ? new _Api(ctx[idx], this[idx]) : null;
  },
  filter: function(fn) {
    var a = __arrayProto.filter.call(this, fn, this);
    return new _Api(this.context, a);
  },
  flatten: function() {
    var a = [];
    return new _Api(this.context, a.concat.apply(a, this.toArray()));
  },
  get: function(idx) {
    return this[idx];
  },
  join: __arrayProto.join,
  includes: function(find) {
    return this.indexOf(find) === -1 ? false : true;
  },
  indexOf: __arrayProto.indexOf,
  iterator: function(flatten, type, fn, alwaysNew) {
    var a = [], ret, i, iLen, j, jen, context = this.context, rows, items, item, selector = this.selector;
    if (typeof flatten === "string") {
      alwaysNew = fn;
      fn = type;
      type = flatten;
      flatten = false;
    }
    for (i = 0, iLen = context.length; i < iLen; i++) {
      var apiInst = new _Api(context[i]);
      if (type === "table") {
        ret = fn.call(apiInst, context[i], i);
        if (ret !== void 0) {
          a.push(ret);
        }
      } else if (type === "columns" || type === "rows") {
        ret = fn.call(apiInst, context[i], this[i], i);
        if (ret !== void 0) {
          a.push(ret);
        }
      } else if (type === "every" || type === "column" || type === "column-rows" || type === "row" || type === "cell") {
        items = this[i];
        if (type === "column-rows") {
          rows = _selector_row_indexes(context[i], selector.opts);
        }
        for (j = 0, jen = items.length; j < jen; j++) {
          item = items[j];
          if (type === "cell") {
            ret = fn.call(apiInst, context[i], item.row, item.column, i, j);
          } else {
            ret = fn.call(apiInst, context[i], item, i, j, rows);
          }
          if (ret !== void 0) {
            a.push(ret);
          }
        }
      }
    }
    if (a.length || alwaysNew) {
      var api = new _Api(context, flatten ? a.concat.apply([], a) : a);
      var apiSelector = api.selector;
      apiSelector.rows = selector.rows;
      apiSelector.cols = selector.cols;
      apiSelector.opts = selector.opts;
      return api;
    }
    return this;
  },
  lastIndexOf: __arrayProto.lastIndexOf,
  length: 0,
  map: function(fn) {
    var a = __arrayProto.map.call(this, fn, this);
    return new _Api(this.context, a);
  },
  pluck: function(prop) {
    var fn = DataTable.util.get(prop);
    return this.map(function(el) {
      return fn(el);
    });
  },
  pop: __arrayProto.pop,
  push: __arrayProto.push,
  reduce: __arrayProto.reduce,
  reduceRight: __arrayProto.reduceRight,
  reverse: __arrayProto.reverse,
  // Object with rows, columns and opts
  selector: null,
  shift: __arrayProto.shift,
  slice: function() {
    return new _Api(this.context, this);
  },
  sort: __arrayProto.sort,
  splice: __arrayProto.splice,
  toArray: function() {
    return __arrayProto.slice.call(this);
  },
  to$: function() {
    return $(this);
  },
  toJQuery: function() {
    return $(this);
  },
  unique: function() {
    return new _Api(this.context, _unique(this.toArray()));
  },
  unshift: __arrayProto.unshift
});
function _api_scope(scope, fn, struct) {
  return function() {
    var ret = fn.apply(scope || this, arguments);
    _Api.extend(ret, ret, struct.methodExt);
    return ret;
  };
}
function _api_find(src, name) {
  for (var i = 0, iLen = src.length; i < iLen; i++) {
    if (src[i].name === name) {
      return src[i];
    }
  }
  return null;
}
window.__apiStruct = __apiStruct;
_Api.extend = function(scope, obj, ext) {
  if (!ext.length || !obj || !(obj instanceof _Api) && !obj.__dt_wrapper) {
    return;
  }
  var i, iLen, struct;
  for (i = 0, iLen = ext.length; i < iLen; i++) {
    struct = ext[i];
    if (struct.name === "__proto__") {
      continue;
    }
    obj[struct.name] = struct.type === "function" ? _api_scope(scope, struct.val, struct) : struct.type === "object" ? {} : struct.val;
    obj[struct.name].__dt_wrapper = true;
    _Api.extend(scope, obj[struct.name], struct.propExt);
  }
};
_Api.register = _api_register = function(name, val) {
  if (Array.isArray(name)) {
    for (var j = 0, jen = name.length; j < jen; j++) {
      _Api.register(name[j], val);
    }
    return;
  }
  var i, iLen, heir = name.split("."), struct = __apiStruct, key, method;
  for (i = 0, iLen = heir.length; i < iLen; i++) {
    method = heir[i].indexOf("()") !== -1;
    key = method ? heir[i].replace("()", "") : heir[i];
    var src = _api_find(struct, key);
    if (!src) {
      src = {
        name: key,
        val: {},
        methodExt: [],
        propExt: [],
        type: "object"
      };
      struct.push(src);
    }
    if (i === iLen - 1) {
      src.val = val;
      src.type = typeof val === "function" ? "function" : $.isPlainObject(val) ? "object" : "other";
    } else {
      struct = method ? src.methodExt : src.propExt;
    }
  }
};
_Api.registerPlural = _api_registerPlural = function(pluralName, singularName, val) {
  _Api.register(pluralName, val);
  _Api.register(singularName, function() {
    var ret = val.apply(this, arguments);
    if (ret === this) {
      return this;
    } else if (ret instanceof _Api) {
      return ret.length ? Array.isArray(ret[0]) ? new _Api(ret.context, ret[0]) : (
        // Array results are 'enhanced'
        ret[0]
      ) : void 0;
    }
    return ret;
  });
};
var __table_selector = function(selector, a) {
  if (Array.isArray(selector)) {
    var result = [];
    selector.forEach(function(sel) {
      var inner = __table_selector(sel, a);
      _fnArrayApply(result, inner);
    });
    return result.filter(function(item) {
      return item;
    });
  }
  if (typeof selector === "number") {
    return [a[selector]];
  }
  var nodes = a.map(function(el) {
    return el.nTable;
  });
  return $(nodes).filter(selector).map(function() {
    var idx = nodes.indexOf(this);
    return a[idx];
  }).toArray();
};
_api_register("tables()", function(selector) {
  return selector !== void 0 && selector !== null ? new _Api(__table_selector(selector, this.context)) : this;
});
_api_register("table()", function(selector) {
  var tables = this.tables(selector);
  var ctx = tables.context;
  return ctx.length ? new _Api(ctx[0]) : tables;
});
[
  ["nodes", "node", "nTable"],
  ["body", "body", "nTBody"],
  ["header", "header", "nTHead"],
  ["footer", "footer", "nTFoot"]
].forEach(function(item) {
  _api_registerPlural(
    "tables()." + item[0] + "()",
    "table()." + item[1] + "()",
    function() {
      return this.iterator("table", function(ctx) {
        return ctx[item[2]];
      }, 1);
    }
  );
});
[
  ["header", "aoHeader"],
  ["footer", "aoFooter"]
].forEach(function(item) {
  _api_register("table()." + item[0] + ".structure()", function(selector) {
    var indexes = this.columns(selector).indexes().flatten().toArray();
    var ctx = this.context[0];
    var structure = _fnHeaderLayout(ctx, ctx[item[1]], indexes);
    var orderedIndexes = indexes.slice().sort(function(a, b) {
      return a - b;
    });
    return structure.map(function(row) {
      return indexes.map(function(colIdx) {
        return row[orderedIndexes.indexOf(colIdx)];
      });
    });
  });
});
_api_registerPlural("tables().containers()", "table().container()", function() {
  return this.iterator("table", function(ctx) {
    return ctx.nTableWrapper;
  }, 1);
});
_api_register("tables().every()", function(fn) {
  var that = this;
  return this.iterator("table", function(s, i) {
    fn.call(that.table(i), i);
  });
});
_api_register("caption()", function(value, side) {
  var context = this.context;
  if (value === void 0) {
    var caption = context[0].captionNode;
    return caption && context.length ? caption.innerHTML : null;
  }
  return this.iterator("table", function(ctx) {
    var table = $(ctx.nTable);
    var caption2 = $(ctx.captionNode);
    var container = $(ctx.nTableWrapper);
    if (!caption2.length) {
      caption2 = $("<caption/>").html(value);
      ctx.captionNode = caption2[0];
      if (!side) {
        table.prepend(caption2);
        side = caption2.css("caption-side");
      }
    }
    caption2.html(value);
    if (side) {
      caption2.css("caption-side", side);
      caption2[0]._captionSide = side;
    }
    if (container.find("div.dataTables_scroll").length) {
      var selector = side === "top" ? "Head" : "Foot";
      container.find("div.dataTables_scroll" + selector + " table").prepend(caption2);
    } else {
      table.prepend(caption2);
    }
  }, 1);
});
_api_register("caption.node()", function() {
  var ctx = this.context;
  return ctx.length ? ctx[0].captionNode : null;
});
_api_register("draw()", function(paging) {
  return this.iterator("table", function(settings) {
    if (paging === "page") {
      _fnDraw(settings);
    } else {
      if (typeof paging === "string") {
        paging = paging === "full-hold" ? false : true;
      }
      _fnReDraw(settings, paging === false);
    }
  });
});
_api_register("page()", function(action) {
  if (action === void 0) {
    return this.page.info().page;
  }
  return this.iterator("table", function(settings) {
    _fnPageChange(settings, action);
  });
});
_api_register("page.info()", function() {
  if (this.context.length === 0) {
    return void 0;
  }
  var settings = this.context[0], start = settings._iDisplayStart, len = settings.oFeatures.bPaginate ? settings._iDisplayLength : -1, visRecords = settings.fnRecordsDisplay(), all = len === -1;
  return {
    "page": all ? 0 : Math.floor(start / len),
    "pages": all ? 1 : Math.ceil(visRecords / len),
    "start": start,
    "end": settings.fnDisplayEnd(),
    "length": len,
    "recordsTotal": settings.fnRecordsTotal(),
    "recordsDisplay": visRecords,
    "serverSide": _fnDataSource(settings) === "ssp"
  };
});
_api_register("page.len()", function(len) {
  if (len === void 0) {
    return this.context.length !== 0 ? this.context[0]._iDisplayLength : void 0;
  }
  return this.iterator("table", function(settings) {
    _fnLengthChange(settings, len);
  });
});
var __reload = function(settings, holdPosition, callback) {
  if (callback) {
    var api = new _Api(settings);
    api.one("draw", function() {
      callback(api.ajax.json());
    });
  }
  if (_fnDataSource(settings) == "ssp") {
    _fnReDraw(settings, holdPosition);
  } else {
    _fnProcessingDisplay(settings, true);
    var xhr = settings.jqXHR;
    if (xhr && xhr.readyState !== 4) {
      xhr.abort();
    }
    _fnBuildAjax(settings, {}, function(json) {
      _fnClearTable(settings);
      var data = _fnAjaxDataSrc(settings, json);
      for (var i = 0, iLen = data.length; i < iLen; i++) {
        _fnAddData(settings, data[i]);
      }
      _fnReDraw(settings, holdPosition);
      _fnInitComplete(settings);
      _fnProcessingDisplay(settings, false);
    });
  }
};
_api_register("ajax.json()", function() {
  var ctx = this.context;
  if (ctx.length > 0) {
    return ctx[0].json;
  }
});
_api_register("ajax.params()", function() {
  var ctx = this.context;
  if (ctx.length > 0) {
    return ctx[0].oAjaxData;
  }
});
_api_register("ajax.reload()", function(callback, resetPaging) {
  return this.iterator("table", function(settings) {
    __reload(settings, resetPaging === false, callback);
  });
});
_api_register("ajax.url()", function(url) {
  var ctx = this.context;
  if (url === void 0) {
    if (ctx.length === 0) {
      return void 0;
    }
    ctx = ctx[0];
    return $.isPlainObject(ctx.ajax) ? ctx.ajax.url : ctx.ajax;
  }
  return this.iterator("table", function(settings) {
    if ($.isPlainObject(settings.ajax)) {
      settings.ajax.url = url;
    } else {
      settings.ajax = url;
    }
  });
});
_api_register("ajax.url().load()", function(callback, resetPaging) {
  return this.iterator("table", function(ctx) {
    __reload(ctx, resetPaging === false, callback);
  });
});
var _selector_run = function(type, selector, selectFn, settings, opts) {
  var out = [], res, i, iLen, selectorType = typeof selector;
  if (!selector || selectorType === "string" || selectorType === "function" || selector.length === void 0) {
    selector = [selector];
  }
  for (i = 0, iLen = selector.length; i < iLen; i++) {
    res = selectFn(typeof selector[i] === "string" ? selector[i].trim() : selector[i]);
    res = res.filter(function(item) {
      return item !== null && item !== void 0;
    });
    if (res && res.length) {
      out = out.concat(res);
    }
  }
  var ext = _ext.selector[type];
  if (ext.length) {
    for (i = 0, iLen = ext.length; i < iLen; i++) {
      out = ext[i](settings, opts, out);
    }
  }
  return _unique(out);
};
var _selector_opts = function(opts) {
  if (!opts) {
    opts = {};
  }
  if (opts.filter && opts.search === void 0) {
    opts.search = opts.filter;
  }
  return $.extend({
    columnOrder: "implied",
    search: "none",
    order: "current",
    page: "all"
  }, opts);
};
var _selector_first = function(old) {
  var inst = new _Api(old.context[0]);
  if (old.length) {
    inst.push(old[0]);
  }
  inst.selector = old.selector;
  if (inst.length && inst[0].length > 1) {
    inst[0].splice(1);
  }
  return inst;
};
var _selector_row_indexes = function(settings, opts) {
  var i, iLen, tmp, a = [], displayFiltered = settings.aiDisplay, displayMaster = settings.aiDisplayMaster;
  var search = opts.search, order = opts.order, page = opts.page;
  if (_fnDataSource(settings) == "ssp") {
    return search === "removed" ? [] : _range(0, displayMaster.length);
  }
  if (page == "current") {
    for (i = settings._iDisplayStart, iLen = settings.fnDisplayEnd(); i < iLen; i++) {
      a.push(displayFiltered[i]);
    }
  } else if (order == "current" || order == "applied") {
    if (search == "none") {
      a = displayMaster.slice();
    } else if (search == "applied") {
      a = displayFiltered.slice();
    } else if (search == "removed") {
      var displayFilteredMap = {};
      for (i = 0, iLen = displayFiltered.length; i < iLen; i++) {
        displayFilteredMap[displayFiltered[i]] = null;
      }
      displayMaster.forEach(function(item) {
        if (!Object.prototype.hasOwnProperty.call(displayFilteredMap, item)) {
          a.push(item);
        }
      });
    }
  } else if (order == "index" || order == "original") {
    for (i = 0, iLen = settings.aoData.length; i < iLen; i++) {
      if (!settings.aoData[i]) {
        continue;
      }
      if (search == "none") {
        a.push(i);
      } else {
        tmp = displayFiltered.indexOf(i);
        if (tmp === -1 && search == "removed" || tmp >= 0 && search == "applied") {
          a.push(i);
        }
      }
    }
  } else if (typeof order === "number") {
    var ordered = _fnSort(settings, order, "asc");
    if (search === "none") {
      a = ordered;
    } else {
      for (i = 0; i < ordered.length; i++) {
        tmp = displayFiltered.indexOf(ordered[i]);
        if (tmp === -1 && search == "removed" || tmp >= 0 && search == "applied") {
          a.push(ordered[i]);
        }
      }
    }
  }
  return a;
};
var __row_selector = function(settings, selector, opts) {
  var rows;
  var run = function(sel) {
    var selInt = _intVal(sel);
    var aoData = settings.aoData;
    if (selInt !== null && !opts) {
      return [selInt];
    }
    if (!rows) {
      rows = _selector_row_indexes(settings, opts);
    }
    if (selInt !== null && rows.indexOf(selInt) !== -1) {
      return [selInt];
    } else if (sel === null || sel === void 0 || sel === "") {
      return rows;
    }
    if (typeof sel === "function") {
      return rows.map(function(idx) {
        var row = aoData[idx];
        return sel(idx, row._aData, row.nTr) ? idx : null;
      });
    }
    if (sel.nodeName) {
      var rowIdx = sel._DT_RowIndex;
      var cellIdx = sel._DT_CellIndex;
      if (rowIdx !== void 0) {
        return aoData[rowIdx] && aoData[rowIdx].nTr === sel ? [rowIdx] : [];
      } else if (cellIdx) {
        return aoData[cellIdx.row] && aoData[cellIdx.row].nTr === sel.parentNode ? [cellIdx.row] : [];
      } else {
        var host = $(sel).closest("*[data-dt-row]");
        return host.length ? [host.data("dt-row")] : [];
      }
    }
    if (typeof sel === "string" && sel.charAt(0) === "#") {
      var rowObj = settings.aIds[sel.replace(/^#/, "")];
      if (rowObj !== void 0) {
        return [rowObj.idx];
      }
    }
    var nodes = _removeEmpty(
      _pluck_order(settings.aoData, rows, "nTr")
    );
    return $(nodes).filter(sel).map(function() {
      return this._DT_RowIndex;
    }).toArray();
  };
  var matched = _selector_run("row", selector, run, settings, opts);
  if (opts.order === "current" || opts.order === "applied") {
    _fnSortDisplay(settings, matched);
  }
  return matched;
};
_api_register("rows()", function(selector, opts) {
  if (selector === void 0) {
    selector = "";
  } else if ($.isPlainObject(selector)) {
    opts = selector;
    selector = "";
  }
  opts = _selector_opts(opts);
  var inst = this.iterator("table", function(settings) {
    return __row_selector(settings, selector, opts);
  }, 1);
  inst.selector.rows = selector;
  inst.selector.opts = opts;
  return inst;
});
_api_register("rows().nodes()", function() {
  return this.iterator("row", function(settings, row) {
    return settings.aoData[row].nTr || void 0;
  }, 1);
});
_api_register("rows().data()", function() {
  return this.iterator(true, "rows", function(settings, rows) {
    return _pluck_order(settings.aoData, rows, "_aData");
  }, 1);
});
_api_registerPlural("rows().cache()", "row().cache()", function(type) {
  return this.iterator("row", function(settings, row) {
    var r = settings.aoData[row];
    return type === "search" ? r._aFilterData : r._aSortData;
  }, 1);
});
_api_registerPlural("rows().invalidate()", "row().invalidate()", function(src) {
  return this.iterator("row", function(settings, row) {
    _fnInvalidate(settings, row, src);
  });
});
_api_registerPlural("rows().indexes()", "row().index()", function() {
  return this.iterator("row", function(settings, row) {
    return row;
  }, 1);
});
_api_registerPlural("rows().ids()", "row().id()", function(hash) {
  var a = [];
  var context = this.context;
  for (var i = 0, iLen = context.length; i < iLen; i++) {
    for (var j = 0, jen = this[i].length; j < jen; j++) {
      var id = context[i].rowIdFn(context[i].aoData[this[i][j]]._aData);
      a.push((hash === true ? "#" : "") + id);
    }
  }
  return new _Api(context, a);
});
_api_registerPlural("rows().remove()", "row().remove()", function() {
  this.iterator("row", function(settings, row) {
    var data = settings.aoData;
    var rowData = data[row];
    var idx = settings.aiDisplayMaster.indexOf(row);
    if (idx !== -1) {
      settings.aiDisplayMaster.splice(idx, 1);
    }
    if (settings._iRecordsDisplay > 0) {
      settings._iRecordsDisplay--;
    }
    _fnLengthOverflow(settings);
    var id = settings.rowIdFn(rowData._aData);
    if (id !== void 0) {
      delete settings.aIds[id];
    }
    data[row] = null;
  });
  return this;
});
_api_register("rows.add()", function(rows) {
  var newRows = this.iterator("table", function(settings) {
    var row, i, iLen;
    var out = [];
    for (i = 0, iLen = rows.length; i < iLen; i++) {
      row = rows[i];
      if (row.nodeName && row.nodeName.toUpperCase() === "TR") {
        out.push(_fnAddTr(settings, row)[0]);
      } else {
        out.push(_fnAddData(settings, row));
      }
    }
    return out;
  }, 1);
  var modRows = this.rows(-1);
  modRows.pop();
  _fnArrayApply(modRows, newRows);
  return modRows;
});
_api_register("row()", function(selector, opts) {
  return _selector_first(this.rows(selector, opts));
});
_api_register("row().data()", function(data) {
  var ctx = this.context;
  if (data === void 0) {
    return ctx.length && this.length && this[0].length ? ctx[0].aoData[this[0]]._aData : void 0;
  }
  var row = ctx[0].aoData[this[0]];
  row._aData = data;
  if (Array.isArray(data) && row.nTr && row.nTr.id) {
    _fnSetObjectDataFn(ctx[0].rowId)(data, row.nTr.id);
  }
  _fnInvalidate(ctx[0], this[0], "data");
  return this;
});
_api_register("row().node()", function() {
  var ctx = this.context;
  if (ctx.length && this.length && this[0].length) {
    var row = ctx[0].aoData[this[0]];
    if (row && row.nTr) {
      return row.nTr;
    }
  }
  return null;
});
_api_register("row.add()", function(row) {
  if (row instanceof $ && row.length) {
    row = row[0];
  }
  var rows = this.iterator("table", function(settings) {
    if (row.nodeName && row.nodeName.toUpperCase() === "TR") {
      return _fnAddTr(settings, row)[0];
    }
    return _fnAddData(settings, row);
  });
  return this.row(rows[0]);
});
$(document).on("plugin-init.dt", function(e, context) {
  var api = new _Api(context);
  api.on("stateSaveParams.DT", function(e2, settings, d) {
    var idFn = settings.rowIdFn;
    var rows = settings.aiDisplayMaster;
    var ids = [];
    for (var i = 0; i < rows.length; i++) {
      var rowIdx = rows[i];
      var data = settings.aoData[rowIdx];
      if (data._detailsShow) {
        ids.push("#" + idFn(data._aData));
      }
    }
    d.childRows = ids;
  });
  api.on("stateLoaded.DT", function(e2, settings, state) {
    __details_state_load(api, state);
  });
  __details_state_load(api, api.state.loaded());
});
var __details_state_load = function(api, state) {
  if (state && state.childRows) {
    api.rows(state.childRows.map(function(id) {
      return id.replace(/([^:\\]*(?:\\.[^:\\]*)*):/g, "$1\\:");
    })).every(function() {
      _fnCallbackFire(api.settings()[0], null, "requestChild", [this]);
    });
  }
};
var __details_add = function(ctx, row, data, klass) {
  var rows = [];
  var addRow = function(r, k) {
    if (Array.isArray(r) || r instanceof $) {
      for (var i = 0, iLen = r.length; i < iLen; i++) {
        addRow(r[i], k);
      }
      return;
    }
    if (r.nodeName && r.nodeName.toLowerCase() === "tr") {
      r.setAttribute("data-dt-row", row.idx);
      rows.push(r);
    } else {
      var created = $("<tr><td></td></tr>").attr("data-dt-row", row.idx).addClass(k);
      $("td", created).addClass(k).html(r)[0].colSpan = _fnVisibleColumns(ctx);
      rows.push(created[0]);
    }
  };
  addRow(data, klass);
  if (row._details) {
    row._details.detach();
  }
  row._details = $(rows);
  if (row._detailsShow) {
    row._details.insertAfter(row.nTr);
  }
};
var __details_state = DataTable.util.throttle(
  function(ctx) {
    _fnSaveState(ctx[0]);
  },
  500
);
var __details_remove = function(api, idx) {
  var ctx = api.context;
  if (ctx.length) {
    var row = ctx[0].aoData[idx !== void 0 ? idx : api[0]];
    if (row && row._details) {
      row._details.detach();
      row._detailsShow = void 0;
      row._details = void 0;
      $(row.nTr).removeClass("dt-hasChild");
      __details_state(ctx);
    }
  }
};
var __details_display = function(api, show) {
  var ctx = api.context;
  if (ctx.length && api.length) {
    var row = ctx[0].aoData[api[0]];
    if (row._details) {
      row._detailsShow = show;
      if (show) {
        row._details.insertAfter(row.nTr);
        $(row.nTr).addClass("dt-hasChild");
      } else {
        row._details.detach();
        $(row.nTr).removeClass("dt-hasChild");
      }
      _fnCallbackFire(ctx[0], null, "childRow", [show, api.row(api[0])]);
      __details_events(ctx[0]);
      __details_state(ctx);
    }
  }
};
var __details_events = function(settings) {
  var api = new _Api(settings);
  var namespace = ".dt.DT_details";
  var drawEvent = "draw" + namespace;
  var colvisEvent = "column-sizing" + namespace;
  var destroyEvent = "destroy" + namespace;
  var data = settings.aoData;
  api.off(drawEvent + " " + colvisEvent + " " + destroyEvent);
  if (_pluck(data, "_details").length > 0) {
    api.on(drawEvent, function(e, ctx) {
      if (settings !== ctx) {
        return;
      }
      api.rows({ page: "current" }).eq(0).each(function(idx) {
        var row = data[idx];
        if (row._detailsShow) {
          row._details.insertAfter(row.nTr);
        }
      });
    });
    api.on(colvisEvent, function(e, ctx) {
      if (settings !== ctx) {
        return;
      }
      var row, visible = _fnVisibleColumns(ctx);
      for (var i = 0, iLen = data.length; i < iLen; i++) {
        row = data[i];
        if (row && row._details) {
          row._details.each(function() {
            var el = $(this).children("td");
            if (el.length == 1) {
              el.attr("colspan", visible);
            }
          });
        }
      }
    });
    api.on(destroyEvent, function(e, ctx) {
      if (settings !== ctx) {
        return;
      }
      for (var i = 0, iLen = data.length; i < iLen; i++) {
        if (data[i] && data[i]._details) {
          __details_remove(api, i);
        }
      }
    });
  }
};
var _emp = "";
var _child_obj = _emp + "row().child";
var _child_mth = _child_obj + "()";
_api_register(_child_mth, function(data, klass) {
  var ctx = this.context;
  if (data === void 0) {
    return ctx.length && this.length && ctx[0].aoData[this[0]] ? ctx[0].aoData[this[0]]._details : void 0;
  } else if (data === true) {
    this.child.show();
  } else if (data === false) {
    __details_remove(this);
  } else if (ctx.length && this.length) {
    __details_add(ctx[0], ctx[0].aoData[this[0]], data, klass);
  }
  return this;
});
_api_register([
  _child_obj + ".show()",
  _child_mth + ".show()"
  // only when `child()` was called with parameters (without
], function() {
  __details_display(this, true);
  return this;
});
_api_register([
  _child_obj + ".hide()",
  _child_mth + ".hide()"
  // only when `child()` was called with parameters (without
], function() {
  __details_display(this, false);
  return this;
});
_api_register([
  _child_obj + ".remove()",
  _child_mth + ".remove()"
  // only when `child()` was called with parameters (without
], function() {
  __details_remove(this);
  return this;
});
_api_register(_child_obj + ".isShown()", function() {
  var ctx = this.context;
  if (ctx.length && this.length && ctx[0].aoData[this[0]]) {
    return ctx[0].aoData[this[0]]._detailsShow || false;
  }
  return false;
});
var __re_column_selector = /^([^:]+)?:(name|title|visIdx|visible)$/;
var __columnData = function(settings, column, r1, r2, rows, type) {
  var a = [];
  for (var row = 0, iLen = rows.length; row < iLen; row++) {
    a.push(_fnGetCellData(settings, rows[row], column, type));
  }
  return a;
};
var __column_header = function(settings, column, row) {
  var header = settings.aoHeader;
  var titleRow = settings.titleRow;
  var target = null;
  if (row !== void 0) {
    target = row;
  } else if (titleRow === true) {
    target = 0;
  } else if (titleRow === false) {
    target = header.length - 1;
  } else if (titleRow !== null) {
    target = titleRow;
  } else {
    for (var i = 0; i < header.length; i++) {
      if (header[i][column].unique && $("span.dt-column-title", header[i][column].cell).text()) {
        target = i;
      }
    }
    if (target === null) {
      target = 0;
    }
  }
  return header[target][column].cell;
};
var __column_header_cells = function(header) {
  var out = [];
  for (var i = 0; i < header.length; i++) {
    for (var j = 0; j < header[i].length; j++) {
      var cell = header[i][j].cell;
      if (!out.includes(cell)) {
        out.push(cell);
      }
    }
  }
  return out;
};
var __column_selector = function(settings, selector, opts) {
  var columns = settings.aoColumns, names, titles, nodes = __column_header_cells(settings.aoHeader);
  var run = function(s) {
    var selInt = _intVal(s);
    if (s === "") {
      return _range(columns.length);
    }
    if (selInt !== null) {
      return [
        selInt >= 0 ? selInt : (
          // Count from left
          columns.length + selInt
        )
        // Count from right (+ because its a negative value)
      ];
    }
    if (typeof s === "function") {
      var rows = _selector_row_indexes(settings, opts);
      return columns.map(function(col, idx2) {
        return s(
          idx2,
          __columnData(settings, idx2, 0, 0, rows),
          __column_header(settings, idx2)
        ) ? idx2 : null;
      });
    }
    var match = typeof s === "string" ? s.match(__re_column_selector) : "";
    if (match) {
      switch (match[2]) {
        case "visIdx":
        case "visible":
          if (match[1] && match[1].match(/^\d+$/)) {
            var idx = parseInt(match[1], 10);
            if (idx < 0) {
              var visColumns = columns.map(function(col, i) {
                return col.bVisible ? i : null;
              });
              return [visColumns[visColumns.length + idx]];
            }
            return [_fnVisibleToColumnIndex(settings, idx)];
          }
          return columns.map(function(col, idx2) {
            if (!col.bVisible) {
              return null;
            }
            if (match[1]) {
              return $(nodes[idx2]).filter(match[1]).length > 0 ? idx2 : null;
            }
            return idx2;
          });
        case "name":
          if (!names) {
            names = _pluck(columns, "sName");
          }
          return names.map(function(name, i) {
            return name === match[1] ? i : null;
          });
        case "title":
          if (!titles) {
            titles = _pluck(columns, "sTitle");
          }
          return titles.map(function(title, i) {
            return title === match[1] ? i : null;
          });
        default:
          return [];
      }
    }
    if (s.nodeName && s._DT_CellIndex) {
      return [s._DT_CellIndex.column];
    }
    var jqResult = $(nodes).filter(s).map(function() {
      return _fnColumnsFromHeader(this);
    }).toArray().sort(function(a, b) {
      return a - b;
    });
    if (jqResult.length || !s.nodeName) {
      return jqResult;
    }
    var host = $(s).closest("*[data-dt-column]");
    return host.length ? [host.data("dt-column")] : [];
  };
  var selected = _selector_run("column", selector, run, settings, opts);
  return opts.columnOrder && opts.columnOrder === "index" ? selected.sort(function(a, b) {
    return a - b;
  }) : selected;
};
var __setColumnVis = function(settings, column, vis) {
  var cols = settings.aoColumns, col = cols[column], data = settings.aoData, cells, i, iLen, tr;
  if (vis === void 0) {
    return col.bVisible;
  }
  if (col.bVisible === vis) {
    return false;
  }
  if (vis) {
    var insertBefore = _pluck(cols, "bVisible").indexOf(true, column + 1);
    for (i = 0, iLen = data.length; i < iLen; i++) {
      if (data[i]) {
        tr = data[i].nTr;
        cells = data[i].anCells;
        if (tr) {
          tr.insertBefore(cells[column], cells[insertBefore] || null);
        }
      }
    }
  } else {
    $(_pluck(settings.aoData, "anCells", column)).detach();
  }
  col.bVisible = vis;
  _colGroup(settings);
  return true;
};
_api_register("columns()", function(selector, opts) {
  if (selector === void 0) {
    selector = "";
  } else if ($.isPlainObject(selector)) {
    opts = selector;
    selector = "";
  }
  opts = _selector_opts(opts);
  var inst = this.iterator("table", function(settings) {
    return __column_selector(settings, selector, opts);
  }, 1);
  inst.selector.cols = selector;
  inst.selector.opts = opts;
  return inst;
});
_api_registerPlural("columns().header()", "column().header()", function(row) {
  return this.iterator("column", function(settings, column) {
    return __column_header(settings, column, row);
  }, 1);
});
_api_registerPlural("columns().footer()", "column().footer()", function(row) {
  return this.iterator("column", function(settings, column) {
    var footer = settings.aoFooter;
    if (!footer.length) {
      return null;
    }
    return settings.aoFooter[row !== void 0 ? row : 0][column].cell;
  }, 1);
});
_api_registerPlural("columns().data()", "column().data()", function() {
  return this.iterator("column-rows", __columnData, 1);
});
_api_registerPlural("columns().render()", "column().render()", function(type) {
  return this.iterator("column-rows", function(settings, column, i, j, rows) {
    return __columnData(settings, column, i, j, rows, type);
  }, 1);
});
_api_registerPlural("columns().dataSrc()", "column().dataSrc()", function() {
  return this.iterator("column", function(settings, column) {
    return settings.aoColumns[column].mData;
  }, 1);
});
_api_registerPlural("columns().cache()", "column().cache()", function(type) {
  return this.iterator("column-rows", function(settings, column, i, j, rows) {
    return _pluck_order(
      settings.aoData,
      rows,
      type === "search" ? "_aFilterData" : "_aSortData",
      column
    );
  }, 1);
});
_api_registerPlural("columns().init()", "column().init()", function() {
  return this.iterator("column", function(settings, column) {
    return settings.aoColumns[column];
  }, 1);
});
_api_registerPlural("columns().names()", "column().name()", function() {
  return this.iterator("column", function(settings, column) {
    return settings.aoColumns[column].sName;
  }, 1);
});
_api_registerPlural("columns().nodes()", "column().nodes()", function() {
  return this.iterator("column-rows", function(settings, column, i, j, rows) {
    return _pluck_order(settings.aoData, rows, "anCells", column);
  }, 1);
});
_api_registerPlural("columns().titles()", "column().title()", function(title, row) {
  return this.iterator("column", function(settings, column) {
    if (typeof title === "number") {
      row = title;
      title = void 0;
    }
    var span = $("span.dt-column-title", this.column(column).header(row));
    if (title !== void 0) {
      span.html(title);
      return this;
    }
    return span.html();
  }, 1);
});
_api_registerPlural("columns().types()", "column().type()", function() {
  return this.iterator("column", function(settings, column) {
    var type = settings.aoColumns[column].sType;
    if (!type) {
      _fnColumnTypes(settings);
    }
    return type;
  }, 1);
});
_api_registerPlural("columns().visible()", "column().visible()", function(vis, calc) {
  var that = this;
  var changed = [];
  var ret = this.iterator("column", function(settings, column) {
    if (vis === void 0) {
      return settings.aoColumns[column].bVisible;
    }
    if (__setColumnVis(settings, column, vis)) {
      changed.push(column);
    }
  });
  if (vis !== void 0) {
    this.iterator("table", function(settings) {
      _fnDrawHead(settings, settings.aoHeader);
      _fnDrawHead(settings, settings.aoFooter);
      if (!settings.aiDisplay.length) {
        $(settings.nTBody).find("td[colspan]").attr("colspan", _fnVisibleColumns(settings));
      }
      _fnSaveState(settings);
      that.iterator("column", function(settings2, column) {
        if (changed.includes(column)) {
          _fnCallbackFire(settings2, null, "column-visibility", [settings2, column, vis, calc]);
        }
      });
      if (changed.length && (calc === void 0 || calc)) {
        that.columns.adjust();
      }
    });
  }
  return ret;
});
_api_registerPlural("columns().widths()", "column().width()", function() {
  var columns = this.columns(":visible").count();
  var row = $("<tr>").html("<td>" + Array(columns).join("</td><td>") + "</td>");
  $(this.table().body()).append(row);
  var widths = row.children().map(function() {
    return $(this).outerWidth();
  });
  row.remove();
  return this.iterator("column", function(settings, column) {
    var visIdx = _fnColumnIndexToVisible(settings, column);
    return visIdx !== null ? widths[visIdx] : 0;
  }, 1);
});
_api_registerPlural("columns().indexes()", "column().index()", function(type) {
  return this.iterator("column", function(settings, column) {
    return type === "visible" ? _fnColumnIndexToVisible(settings, column) : column;
  }, 1);
});
_api_register("columns.adjust()", function() {
  return this.iterator("table", function(settings) {
    settings.containerWidth = -1;
    _fnAdjustColumnSizing(settings);
  }, 1);
});
_api_register("column.index()", function(type, idx) {
  if (this.context.length !== 0) {
    var ctx = this.context[0];
    if (type === "fromVisible" || type === "toData") {
      return _fnVisibleToColumnIndex(ctx, idx);
    } else if (type === "fromData" || type === "toVisible") {
      return _fnColumnIndexToVisible(ctx, idx);
    }
  }
});
_api_register("column()", function(selector, opts) {
  return _selector_first(this.columns(selector, opts));
});
var __cell_selector = function(settings, selector, opts) {
  var data = settings.aoData;
  var rows = _selector_row_indexes(settings, opts);
  var cells = _removeEmpty(_pluck_order(data, rows, "anCells"));
  var allCells = $(_flatten([], cells));
  var row;
  var columns = settings.aoColumns.length;
  var a, i, iLen, j, o, host;
  var run = function(s) {
    var fnSelector = typeof s === "function";
    if (s === null || s === void 0 || fnSelector) {
      a = [];
      for (i = 0, iLen = rows.length; i < iLen; i++) {
        row = rows[i];
        for (j = 0; j < columns; j++) {
          o = {
            row,
            column: j
          };
          if (fnSelector) {
            host = data[row];
            if (s(o, _fnGetCellData(settings, row, j), host.anCells ? host.anCells[j] : null)) {
              a.push(o);
            }
          } else {
            a.push(o);
          }
        }
      }
      return a;
    }
    if ($.isPlainObject(s)) {
      return s.column !== void 0 && s.row !== void 0 && rows.indexOf(s.row) !== -1 ? [s] : [];
    }
    var jqResult = allCells.filter(s).map(function(i2, el) {
      return {
        // use a new object, in case someone changes the values
        row: el._DT_CellIndex.row,
        column: el._DT_CellIndex.column
      };
    }).toArray();
    if (jqResult.length || !s.nodeName) {
      return jqResult;
    }
    host = $(s).closest("*[data-dt-row]");
    return host.length ? [{
      row: host.data("dt-row"),
      column: host.data("dt-column")
    }] : [];
  };
  return _selector_run("cell", selector, run, settings, opts);
};
_api_register("cells()", function(rowSelector, columnSelector, opts) {
  if ($.isPlainObject(rowSelector)) {
    if (rowSelector.row === void 0) {
      opts = rowSelector;
      rowSelector = null;
    } else {
      opts = columnSelector;
      columnSelector = null;
    }
  }
  if ($.isPlainObject(columnSelector)) {
    opts = columnSelector;
    columnSelector = null;
  }
  if (columnSelector === null || columnSelector === void 0) {
    return this.iterator("table", function(settings) {
      return __cell_selector(settings, rowSelector, _selector_opts(opts));
    });
  }
  var internalOpts = opts ? {
    page: opts.page,
    order: opts.order,
    search: opts.search
  } : {};
  var columns = this.columns(columnSelector, internalOpts);
  var rows = this.rows(rowSelector, internalOpts);
  var i, iLen, j, jen;
  var cellsNoOpts = this.iterator("table", function(settings, idx) {
    var a = [];
    for (i = 0, iLen = rows[idx].length; i < iLen; i++) {
      for (j = 0, jen = columns[idx].length; j < jen; j++) {
        a.push({
          row: rows[idx][i],
          column: columns[idx][j]
        });
      }
    }
    return a;
  }, 1);
  var cells = opts && opts.selected ? this.cells(cellsNoOpts, opts) : cellsNoOpts;
  $.extend(cells.selector, {
    cols: columnSelector,
    rows: rowSelector,
    opts
  });
  return cells;
});
_api_registerPlural("cells().nodes()", "cell().node()", function() {
  return this.iterator("cell", function(settings, row, column) {
    var data = settings.aoData[row];
    return data && data.anCells ? data.anCells[column] : void 0;
  }, 1);
});
_api_register("cells().data()", function() {
  return this.iterator("cell", function(settings, row, column) {
    return _fnGetCellData(settings, row, column);
  }, 1);
});
_api_registerPlural("cells().cache()", "cell().cache()", function(type) {
  type = type === "search" ? "_aFilterData" : "_aSortData";
  return this.iterator("cell", function(settings, row, column) {
    return settings.aoData[row][type][column];
  }, 1);
});
_api_registerPlural("cells().render()", "cell().render()", function(type) {
  return this.iterator("cell", function(settings, row, column) {
    return _fnGetCellData(settings, row, column, type);
  }, 1);
});
_api_registerPlural("cells().indexes()", "cell().index()", function() {
  return this.iterator("cell", function(settings, row, column) {
    return {
      row,
      column,
      columnVisible: _fnColumnIndexToVisible(settings, column)
    };
  }, 1);
});
_api_registerPlural("cells().invalidate()", "cell().invalidate()", function(src) {
  return this.iterator("cell", function(settings, row, column) {
    _fnInvalidate(settings, row, src, column);
  });
});
_api_register("cell()", function(rowSelector, columnSelector, opts) {
  return _selector_first(this.cells(rowSelector, columnSelector, opts));
});
_api_register("cell().data()", function(data) {
  var ctx = this.context;
  var cell = this[0];
  if (data === void 0) {
    return ctx.length && cell.length ? _fnGetCellData(ctx[0], cell[0].row, cell[0].column) : void 0;
  }
  _fnSetCellData(ctx[0], cell[0].row, cell[0].column, data);
  _fnInvalidate(ctx[0], cell[0].row, "data", cell[0].column);
  return this;
});
_api_register("order()", function(order, dir) {
  var ctx = this.context;
  var args = Array.prototype.slice.call(arguments);
  if (order === void 0) {
    return ctx.length !== 0 ? ctx[0].aaSorting : void 0;
  }
  if (typeof order === "number") {
    order = [[order, dir]];
  } else if (args.length > 1) {
    order = args;
  }
  return this.iterator("table", function(settings) {
    var resolved = [];
    _fnSortResolve(settings, resolved, order);
    settings.aaSorting = resolved;
  });
});
_api_register("order.listener()", function(node, column, callback) {
  return this.iterator("table", function(settings) {
    _fnSortAttachListener(settings, node, {}, column, callback);
  });
});
_api_register("order.fixed()", function(set) {
  if (!set) {
    var ctx = this.context;
    var fixed = ctx.length ? ctx[0].aaSortingFixed : void 0;
    return Array.isArray(fixed) ? { pre: fixed } : fixed;
  }
  return this.iterator("table", function(settings) {
    settings.aaSortingFixed = $.extend(true, {}, set);
  });
});
_api_register([
  "columns().order()",
  "column().order()"
], function(dir) {
  var that = this;
  if (!dir) {
    return this.iterator("column", function(settings, idx) {
      var sort = _fnSortFlatten(settings);
      for (var i = 0, iLen = sort.length; i < iLen; i++) {
        if (sort[i].col === idx) {
          return sort[i].dir;
        }
      }
      return null;
    }, 1);
  } else {
    return this.iterator("table", function(settings, i) {
      settings.aaSorting = that[i].map(function(col) {
        return [col, dir];
      });
    });
  }
});
_api_registerPlural("columns().orderable()", "column().orderable()", function(directions) {
  return this.iterator("column", function(settings, idx) {
    var col = settings.aoColumns[idx];
    return directions ? col.asSorting : col.bSortable;
  }, 1);
});
_api_register("processing()", function(show) {
  return this.iterator("table", function(ctx) {
    _fnProcessingDisplay(ctx, show);
  });
});
_api_register("search()", function(input, regex, smart, caseInsen) {
  var ctx = this.context;
  if (input === void 0) {
    return ctx.length !== 0 ? ctx[0].oPreviousSearch.search : void 0;
  }
  return this.iterator("table", function(settings) {
    if (!settings.oFeatures.bFilter) {
      return;
    }
    if (typeof regex === "object") {
      _fnFilterComplete(settings, $.extend(settings.oPreviousSearch, regex, {
        search: input
      }));
    } else {
      _fnFilterComplete(settings, $.extend(settings.oPreviousSearch, {
        search: input,
        regex: regex === null ? false : regex,
        smart: smart === null ? true : smart,
        caseInsensitive: caseInsen === null ? true : caseInsen
      }));
    }
  });
});
_api_register("search.fixed()", function(name, search) {
  var ret = this.iterator(true, "table", function(settings) {
    var fixed = settings.searchFixed;
    if (!name) {
      return Object.keys(fixed);
    } else if (search === void 0) {
      return fixed[name];
    } else if (search === null) {
      delete fixed[name];
    } else {
      fixed[name] = search;
    }
    return this;
  });
  return name !== void 0 && search === void 0 ? ret[0] : ret;
});
_api_registerPlural(
  "columns().search()",
  "column().search()",
  function(input, regex, smart, caseInsen) {
    return this.iterator("column", function(settings, column) {
      var preSearch = settings.aoPreSearchCols;
      if (input === void 0) {
        return preSearch[column].search;
      }
      if (!settings.oFeatures.bFilter) {
        return;
      }
      if (typeof regex === "object") {
        $.extend(preSearch[column], regex, {
          search: input
        });
      } else {
        $.extend(preSearch[column], {
          search: input,
          regex: regex === null ? false : regex,
          smart: smart === null ? true : smart,
          caseInsensitive: caseInsen === null ? true : caseInsen
        });
      }
      _fnFilterComplete(settings, settings.oPreviousSearch);
    });
  }
);
_api_register(
  [
    "columns().search.fixed()",
    "column().search.fixed()"
  ],
  function(name, search) {
    var ret = this.iterator(true, "column", function(settings, colIdx) {
      var fixed = settings.aoColumns[colIdx].searchFixed;
      if (!name) {
        return Object.keys(fixed);
      } else if (search === void 0) {
        return fixed[name] || null;
      } else if (search === null) {
        delete fixed[name];
      } else {
        fixed[name] = search;
      }
      return this;
    });
    return name !== void 0 && search === void 0 ? ret[0] : ret;
  }
);
_api_register("state()", function(set, ignoreTime) {
  if (!set) {
    return this.context.length ? this.context[0].oSavedState : null;
  }
  var setMutate = $.extend(true, {}, set);
  return this.iterator("table", function(settings) {
    if (ignoreTime !== false) {
      setMutate.time = +/* @__PURE__ */ new Date() + 100;
    }
    _fnImplementState(settings, setMutate, function() {
    });
  });
});
_api_register("state.clear()", function() {
  return this.iterator("table", function(settings) {
    settings.fnStateSaveCallback.call(settings.oInstance, settings, {});
  });
});
_api_register("state.loaded()", function() {
  return this.context.length ? this.context[0].oLoadedState : null;
});
_api_register("state.save()", function() {
  return this.iterator("table", function(settings) {
    _fnSaveState(settings);
  });
});
var __bootstrap;
var __foundation;
DataTable.use = function(arg1, arg2) {
  var module = typeof arg1 === "string" ? arg2 : arg1;
  var type = typeof arg2 === "string" ? arg2 : arg1;
  if (module === void 0 && typeof type === "string") {
    switch (type) {
      case "lib":
      case "jq":
        return $;
      case "win":
        return window;
      case "datetime":
        return DataTable.DateTime;
      case "luxon":
        return __luxon;
      case "moment":
        return __moment;
      case "bootstrap":
        return __bootstrap || window.bootstrap;
      case "foundation":
        return __foundation || window.Foundation;
      default:
        return null;
    }
  }
  if (type === "lib" || type === "jq" || module && module.fn && module.fn.jquery) {
    $ = module;
  } else if (type === "win" || module && module.document) {
    window = module;
    document = module.document;
  } else if (type === "datetime" || module && module.type === "DateTime") {
    DataTable.DateTime = module;
  } else if (type === "luxon" || module && module.FixedOffsetZone) {
    __luxon = module;
  } else if (type === "moment" || module && module.isMoment) {
    __moment = module;
  } else if (type === "bootstrap" || module && module.Modal && module.Modal.NAME === "modal") {
    __bootstrap = module;
  } else if (type === "foundation" || module && module.Reveal) {
    __foundation = module;
  }
};
DataTable.factory = function(root, jq) {
  var is = false;
  if (root && root.document) {
    window = root;
    document = root.document;
  }
  if (jq && jq.fn && jq.fn.jquery) {
    $ = jq;
    is = true;
  }
  return is;
};
DataTable.versionCheck = function(version, version2) {
  var aThis = version2 ? version2.split(".") : DataTable.version.split(".");
  var aThat = version.split(".");
  var iThis, iThat;
  for (var i = 0, iLen = aThat.length; i < iLen; i++) {
    iThis = parseInt(aThis[i], 10) || 0;
    iThat = parseInt(aThat[i], 10) || 0;
    if (iThis === iThat) {
      continue;
    }
    return iThis > iThat;
  }
  return true;
};
DataTable.isDataTable = function(table) {
  var t = $(table).get(0);
  var is = false;
  if (table instanceof DataTable.Api) {
    return true;
  }
  $.each(DataTable.settings, function(i, o) {
    var head = o.nScrollHead ? $("table", o.nScrollHead)[0] : null;
    var foot = o.nScrollFoot ? $("table", o.nScrollFoot)[0] : null;
    if (o.nTable === t || head === t || foot === t) {
      is = true;
    }
  });
  return is;
};
DataTable.tables = function(visible) {
  var api = false;
  if ($.isPlainObject(visible)) {
    api = visible.api;
    visible = visible.visible;
  }
  var a = DataTable.settings.filter(function(o) {
    return !visible || visible && $(o.nTable).is(":visible") ? true : false;
  }).map(function(o) {
    return o.nTable;
  });
  return api ? new _Api(a) : a;
};
DataTable.camelToHungarian = _fnCamelToHungarian;
_api_register("$()", function(selector, opts) {
  var rows = this.rows(opts).nodes(), jqRows = $(rows);
  return $([].concat(
    jqRows.filter(selector).toArray(),
    jqRows.find(selector).toArray()
  ));
});
$.each(["on", "one", "off"], function(i, key) {
  _api_register(key + "()", function() {
    var args = Array.prototype.slice.call(arguments);
    args[0] = args[0].split(/\s/).map(function(e) {
      return !e.match(/\.dt\b/) ? e + ".dt" : e;
    }).join(" ");
    var inst = $(this.tables().nodes());
    inst[key].apply(inst, args);
    return this;
  });
});
_api_register("clear()", function() {
  return this.iterator("table", function(settings) {
    _fnClearTable(settings);
  });
});
_api_register("error()", function(msg) {
  return this.iterator("table", function(settings) {
    _fnLog(settings, 0, msg);
  });
});
_api_register("settings()", function() {
  return new _Api(this.context, this.context);
});
_api_register("init()", function() {
  var ctx = this.context;
  return ctx.length ? ctx[0].oInit : null;
});
_api_register("data()", function() {
  return this.iterator("table", function(settings) {
    return _pluck(settings.aoData, "_aData");
  }).flatten();
});
_api_register("trigger()", function(name, args, bubbles) {
  return this.iterator("table", function(settings) {
    return _fnCallbackFire(settings, null, name, args, bubbles);
  }).flatten();
});
_api_register("ready()", function(fn) {
  var ctx = this.context;
  if (!fn) {
    return ctx.length ? ctx[0]._bInitComplete || false : null;
  }
  return this.tables().every(function() {
    var api = this;
    if (this.context[0]._bInitComplete) {
      fn.call(api);
    } else {
      this.on("init.dt.DT", function() {
        fn.call(api);
      });
    }
  });
});
_api_register("destroy()", function(remove) {
  remove = remove || false;
  return this.iterator("table", function(settings) {
    var classes = settings.oClasses;
    var table = settings.nTable;
    var tbody = settings.nTBody;
    var thead = settings.nTHead;
    var tfoot = settings.nTFoot;
    var jqTable = $(table);
    var jqTbody = $(tbody);
    var jqWrapper = $(settings.nTableWrapper);
    var rows = settings.aoData.map(function(r) {
      return r ? r.nTr : null;
    });
    var orderClasses = classes.order;
    settings.bDestroying = true;
    _fnCallbackFire(settings, "aoDestroyCallback", "destroy", [settings], true);
    if (!remove) {
      new _Api(settings).columns().visible(true);
    }
    if (settings.resizeObserver) {
      settings.resizeObserver.disconnect();
    }
    jqWrapper.off(".DT").find(":not(tbody *)").off(".DT");
    $(window).off(".DT-" + settings.sInstance);
    if (table != thead.parentNode) {
      jqTable.children("thead").detach();
      jqTable.append(thead);
    }
    if (tfoot && table != tfoot.parentNode) {
      jqTable.children("tfoot").detach();
      jqTable.append(tfoot);
    }
    cleanHeader(thead, "header");
    cleanHeader(tfoot, "footer");
    settings.colgroup.remove();
    settings.aaSorting = [];
    settings.aaSortingFixed = [];
    _fnSortingClasses(settings);
    $(jqTable).find("th, td").removeClass(
      $.map(DataTable.ext.type.className, function(v) {
        return v;
      }).join(" ")
    );
    $("th, td", thead).removeClass(
      orderClasses.none + " " + orderClasses.canAsc + " " + orderClasses.canDesc + " " + orderClasses.isAsc + " " + orderClasses.isDesc
    ).css("width", "").removeAttr("aria-sort");
    jqTbody.children().detach();
    jqTbody.append(rows);
    var orig = settings.nTableWrapper.parentNode;
    var insertBefore = settings.nTableWrapper.nextSibling;
    var removedMethod = remove ? "remove" : "detach";
    jqTable[removedMethod]();
    jqWrapper[removedMethod]();
    if (!remove && orig) {
      orig.insertBefore(table, insertBefore);
      jqTable.css("width", settings.sDestroyWidth).removeClass(classes.table);
    }
    var idx = DataTable.settings.indexOf(settings);
    if (idx !== -1) {
      DataTable.settings.splice(idx, 1);
    }
  });
});
$.each(["column", "row", "cell"], function(i, type) {
  _api_register(type + "s().every()", function(fn) {
    var opts = this.selector.opts;
    var api = this;
    var inst;
    var counter = 0;
    return this.iterator("every", function(settings, selectedIdx, tableIdx) {
      inst = api[type](selectedIdx, opts);
      if (type === "cell") {
        fn.call(inst, inst[0][0].row, inst[0][0].column, tableIdx, counter);
      } else {
        fn.call(inst, selectedIdx, tableIdx, counter);
      }
      counter++;
    });
  });
});
_api_register("i18n()", function(token, def, plural) {
  var ctx = this.context[0];
  var resolved = _fnGetObjectDataFn(token)(ctx.oLanguage);
  if (resolved === void 0) {
    resolved = def;
  }
  if ($.isPlainObject(resolved)) {
    resolved = plural !== void 0 && resolved[plural] !== void 0 ? resolved[plural] : plural === false ? resolved : resolved._;
  }
  return typeof resolved === "string" ? resolved.replace("%d", plural) : resolved;
});
function cleanHeader(node, className) {
  $(node).find("span.dt-column-order").remove();
  $(node).find("span.dt-column-title").each(function() {
    var title = $(this).html();
    $(this).parent().parent().append(title);
    $(this).remove();
  });
  $(node).find("div.dt-column-" + className).remove();
  $("th, td", node).removeAttr("data-dt-column");
}
DataTable.version = "2.3.4";
DataTable.settings = [];
DataTable.models = {};
DataTable.models.oSearch = {
  /**
   * Flag to whether or not the filtering should be case-insensitive
   */
  "caseInsensitive": true,
  /**
   * Applied search term
   */
  "search": "",
  /**
   * Flag to indicate if the search term should be interpreted as a
   * regular expression (true) or not (false) and therefore and special
   * regex characters escaped.
   */
  "regex": false,
  /**
   * Flag to indicate if DataTables is to use its smart filtering or not.
   */
  "smart": true,
  /**
   * Flag to indicate if DataTables should only trigger a search when
   * the return key is pressed.
   */
  "return": false
};
DataTable.models.oRow = {
  /**
   * TR element for the row
   */
  "nTr": null,
  /**
   * Array of TD elements for each row. This is null until the row has been
   * created.
   */
  "anCells": null,
  /**
   * Data object from the original data source for the row. This is either
   * an array if using the traditional form of DataTables, or an object if
   * using mData options. The exact type will depend on the passed in
   * data from the data source, or will be an array if using DOM a data
   * source.
   */
  "_aData": [],
  /**
   * Sorting data cache - this array is ostensibly the same length as the
   * number of columns (although each index is generated only as it is
   * needed), and holds the data that is used for sorting each column in the
   * row. We do this cache generation at the start of the sort in order that
   * the formatting of the sort data need be done only once for each cell
   * per sort. This array should not be read from or written to by anything
   * other than the master sorting methods.
   */
  "_aSortData": null,
  /**
   * Per cell filtering data cache. As per the sort data cache, used to
   * increase the performance of the filtering in DataTables
   */
  "_aFilterData": null,
  /**
   * Filtering data cache. This is the same as the cell filtering cache, but
   * in this case a string rather than an array. This is easily computed with
   * a join on `_aFilterData`, but is provided as a cache so the join isn't
   * needed on every search (memory traded for performance)
   */
  "_sFilterRow": null,
  /**
   * Denote if the original data source was from the DOM, or the data source
   * object. This is used for invalidating data, so DataTables can
   * automatically read data from the original source, unless uninstructed
   * otherwise.
   */
  "src": null,
  /**
   * Index in the aoData array. This saves an indexOf lookup when we have the
   * object, but want to know the index
   */
  "idx": -1,
  /**
   * Cached display value
   */
  displayData: null
};
DataTable.models.oColumn = {
  /**
   * Column index.
   */
  "idx": null,
  /**
   * A list of the columns that sorting should occur on when this column
   * is sorted. That this property is an array allows multi-column sorting
   * to be defined for a column (for example first name / last name columns
   * would benefit from this). The values are integers pointing to the
   * columns to be sorted on (typically it will be a single integer pointing
   * at itself, but that doesn't need to be the case).
   */
  "aDataSort": null,
  /**
   * Define the sorting directions that are applied to the column, in sequence
   * as the column is repeatedly sorted upon - i.e. the first value is used
   * as the sorting direction when the column if first sorted (clicked on).
   * Sort it again (click again) and it will move on to the next index.
   * Repeat until loop.
   */
  "asSorting": null,
  /**
   * Flag to indicate if the column is searchable, and thus should be included
   * in the filtering or not.
   */
  "bSearchable": null,
  /**
   * Flag to indicate if the column is sortable or not.
   */
  "bSortable": null,
  /**
   * Flag to indicate if the column is currently visible in the table or not
   */
  "bVisible": null,
  /**
   * Store for manual type assignment using the `column.type` option. This
   * is held in store so we can manipulate the column's `sType` property.
   */
  "_sManualType": null,
  /**
   * Flag to indicate if HTML5 data attributes should be used as the data
   * source for filtering or sorting. True is either are.
   */
  "_bAttrSrc": false,
  /**
   * Developer definable function that is called whenever a cell is created (Ajax source,
   * etc) or processed for input (DOM source). This can be used as a compliment to mRender
   * allowing you to modify the DOM element (add background colour for example) when the
   * element is available.
   */
  "fnCreatedCell": null,
  /**
   * Function to get data from a cell in a column. You should <b>never</b>
   * access data directly through _aData internally in DataTables - always use
   * the method attached to this property. It allows mData to function as
   * required. This function is automatically assigned by the column
   * initialisation method
   */
  "fnGetData": null,
  /**
   * Function to set data for a cell in the column. You should <b>never</b>
   * set the data directly to _aData internally in DataTables - always use
   * this method. It allows mData to function as required. This function
   * is automatically assigned by the column initialisation method
   */
  "fnSetData": null,
  /**
   * Property to read the value for the cells in the column from the data
   * source array / object. If null, then the default content is used, if a
   * function is given then the return from the function is used.
   */
  "mData": null,
  /**
   * Partner property to mData which is used (only when defined) to get
   * the data - i.e. it is basically the same as mData, but without the
   * 'set' option, and also the data fed to it is the result from mData.
   * This is the rendering method to match the data method of mData.
   */
  "mRender": null,
  /**
   * The class to apply to all TD elements in the table's TBODY for the column
   */
  "sClass": null,
  /**
   * When DataTables calculates the column widths to assign to each column,
   * it finds the longest string in each column and then constructs a
   * temporary table and reads the widths from that. The problem with this
   * is that "mmm" is much wider then "iiii", but the latter is a longer
   * string - thus the calculation can go wrong (doing it properly and putting
   * it into an DOM object and measuring that is horribly(!) slow). Thus as
   * a "work around" we provide this option. It will append its value to the
   * text that is found to be the longest string for the column - i.e. padding.
   */
  "sContentPadding": null,
  /**
   * Allows a default value to be given for a column's data, and will be used
   * whenever a null data source is encountered (this can be because mData
   * is set to null, or because the data source itself is null).
   */
  "sDefaultContent": null,
  /**
   * Name for the column, allowing reference to the column by name as well as
   * by index (needs a lookup to work by name).
   */
  "sName": null,
  /**
   * Custom sorting data type - defines which of the available plug-ins in
   * afnSortData the custom sorting will use - if any is defined.
   */
  "sSortDataType": "std",
  /**
   * Class to be applied to the header element when sorting on this column
   */
  "sSortingClass": null,
  /**
   * Title of the column - what is seen in the TH element (nTh).
   */
  "sTitle": null,
  /**
   * Column sorting and filtering type
   */
  "sType": null,
  /**
   * Width of the column
   */
  "sWidth": null,
  /**
   * Width of the column when it was first "encountered"
   */
  "sWidthOrig": null,
  /** Cached string which is the longest in the column */
  maxLenString: null,
  /**
   * Store for named searches
   */
  searchFixed: null
};
DataTable.defaults = {
  /**
   * An array of data to use for the table, passed in at initialisation which
   * will be used in preference to any data which is already in the DOM. This is
   * particularly useful for constructing tables purely in JavaScript, for
   * example with a custom Ajax call.
   */
  "aaData": null,
  /**
   * If ordering is enabled, then DataTables will perform a first pass sort on
   * initialisation. You can define which column(s) the sort is performed
   * upon, and the sorting direction, with this variable. The `sorting` array
   * should contain an array for each column to be sorted initially containing
   * the column's index and a direction string ('asc' or 'desc').
   */
  "aaSorting": [[0, "asc"]],
  /**
   * This parameter is basically identical to the `sorting` parameter, but
   * cannot be overridden by user interaction with the table. What this means
   * is that you could have a column (visible or hidden) which the sorting
   * will always be forced on first - any sorting after that (from the user)
   * will then be performed as required. This can be useful for grouping rows
   * together.
   */
  "aaSortingFixed": [],
  /**
   * DataTables can be instructed to load data to display in the table from a
   * Ajax source. This option defines how that Ajax call is made and where to.
   *
   * The `ajax` property has three different modes of operation, depending on
   * how it is defined. These are:
   *
   * * `string` - Set the URL from where the data should be loaded from.
   * * `object` - Define properties for `jQuery.ajax`.
   * * `function` - Custom data get function
   *
   * `string`
   * --------
   *
   * As a string, the `ajax` property simply defines the URL from which
   * DataTables will load data.
   *
   * `object`
   * --------
   *
   * As an object, the parameters in the object are passed to
   * [jQuery.ajax](https://api.jquery.com/jQuery.ajax/) allowing fine control
   * of the Ajax request. DataTables has a number of default parameters which
   * you can override using this option. Please refer to the jQuery
   * documentation for a full description of the options available, although
   * the following parameters provide additional options in DataTables or
   * require special consideration:
   *
   * * `data` - As with jQuery, `data` can be provided as an object, but it
   *   can also be used as a function to manipulate the data DataTables sends
   *   to the server. The function takes a single parameter, an object of
   *   parameters with the values that DataTables has readied for sending. An
   *   object may be returned which will be merged into the DataTables
   *   defaults, or you can add the items to the object that was passed in and
   *   not return anything from the function. This supersedes `fnServerParams`
   *   from DataTables 1.9-.
   *
   * * `dataSrc` - By default DataTables will look for the property `data` (or
   *   `aaData` for compatibility with DataTables 1.9-) when obtaining data
   *   from an Ajax source or for server-side processing - this parameter
   *   allows that property to be changed. You can use JavaScript dotted
   *   object notation to get a data source for multiple levels of nesting, or
   *   it my be used as a function. As a function it takes a single parameter,
   *   the JSON returned from the server, which can be manipulated as
   *   required, with the returned value being that used by DataTables as the
   *   data source for the table.
   *
   * * `success` - Should not be overridden it is used internally in
   *   DataTables. To manipulate / transform the data returned by the server
   *   use `ajax.dataSrc`, or use `ajax` as a function (see below).
   *
   * `function`
   * ----------
   *
   * As a function, making the Ajax call is left up to yourself allowing
   * complete control of the Ajax request. Indeed, if desired, a method other
   * than Ajax could be used to obtain the required data, such as Web storage
   * or an AIR database.
   *
   * The function is given four parameters and no return is required. The
   * parameters are:
   *
   * 1. _object_ - Data to send to the server
   * 2. _function_ - Callback function that must be executed when the required
   *    data has been obtained. That data should be passed into the callback
   *    as the only parameter
   * 3. _object_ - DataTables settings object for the table
   */
  "ajax": null,
  /**
   * This parameter allows you to readily specify the entries in the length drop
   * down menu that DataTables shows when pagination is enabled. It can be
   * either a 1D array of options which will be used for both the displayed
   * option and the value, or a 2D array which will use the array in the first
   * position as the value, and the array in the second position as the
   * displayed options (useful for language strings such as 'All').
   *
   * Note that the `pageLength` property will be automatically set to the
   * first value given in this array, unless `pageLength` is also provided.
   */
  "aLengthMenu": [10, 25, 50, 100],
  /**
   * The `columns` option in the initialisation parameter allows you to define
   * details about the way individual columns behave. For a full list of
   * column options that can be set, please see
   * {@link DataTable.defaults.column}. Note that if you use `columns` to
   * define your columns, you must have an entry in the array for every single
   * column that you have in your table (these can be null if you don't which
   * to specify any options).
   */
  "aoColumns": null,
  /**
   * Very similar to `columns`, `columnDefs` allows you to target a specific
   * column, multiple columns, or all columns, using the `targets` property of
   * each object in the array. This allows great flexibility when creating
   * tables, as the `columnDefs` arrays can be of any length, targeting the
   * columns you specifically want. `columnDefs` may use any of the column
   * options available: {@link DataTable.defaults.column}, but it _must_
   * have `targets` defined in each object in the array. Values in the `targets`
   * array may be:
   *   <ul>
   *     <li>a string - class name will be matched on the TH for the column</li>
   *     <li>0 or a positive integer - column index counting from the left</li>
   *     <li>a negative integer - column index counting from the right</li>
   *     <li>the string "_all" - all columns (i.e. assign a default)</li>
   *   </ul>
   */
  "aoColumnDefs": null,
  /**
   * Basically the same as `search`, this parameter defines the individual column
   * filtering state at initialisation time. The array must be of the same size
   * as the number of columns, and each element be an object with the parameters
   * `search` and `escapeRegex` (the latter is optional). 'null' is also
   * accepted and the default will be used.
   */
  "aoSearchCols": [],
  /**
   * Enable or disable automatic column width calculation. This can be disabled
   * as an optimisation (it takes some time to calculate the widths) if the
   * tables widths are passed in using `columns`.
   */
  "bAutoWidth": true,
  /**
   * Deferred rendering can provide DataTables with a huge speed boost when you
   * are using an Ajax or JS data source for the table. This option, when set to
   * true, will cause DataTables to defer the creation of the table elements for
   * each row until they are needed for a draw - saving a significant amount of
   * time.
   */
  "bDeferRender": true,
  /**
   * Replace a DataTable which matches the given selector and replace it with
   * one which has the properties of the new initialisation object passed. If no
   * table matches the selector, then the new DataTable will be constructed as
   * per normal.
   */
  "bDestroy": false,
  /**
   * Enable or disable filtering of data. Filtering in DataTables is "smart" in
   * that it allows the end user to input multiple words (space separated) and
   * will match a row containing those words, even if not in the order that was
   * specified (this allow matching across multiple columns). Note that if you
   * wish to use filtering in DataTables this must remain 'true' - to remove the
   * default filtering input box and retain filtering abilities, please use
   * {@link DataTable.defaults.dom}.
   */
  "bFilter": true,
  /**
   * Used only for compatibility with DT1
   * @deprecated
   */
  "bInfo": true,
  /**
   * Used only for compatibility with DT1
   * @deprecated
   */
  "bLengthChange": true,
  /**
   * Enable or disable pagination.
   */
  "bPaginate": true,
  /**
   * Enable or disable the display of a 'processing' indicator when the table is
   * being processed (e.g. a sort). This is particularly useful for tables with
   * large amounts of data where it can take a noticeable amount of time to sort
   * the entries.
   */
  "bProcessing": false,
  /**
   * Retrieve the DataTables object for the given selector. Note that if the
   * table has already been initialised, this parameter will cause DataTables
   * to simply return the object that has already been set up - it will not take
   * account of any changes you might have made to the initialisation object
   * passed to DataTables (setting this parameter to true is an acknowledgement
   * that you understand this). `destroy` can be used to reinitialise a table if
   * you need.
   */
  "bRetrieve": false,
  /**
   * When vertical (y) scrolling is enabled, DataTables will force the height of
   * the table's viewport to the given height at all times (useful for layout).
   * However, this can look odd when filtering data down to a small data set,
   * and the footer is left "floating" further down. This parameter (when
   * enabled) will cause DataTables to collapse the table's viewport down when
   * the result set will fit within the given Y height.
   */
  "bScrollCollapse": false,
  /**
   * Configure DataTables to use server-side processing. Note that the
   * `ajax` parameter must also be given in order to give DataTables a
   * source to obtain the required data for each draw.
   */
  "bServerSide": false,
  /**
   * Enable or disable sorting of columns. Sorting of individual columns can be
   * disabled by the `sortable` option for each column.
   */
  "bSort": true,
  /**
   * Enable or display DataTables' ability to sort multiple columns at the
   * same time (activated by shift-click by the user).
   */
  "bSortMulti": true,
  /**
   * Allows control over whether DataTables should use the top (true) unique
   * cell that is found for a single column, or the bottom (false - default).
   * This is useful when using complex headers.
   */
  "bSortCellsTop": null,
  /** Specify which row is the title row in the header. Replacement for bSortCellsTop */
  titleRow: null,
  /**
   * Enable or disable the addition of the classes `sorting\_1`, `sorting\_2` and
   * `sorting\_3` to the columns which are currently being sorted on. This is
   * presented as a feature switch as it can increase processing time (while
   * classes are removed and added) so for large data sets you might want to
   * turn this off.
   */
  "bSortClasses": true,
  /**
   * Enable or disable state saving. When enabled HTML5 `localStorage` will be
   * used to save table display information such as pagination information,
   * display length, filtering and sorting. As such when the end user reloads
   * the page the display will match what thy had previously set up.
   */
  "bStateSave": false,
  /**
   * This function is called when a TR element is created (and all TD child
   * elements have been inserted), or registered if using a DOM source, allowing
   * manipulation of the TR element (adding classes etc).
   */
  "fnCreatedRow": null,
  /**
   * This function is called on every 'draw' event, and allows you to
   * dynamically modify any aspect you want about the created DOM.
   */
  "fnDrawCallback": null,
  /**
   * Identical to fnHeaderCallback() but for the table footer this function
   * allows you to modify the table footer on every 'draw' event.
   */
  "fnFooterCallback": null,
  /**
   * When rendering large numbers in the information element for the table
   * (i.e. "Showing 1 to 10 of 57 entries") DataTables will render large numbers
   * to have a comma separator for the 'thousands' units (e.g. 1 million is
   * rendered as "1,000,000") to help readability for the end user. This
   * function will override the default method DataTables uses.
   */
  "fnFormatNumber": function(toFormat) {
    return toFormat.toString().replace(
      /\B(?=(\d{3})+(?!\d))/g,
      this.oLanguage.sThousands
    );
  },
  /**
   * This function is called on every 'draw' event, and allows you to
   * dynamically modify the header row. This can be used to calculate and
   * display useful information about the table.
   */
  "fnHeaderCallback": null,
  /**
   * The information element can be used to convey information about the current
   * state of the table. Although the internationalisation options presented by
   * DataTables are quite capable of dealing with most customisations, there may
   * be times where you wish to customise the string further. This callback
   * allows you to do exactly that.
   */
  "fnInfoCallback": null,
  /**
   * Called when the table has been initialised. Normally DataTables will
   * initialise sequentially and there will be no need for this function,
   * however, this does not hold true when using external language information
   * since that is obtained using an async XHR call.
   */
  "fnInitComplete": null,
  /**
   * Called at the very start of each table draw and can be used to cancel the
   * draw by returning false, any other return (including undefined) results in
   * the full draw occurring).
   */
  "fnPreDrawCallback": null,
  /**
   * This function allows you to 'post process' each row after it have been
   * generated for each table draw, but before it is rendered on screen. This
   * function might be used for setting the row class name etc.
   */
  "fnRowCallback": null,
  /**
   * Load the table state. With this function you can define from where, and how, the
   * state of a table is loaded. By default DataTables will load from `localStorage`
   * but you might wish to use a server-side database or cookies.
   */
  "fnStateLoadCallback": function(settings) {
    try {
      return JSON.parse(
        (settings.iStateDuration === -1 ? sessionStorage : localStorage).getItem(
          "DataTables_" + settings.sInstance + "_" + location.pathname
        )
      );
    } catch (e) {
      return {};
    }
  },
  /**
   * Callback which allows modification of the saved state prior to loading that state.
   * This callback is called when the table is loading state from the stored data, but
   * prior to the settings object being modified by the saved state. Note that for
   * plug-in authors, you should use the `stateLoadParams` event to load parameters for
   * a plug-in.
   */
  "fnStateLoadParams": null,
  /**
   * Callback that is called when the state has been loaded from the state saving method
   * and the DataTables settings object has been modified as a result of the loaded state.
   */
  "fnStateLoaded": null,
  /**
   * Save the table state. This function allows you to define where and how the state
   * information for the table is stored By default DataTables will use `localStorage`
   * but you might wish to use a server-side database or cookies.
   */
  "fnStateSaveCallback": function(settings, data) {
    try {
      (settings.iStateDuration === -1 ? sessionStorage : localStorage).setItem(
        "DataTables_" + settings.sInstance + "_" + location.pathname,
        JSON.stringify(data)
      );
    } catch (e) {
    }
  },
  /**
   * Callback which allows modification of the state to be saved. Called when the table
   * has changed state a new state save is required. This method allows modification of
   * the state saving object prior to actually doing the save, including addition or
   * other state properties or modification. Note that for plug-in authors, you should
   * use the `stateSaveParams` event to save parameters for a plug-in.
   */
  "fnStateSaveParams": null,
  /**
   * Duration for which the saved state information is considered valid. After this period
   * has elapsed the state will be returned to the default.
   * Value is given in seconds.
   */
  "iStateDuration": 7200,
  /**
   * Number of rows to display on a single page when using pagination. If
   * feature enabled (`lengthChange`) then the end user will be able to override
   * this to a custom setting using a pop-up menu.
   */
  "iDisplayLength": 10,
  /**
   * Define the starting point for data display when using DataTables with
   * pagination. Note that this parameter is the number of records, rather than
   * the page number, so if you have 10 records per page and want to start on
   * the third page, it should be "20".
   */
  "iDisplayStart": 0,
  /**
   * By default DataTables allows keyboard navigation of the table (sorting, paging,
   * and filtering) by adding a `tabindex` attribute to the required elements. This
   * allows you to tab through the controls and press the enter key to activate them.
   * The tabindex is default 0, meaning that the tab follows the flow of the document.
   * You can overrule this using this parameter if you wish. Use a value of -1 to
   * disable built-in keyboard navigation.
   */
  "iTabIndex": 0,
  /**
   * Classes that DataTables assigns to the various components and features
   * that it adds to the HTML table. This allows classes to be configured
   * during initialisation in addition to through the static
   * {@link DataTable.ext.oStdClasses} object).
   */
  "oClasses": {},
  /**
   * All strings that DataTables uses in the user interface that it creates
   * are defined in this object, allowing you to modified them individually or
   * completely replace them all as required.
   */
  "oLanguage": {
    /**
     * Strings that are used for WAI-ARIA labels and controls only (these are not
     * actually visible on the page, but will be read by screenreaders, and thus
     * must be internationalised as well).
     */
    "oAria": {
      /**
       * ARIA label that is added to the table headers when the column may be sorted
       */
      "orderable": ": Activate to sort",
      /**
       * ARIA label that is added to the table headers when the column is currently being sorted
       */
      "orderableReverse": ": Activate to invert sorting",
      /**
       * ARIA label that is added to the table headers when the column is currently being 
       * sorted and next step is to remove sorting
       */
      "orderableRemove": ": Activate to remove sorting",
      paginate: {
        first: "First",
        last: "Last",
        next: "Next",
        previous: "Previous",
        number: ""
      }
    },
    /**
     * Pagination string used by DataTables for the built-in pagination
     * control types.
     */
    "oPaginate": {
      /**
       * Label and character for first page button («)
       */
      "sFirst": "«",
      /**
       * Last page button (»)
       */
      "sLast": "»",
      /**
       * Next page button (›)
       */
      "sNext": "›",
      /**
       * Previous page button (‹)
       */
      "sPrevious": "‹"
    },
    /**
     * Plural object for the data type the table is showing
     */
    entries: {
      _: "entries",
      1: "entry"
    },
    /**
     * Page length options
     */
    lengthLabels: {
      "-1": "All"
    },
    /**
     * This string is shown in preference to `zeroRecords` when the table is
     * empty of data (regardless of filtering). Note that this is an optional
     * parameter - if it is not given, the value of `zeroRecords` will be used
     * instead (either the default or given value).
     */
    "sEmptyTable": "No data available in table",
    /**
     * This string gives information to the end user about the information
     * that is current on display on the page. The following tokens can be
     * used in the string and will be dynamically replaced as the table
     * display updates. This tokens can be placed anywhere in the string, or
     * removed as needed by the language requires:
     *
     * * `\_START\_` - Display index of the first record on the current page
     * * `\_END\_` - Display index of the last record on the current page
     * * `\_TOTAL\_` - Number of records in the table after filtering
     * * `\_MAX\_` - Number of records in the table without filtering
     * * `\_PAGE\_` - Current page number
     * * `\_PAGES\_` - Total number of pages of data in the table
     */
    "sInfo": "Showing _START_ to _END_ of _TOTAL_ _ENTRIES-TOTAL_",
    /**
     * Display information string for when the table is empty. Typically the
     * format of this string should match `info`.
     */
    "sInfoEmpty": "Showing 0 to 0 of 0 _ENTRIES-TOTAL_",
    /**
     * When a user filters the information in a table, this string is appended
     * to the information (`info`) to give an idea of how strong the filtering
     * is. The variable _MAX_ is dynamically updated.
     */
    "sInfoFiltered": "(filtered from _MAX_ total _ENTRIES-MAX_)",
    /**
     * If can be useful to append extra information to the info string at times,
     * and this variable does exactly that. This information will be appended to
     * the `info` (`infoEmpty` and `infoFiltered` in whatever combination they are
     * being used) at all times.
     */
    "sInfoPostFix": "",
    /**
     * This decimal place operator is a little different from the other
     * language options since DataTables doesn't output floating point
     * numbers, so it won't ever use this for display of a number. Rather,
     * what this parameter does is modify the sort methods of the table so
     * that numbers which are in a format which has a character other than
     * a period (`.`) as a decimal place will be sorted numerically.
     *
     * Note that numbers with different decimal places cannot be shown in
     * the same table and still be sortable, the table must be consistent.
     * However, multiple different tables on the page can use different
     * decimal place characters.
     */
    "sDecimal": "",
    /**
     * DataTables has a build in number formatter (`formatNumber`) which is
     * used to format large numbers that are used in the table information.
     * By default a comma is used, but this can be trivially changed to any
     * character you wish with this parameter.
     */
    "sThousands": ",",
    /**
     * Detail the action that will be taken when the drop down menu for the
     * pagination length option is changed. The '_MENU_' variable is replaced
     * with a default select list of 10, 25, 50 and 100, and can be replaced
     * with a custom select box if required.
     */
    "sLengthMenu": "_MENU_ _ENTRIES_ per page",
    /**
     * When using Ajax sourced data and during the first draw when DataTables is
     * gathering the data, this message is shown in an empty row in the table to
     * indicate to the end user the data is being loaded. Note that this
     * parameter is not used when loading data by server-side processing, just
     * Ajax sourced data with client-side processing.
     */
    "sLoadingRecords": "Loading...",
    /**
     * Text which is displayed when the table is processing a user action
     * (usually a sort command or similar).
     */
    "sProcessing": "",
    /**
     * Details the actions that will be taken when the user types into the
     * filtering input text box. The variable "_INPUT_", if used in the string,
     * is replaced with the HTML text box for the filtering input allowing
     * control over where it appears in the string. If "_INPUT_" is not given
     * then the input box is appended to the string automatically.
     */
    "sSearch": "Search:",
    /**
     * Assign a `placeholder` attribute to the search `input` element
     *  @type string
     *  @default 
     *
     *  @dtopt Language
     *  @name DataTable.defaults.language.searchPlaceholder
     */
    "sSearchPlaceholder": "",
    /**
     * All of the language information can be stored in a file on the
     * server-side, which DataTables will look up if this parameter is passed.
     * It must store the URL of the language file, which is in a JSON format,
     * and the object has the same properties as the oLanguage object in the
     * initialiser object (i.e. the above parameters). Please refer to one of
     * the example language files to see how this works in action.
     */
    "sUrl": "",
    /**
     * Text shown inside the table records when the is no information to be
     * displayed after filtering. `emptyTable` is shown when there is simply no
     * information in the table at all (regardless of filtering).
     */
    "sZeroRecords": "No matching records found"
  },
  /** The initial data order is reversed when `desc` ordering */
  orderDescReverse: true,
  /**
   * This parameter allows you to have define the global filtering state at
   * initialisation time. As an object the `search` parameter must be
   * defined, but all other parameters are optional. When `regex` is true,
   * the search string will be treated as a regular expression, when false
   * (default) it will be treated as a straight string. When `smart`
   * DataTables will use it's smart filtering methods (to word match at
   * any point in the data), when false this will not be done.
   */
  "oSearch": $.extend({}, DataTable.models.oSearch),
  /**
   * Table and control layout. This replaces the legacy `dom` option.
   */
  layout: {
    topStart: "pageLength",
    topEnd: "search",
    bottomStart: "info",
    bottomEnd: "paging"
  },
  /**
   * Legacy DOM layout option
   */
  "sDom": null,
  /**
   * Search delay option. This will throttle full table searches that use the
   * DataTables provided search input element (it does not effect calls to
   * `dt-api search()`, providing a delay before the search is made.
   */
  "searchDelay": null,
  /**
   * DataTables features six different built-in options for the buttons to
   * display for pagination control:
   *
   * * `numbers` - Page number buttons only
   * * `simple` - 'Previous' and 'Next' buttons only
   * * 'simple_numbers` - 'Previous' and 'Next' buttons, plus page numbers
   * * `full` - 'First', 'Previous', 'Next' and 'Last' buttons
   * * `full_numbers` - 'First', 'Previous', 'Next' and 'Last' buttons, plus page numbers
   * * `first_last_numbers` - 'First' and 'Last' buttons, plus page numbers
   */
  "sPaginationType": "",
  /**
   * Enable horizontal scrolling. When a table is too wide to fit into a
   * certain layout, or you have a large number of columns in the table, you
   * can enable x-scrolling to show the table in a viewport, which can be
   * scrolled. This property can be `true` which will allow the table to
   * scroll horizontally when needed, or any CSS unit, or a number (in which
   * case it will be treated as a pixel measurement). Setting as simply `true`
   * is recommended.
   */
  "sScrollX": "",
  /**
   * This property can be used to force a DataTable to use more width than it
   * might otherwise do when x-scrolling is enabled. For example if you have a
   * table which requires to be well spaced, this parameter is useful for
   * "over-sizing" the table, and thus forcing scrolling. This property can by
   * any CSS unit, or a number (in which case it will be treated as a pixel
   * measurement).
   */
  "sScrollXInner": "",
  /**
   * Enable vertical scrolling. Vertical scrolling will constrain the DataTable
   * to the given height, and enable scrolling for any data which overflows the
   * current viewport. This can be used as an alternative to paging to display
   * a lot of data in a small area (although paging and scrolling can both be
   * enabled at the same time). This property can be any CSS unit, or a number
   * (in which case it will be treated as a pixel measurement).
   */
  "sScrollY": "",
  /**
   * __Deprecated__ The functionality provided by this parameter has now been
   * superseded by that provided through `ajax`, which should be used instead.
   *
   * Set the HTTP method that is used to make the Ajax call for server-side
   * processing or Ajax sourced data.
   */
  "sServerMethod": "GET",
  /**
   * DataTables makes use of renderers when displaying HTML elements for
   * a table. These renderers can be added or modified by plug-ins to
   * generate suitable mark-up for a site. For example the Bootstrap
   * integration plug-in for DataTables uses a paging button renderer to
   * display pagination buttons in the mark-up required by Bootstrap.
   *
   * For further information about the renderers available see
   * DataTable.ext.renderer
   */
  "renderer": null,
  /**
   * Set the data property name that DataTables should use to get a row's id
   * to set as the `id` property in the node.
   */
  "rowId": "DT_RowId",
  /**
   * Caption value
   */
  "caption": null,
  /**
   * For server-side processing - use the data from the DOM for the first draw
   */
  iDeferLoading: null,
  /** Event listeners */
  on: null
};
_fnHungarianMap(DataTable.defaults);
DataTable.defaults.column = {
  /**
   * Define which column(s) an order will occur on for this column. This
   * allows a column's ordering to take multiple columns into account when
   * doing a sort or use the data from a different column. For example first
   * name / last name columns make sense to do a multi-column sort over the
   * two columns.
   */
  "aDataSort": null,
  "iDataSort": -1,
  ariaTitle: "",
  /**
   * You can control the default ordering direction, and even alter the
   * behaviour of the sort handler (i.e. only allow ascending ordering etc)
   * using this parameter.
   */
  "asSorting": ["asc", "desc", ""],
  /**
   * Enable or disable filtering on the data in this column.
   */
  "bSearchable": true,
  /**
   * Enable or disable ordering on this column.
   */
  "bSortable": true,
  /**
   * Enable or disable the display of this column.
   */
  "bVisible": true,
  /**
   * Developer definable function that is called whenever a cell is created (Ajax source,
   * etc) or processed for input (DOM source). This can be used as a compliment to mRender
   * allowing you to modify the DOM element (add background colour for example) when the
   * element is available.
   */
  "fnCreatedCell": null,
  /**
   * This property can be used to read data from any data source property,
   * including deeply nested objects / properties. `data` can be given in a
   * number of different ways which effect its behaviour:
   *
   * * `integer` - treated as an array index for the data source. This is the
   *   default that DataTables uses (incrementally increased for each column).
   * * `string` - read an object property from the data source. There are
   *   three 'special' options that can be used in the string to alter how
   *   DataTables reads the data from the source object:
   *    * `.` - Dotted JavaScript notation. Just as you use a `.` in
   *      JavaScript to read from nested objects, so to can the options
   *      specified in `data`. For example: `browser.version` or
   *      `browser.name`. If your object parameter name contains a period, use
   *      `\\` to escape it - i.e. `first\\.name`.
   *    * `[]` - Array notation. DataTables can automatically combine data
   *      from and array source, joining the data with the characters provided
   *      between the two brackets. For example: `name[, ]` would provide a
   *      comma-space separated list from the source array. If no characters
   *      are provided between the brackets, the original array source is
   *      returned.
   *    * `()` - Function notation. Adding `()` to the end of a parameter will
   *      execute a function of the name given. For example: `browser()` for a
   *      simple function on the data source, `browser.version()` for a
   *      function in a nested property or even `browser().version` to get an
   *      object property if the function called returns an object. Note that
   *      function notation is recommended for use in `render` rather than
   *      `data` as it is much simpler to use as a renderer.
   * * `null` - use the original data source for the row rather than plucking
   *   data directly from it. This action has effects on two other
   *   initialisation options:
   *    * `defaultContent` - When null is given as the `data` option and
   *      `defaultContent` is specified for the column, the value defined by
   *      `defaultContent` will be used for the cell.
   *    * `render` - When null is used for the `data` option and the `render`
   *      option is specified for the column, the whole data source for the
   *      row is used for the renderer.
   * * `function` - the function given will be executed whenever DataTables
   *   needs to set or get the data for a cell in the column. The function
   *   takes three parameters:
   *    * Parameters:
   *      * `{array|object}` The data source for the row
   *      * `{string}` The type call data requested - this will be 'set' when
   *        setting data or 'filter', 'display', 'type', 'sort' or undefined
   *        when gathering data. Note that when `undefined` is given for the
   *        type DataTables expects to get the raw data for the object back<
   *      * `{*}` Data to set when the second parameter is 'set'.
   *    * Return:
   *      * The return value from the function is not required when 'set' is
   *        the type of call, but otherwise the return is what will be used
   *        for the data requested.
   *
   * Note that `data` is a getter and setter option. If you just require
   * formatting of data for output, you will likely want to use `render` which
   * is simply a getter and thus simpler to use.
   *
   * Note that prior to DataTables 1.9.2 `data` was called `mDataProp`. The
   * name change reflects the flexibility of this property and is consistent
   * with the naming of mRender. If 'mDataProp' is given, then it will still
   * be used by DataTables, as it automatically maps the old name to the new
   * if required.
   */
  "mData": null,
  /**
   * This property is the rendering partner to `data` and it is suggested that
   * when you want to manipulate data for display (including filtering,
   * sorting etc) without altering the underlying data for the table, use this
   * property. `render` can be considered to be the read only companion to
   * `data` which is read / write (then as such more complex). Like `data`
   * this option can be given in a number of different ways to effect its
   * behaviour:
   *
   * * `integer` - treated as an array index for the data source. This is the
   *   default that DataTables uses (incrementally increased for each column).
   * * `string` - read an object property from the data source. There are
   *   three 'special' options that can be used in the string to alter how
   *   DataTables reads the data from the source object:
   *    * `.` - Dotted JavaScript notation. Just as you use a `.` in
   *      JavaScript to read from nested objects, so to can the options
   *      specified in `data`. For example: `browser.version` or
   *      `browser.name`. If your object parameter name contains a period, use
   *      `\\` to escape it - i.e. `first\\.name`.
   *    * `[]` - Array notation. DataTables can automatically combine data
   *      from and array source, joining the data with the characters provided
   *      between the two brackets. For example: `name[, ]` would provide a
   *      comma-space separated list from the source array. If no characters
   *      are provided between the brackets, the original array source is
   *      returned.
   *    * `()` - Function notation. Adding `()` to the end of a parameter will
   *      execute a function of the name given. For example: `browser()` for a
   *      simple function on the data source, `browser.version()` for a
   *      function in a nested property or even `browser().version` to get an
   *      object property if the function called returns an object.
   * * `object` - use different data for the different data types requested by
   *   DataTables ('filter', 'display', 'type' or 'sort'). The property names
   *   of the object is the data type the property refers to and the value can
   *   defined using an integer, string or function using the same rules as
   *   `render` normally does. Note that an `_` option _must_ be specified.
   *   This is the default value to use if you haven't specified a value for
   *   the data type requested by DataTables.
   * * `function` - the function given will be executed whenever DataTables
   *   needs to set or get the data for a cell in the column. The function
   *   takes three parameters:
   *    * Parameters:
   *      * {array|object} The data source for the row (based on `data`)
   *      * {string} The type call data requested - this will be 'filter',
   *        'display', 'type' or 'sort'.
   *      * {array|object} The full data source for the row (not based on
   *        `data`)
   *    * Return:
   *      * The return value from the function is what will be used for the
   *        data requested.
   */
  "mRender": null,
  /**
   * Change the cell type created for the column - either TD cells or TH cells. This
   * can be useful as TH cells have semantic meaning in the table body, allowing them
   * to act as a header for a row (you may wish to add scope='row' to the TH elements).
   */
  "sCellType": "td",
  /**
   * Class to give to each cell in this column.
   */
  "sClass": "",
  /**
   * When DataTables calculates the column widths to assign to each column,
   * it finds the longest string in each column and then constructs a
   * temporary table and reads the widths from that. The problem with this
   * is that "mmm" is much wider then "iiii", but the latter is a longer
   * string - thus the calculation can go wrong (doing it properly and putting
   * it into an DOM object and measuring that is horribly(!) slow). Thus as
   * a "work around" we provide this option. It will append its value to the
   * text that is found to be the longest string for the column - i.e. padding.
   * Generally you shouldn't need this!
   */
  "sContentPadding": "",
  /**
   * Allows a default value to be given for a column's data, and will be used
   * whenever a null data source is encountered (this can be because `data`
   * is set to null, or because the data source itself is null).
   */
  "sDefaultContent": null,
  /**
   * This parameter is only used in DataTables' server-side processing. It can
   * be exceptionally useful to know what columns are being displayed on the
   * client side, and to map these to database fields. When defined, the names
   * also allow DataTables to reorder information from the server if it comes
   * back in an unexpected order (i.e. if you switch your columns around on the
   * client-side, your server-side code does not also need updating).
   */
  "sName": "",
  /**
   * Defines a data source type for the ordering which can be used to read
   * real-time information from the table (updating the internally cached
   * version) prior to ordering. This allows ordering to occur on user
   * editable elements such as form inputs.
   */
  "sSortDataType": "std",
  /**
   * The title of this column.
   */
  "sTitle": null,
  /**
   * The type allows you to specify how the data for this column will be
   * ordered. Four types (string, numeric, date and html (which will strip
   * HTML tags before ordering)) are currently available. Note that only date
   * formats understood by JavaScript's Date() object will be accepted as type
   * date. For example: "Mar 26, 2008 5:03 PM". May take the values: 'string',
   * 'numeric', 'date' or 'html' (by default). Further types can be adding
   * through plug-ins.
   */
  "sType": null,
  /**
   * Defining the width of the column, this parameter may take any CSS value
   * (3em, 20px etc). DataTables applies 'smart' widths to columns which have not
   * been given a specific width through this interface ensuring that the table
   * remains readable.
   */
  "sWidth": null
};
_fnHungarianMap(DataTable.defaults.column);
DataTable.models.oSettings = {
  /**
   * Primary features of DataTables and their enablement state.
   */
  "oFeatures": {
    /**
     * Flag to say if DataTables should automatically try to calculate the
     * optimum table and columns widths (true) or not (false).
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "bAutoWidth": null,
    /**
     * Delay the creation of TR and TD elements until they are actually
     * needed by a driven page draw. This can give a significant speed
     * increase for Ajax source and JavaScript source data, but makes no
     * difference at all for DOM and server-side processing tables.
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "bDeferRender": null,
    /**
     * Enable filtering on the table or not. Note that if this is disabled
     * then there is no filtering at all on the table, including fnFilter.
     * To just remove the filtering input use sDom and remove the 'f' option.
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "bFilter": null,
    /**
     * Used only for compatibility with DT1
     * @deprecated
     */
    "bInfo": true,
    /**
     * Used only for compatibility with DT1
     * @deprecated
     */
    "bLengthChange": true,
    /**
     * Pagination enabled or not. Note that if this is disabled then length
     * changing must also be disabled.
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "bPaginate": null,
    /**
     * Processing indicator enable flag whenever DataTables is enacting a
     * user request - typically an Ajax request for server-side processing.
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "bProcessing": null,
    /**
     * Server-side processing enabled flag - when enabled DataTables will
     * get all data from the server for every draw - there is no filtering,
     * sorting or paging done on the client-side.
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "bServerSide": null,
    /**
     * Sorting enablement flag.
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "bSort": null,
    /**
     * Multi-column sorting
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "bSortMulti": null,
    /**
     * Apply a class to the columns which are being sorted to provide a
     * visual highlight or not. This can slow things down when enabled since
     * there is a lot of DOM interaction.
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "bSortClasses": null,
    /**
     * State saving enablement flag.
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "bStateSave": null
  },
  /**
   * Scrolling settings for a table.
   */
  "oScroll": {
    /**
     * When the table is shorter in height than sScrollY, collapse the
     * table container down to the height of the table (when true).
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "bCollapse": null,
    /**
     * Width of the scrollbar for the web-browser's platform. Calculated
     * during table initialisation.
     */
    "iBarWidth": 0,
    /**
     * Viewport width for horizontal scrolling. Horizontal scrolling is
     * disabled if an empty string.
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "sX": null,
    /**
     * Width to expand the table to when using x-scrolling. Typically you
     * should not need to use this.
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     *  @deprecated
     */
    "sXInner": null,
    /**
     * Viewport height for vertical scrolling. Vertical scrolling is disabled
     * if an empty string.
     * Note that this parameter will be set by the initialisation routine. To
     * set a default use {@link DataTable.defaults}.
     */
    "sY": null
  },
  /**
   * Language information for the table.
   */
  "oLanguage": {
    /**
     * Information callback function. See
     * {@link DataTable.defaults.fnInfoCallback}
     */
    "fnInfoCallback": null
  },
  /**
   * Browser support parameters
   */
  "oBrowser": {
    /**
     * Determine if the vertical scrollbar is on the right or left of the
     * scrolling container - needed for rtl language layout, although not
     * all browsers move the scrollbar (Safari).
     */
    "bScrollbarLeft": false,
    /**
     * Browser scrollbar width
     */
    "barWidth": 0
  },
  "ajax": null,
  /**
   * Array referencing the nodes which are used for the features. The
   * parameters of this object match what is allowed by sDom - i.e.
   *   <ul>
   *     <li>'l' - Length changing</li>
   *     <li>'f' - Filtering input</li>
   *     <li>'t' - The table!</li>
   *     <li>'i' - Information</li>
   *     <li>'p' - Pagination</li>
   *     <li>'r' - pRocessing</li>
   *   </ul>
   */
  "aanFeatures": [],
  /**
   * Store data information - see {@link DataTable.models.oRow} for detailed
   * information.
   */
  "aoData": [],
  /**
   * Array of indexes which are in the current display (after filtering etc)
   */
  "aiDisplay": [],
  /**
   * Array of indexes for display - no filtering
   */
  "aiDisplayMaster": [],
  /**
   * Map of row ids to data indexes
   */
  "aIds": {},
  /**
   * Store information about each column that is in use
   */
  "aoColumns": [],
  /**
   * Store information about the table's header
   */
  "aoHeader": [],
  /**
   * Store information about the table's footer
   */
  "aoFooter": [],
  /**
   * Store the applied global search information in case we want to force a
   * research or compare the old search to a new one.
   * Note that this parameter will be set by the initialisation routine. To
   * set a default use {@link DataTable.defaults}.
   */
  "oPreviousSearch": {},
  /**
   * Store for named searches
   */
  searchFixed: {},
  /**
   * Store the applied search for each column - see
   * {@link DataTable.models.oSearch} for the format that is used for the
   * filtering information for each column.
   */
  "aoPreSearchCols": [],
  /**
   * Sorting that is applied to the table. Note that the inner arrays are
   * used in the following manner:
   * <ul>
   *   <li>Index 0 - column number</li>
   *   <li>Index 1 - current sorting direction</li>
   * </ul>
   * Note that this parameter will be set by the initialisation routine. To
   * set a default use {@link DataTable.defaults}.
   */
  "aaSorting": null,
  /**
   * Sorting that is always applied to the table (i.e. prefixed in front of
   * aaSorting).
   * Note that this parameter will be set by the initialisation routine. To
   * set a default use {@link DataTable.defaults}.
   */
  "aaSortingFixed": [],
  /**
   * If restoring a table - we should restore its width
   */
  "sDestroyWidth": 0,
  /**
   * Callback functions array for every time a row is inserted (i.e. on a draw).
   */
  "aoRowCallback": [],
  /**
   * Callback functions for the header on each draw.
   */
  "aoHeaderCallback": [],
  /**
   * Callback function for the footer on each draw.
   */
  "aoFooterCallback": [],
  /**
   * Array of callback functions for draw callback functions
   */
  "aoDrawCallback": [],
  /**
   * Array of callback functions for row created function
   */
  "aoRowCreatedCallback": [],
  /**
   * Callback functions for just before the table is redrawn. A return of
   * false will be used to cancel the draw.
   */
  "aoPreDrawCallback": [],
  /**
   * Callback functions for when the table has been initialised.
   */
  "aoInitComplete": [],
  /**
   * Callbacks for modifying the settings to be stored for state saving, prior to
   * saving state.
   */
  "aoStateSaveParams": [],
  /**
   * Callbacks for modifying the settings that have been stored for state saving
   * prior to using the stored values to restore the state.
   */
  "aoStateLoadParams": [],
  /**
   * Callbacks for operating on the settings object once the saved state has been
   * loaded
   */
  "aoStateLoaded": [],
  /**
   * Cache the table ID for quick access
   */
  "sTableId": "",
  /**
   * The TABLE node for the main table
   */
  "nTable": null,
  /**
   * Permanent ref to the thead element
   */
  "nTHead": null,
  /**
   * Permanent ref to the tfoot element - if it exists
   */
  "nTFoot": null,
  /**
   * Permanent ref to the tbody element
   */
  "nTBody": null,
  /**
   * Cache the wrapper node (contains all DataTables controlled elements)
   */
  "nTableWrapper": null,
  /**
   * Indicate if all required information has been read in
   */
  "bInitialised": false,
  /**
   * Information about open rows. Each object in the array has the parameters
   * 'nTr' and 'nParent'
   */
  "aoOpenRows": [],
  /**
   * Dictate the positioning of DataTables' control elements - see
   * {@link DataTable.model.oInit.sDom}.
   * Note that this parameter will be set by the initialisation routine. To
   * set a default use {@link DataTable.defaults}.
   */
  "sDom": null,
  /**
   * Search delay (in mS)
   */
  "searchDelay": null,
  /**
   * Which type of pagination should be used.
   * Note that this parameter will be set by the initialisation routine. To
   * set a default use {@link DataTable.defaults}.
   */
  "sPaginationType": "two_button",
  /**
   * Number of paging controls on the page. Only used for backwards compatibility
   */
  pagingControls: 0,
  /**
   * The state duration (for `stateSave`) in seconds.
   * Note that this parameter will be set by the initialisation routine. To
   * set a default use {@link DataTable.defaults}.
   */
  "iStateDuration": 0,
  /**
   * Array of callback functions for state saving. Each array element is an
   * object with the following parameters:
   *   <ul>
   *     <li>function:fn - function to call. Takes two parameters, oSettings
   *       and the JSON string to save that has been thus far created. Returns
   *       a JSON string to be inserted into a json object
   *       (i.e. '"param": [ 0, 1, 2]')</li>
   *     <li>string:sName - name of callback</li>
   *   </ul>
   */
  "aoStateSave": [],
  /**
   * Array of callback functions for state loading. Each array element is an
   * object with the following parameters:
   *   <ul>
   *     <li>function:fn - function to call. Takes two parameters, oSettings
   *       and the object stored. May return false to cancel state loading</li>
   *     <li>string:sName - name of callback</li>
   *   </ul>
   */
  "aoStateLoad": [],
  /**
   * State that was saved. Useful for back reference
   */
  "oSavedState": null,
  /**
   * State that was loaded. Useful for back reference
   */
  "oLoadedState": null,
  /**
   * Note if draw should be blocked while getting data
   */
  "bAjaxDataGet": true,
  /**
   * The last jQuery XHR object that was used for server-side data gathering.
   * This can be used for working with the XHR information in one of the
   * callbacks
   */
  "jqXHR": null,
  /**
   * JSON returned from the server in the last Ajax request
   */
  "json": void 0,
  /**
   * Data submitted as part of the last Ajax request
   */
  "oAjaxData": void 0,
  /**
   * Send the XHR HTTP method - GET or POST (could be PUT or DELETE if
   * required).
   * Note that this parameter will be set by the initialisation routine. To
   * set a default use {@link DataTable.defaults}.
   */
  "sServerMethod": null,
  /**
   * Format numbers for display.
   * Note that this parameter will be set by the initialisation routine. To
   * set a default use {@link DataTable.defaults}.
   */
  "fnFormatNumber": null,
  /**
   * List of options that can be used for the user selectable length menu.
   * Note that this parameter will be set by the initialisation routine. To
   * set a default use {@link DataTable.defaults}.
   */
  "aLengthMenu": null,
  /**
   * Counter for the draws that the table does. Also used as a tracker for
   * server-side processing
   */
  "iDraw": 0,
  /**
   * Indicate if a redraw is being done - useful for Ajax
   */
  "bDrawing": false,
  /**
   * Draw index (iDraw) of the last error when parsing the returned data
   */
  "iDrawError": -1,
  /**
   * Paging display length
   */
  "_iDisplayLength": 10,
  /**
   * Paging start point - aiDisplay index
   */
  "_iDisplayStart": 0,
  /**
   * Server-side processing - number of records in the result set
   * (i.e. before filtering), Use fnRecordsTotal rather than
   * this property to get the value of the number of records, regardless of
   * the server-side processing setting.
   */
  "_iRecordsTotal": 0,
  /**
   * Server-side processing - number of records in the current display set
   * (i.e. after filtering). Use fnRecordsDisplay rather than
   * this property to get the value of the number of records, regardless of
   * the server-side processing setting.
   */
  "_iRecordsDisplay": 0,
  /**
   * The classes to use for the table
   */
  "oClasses": {},
  /**
   * Flag attached to the settings object so you can check in the draw
   * callback if filtering has been done in the draw. Deprecated in favour of
   * events.
   *  @deprecated
   */
  "bFiltered": false,
  /**
   * Flag attached to the settings object so you can check in the draw
   * callback if sorting has been done in the draw. Deprecated in favour of
   * events.
   *  @deprecated
   */
  "bSorted": false,
  /**
   * Indicate that if multiple rows are in the header and there is more than
   * one unique cell per column. Replaced by titleRow
   */
  "bSortCellsTop": null,
  /**
   * Initialisation object that is used for the table
   */
  "oInit": null,
  /**
   * Destroy callback functions - for plug-ins to attach themselves to the
   * destroy so they can clean up markup and events.
   */
  "aoDestroyCallback": [],
  /**
   * Get the number of records in the current record set, before filtering
   */
  "fnRecordsTotal": function() {
    return _fnDataSource(this) == "ssp" ? this._iRecordsTotal * 1 : this.aiDisplayMaster.length;
  },
  /**
   * Get the number of records in the current record set, after filtering
   */
  "fnRecordsDisplay": function() {
    return _fnDataSource(this) == "ssp" ? this._iRecordsDisplay * 1 : this.aiDisplay.length;
  },
  /**
   * Get the display end point - aiDisplay index
   */
  "fnDisplayEnd": function() {
    var len = this._iDisplayLength, start = this._iDisplayStart, calc = start + len, records = this.aiDisplay.length, features = this.oFeatures, paginate = features.bPaginate;
    if (features.bServerSide) {
      return paginate === false || len === -1 ? start + records : Math.min(start + len, this._iRecordsDisplay);
    } else {
      return !paginate || calc > records || len === -1 ? records : calc;
    }
  },
  /**
   * The DataTables object for this table
   */
  "oInstance": null,
  /**
   * Unique identifier for each instance of the DataTables object. If there
   * is an ID on the table node, then it takes that value, otherwise an
   * incrementing internal counter is used.
   */
  "sInstance": null,
  /**
   * tabindex attribute value that is added to DataTables control elements, allowing
   * keyboard navigation of the table and its controls.
   */
  "iTabIndex": 0,
  /**
   * DIV container for the footer scrolling table if scrolling
   */
  "nScrollHead": null,
  /**
   * DIV container for the footer scrolling table if scrolling
   */
  "nScrollFoot": null,
  /**
   * Last applied sort
   */
  "aLastSort": [],
  /**
   * Stored plug-in instances
   */
  "oPlugins": {},
  /**
   * Function used to get a row's id from the row's data
   */
  "rowIdFn": null,
  /**
   * Data location where to store a row's id
   */
  "rowId": null,
  caption: "",
  captionNode: null,
  colgroup: null,
  /** Delay loading of data */
  deferLoading: null,
  /** Allow auto type detection */
  typeDetect: true,
  /** ResizeObserver for the container div */
  resizeObserver: null,
  /** Keep a record of the last size of the container, so we can skip duplicates */
  containerWidth: -1,
  /** Reverse the initial order of the data set on desc ordering */
  orderDescReverse: null,
  /** Show / hide ordering indicators in headers */
  orderIndicators: true,
  /** Default ordering listener */
  orderHandler: true,
  /** Title row indicator */
  titleRow: null
};
var extPagination = DataTable.ext.pager;
$.extend(extPagination, {
  simple: function() {
    return ["previous", "next"];
  },
  full: function() {
    return ["first", "previous", "next", "last"];
  },
  numbers: function() {
    return ["numbers"];
  },
  simple_numbers: function() {
    return ["previous", "numbers", "next"];
  },
  full_numbers: function() {
    return ["first", "previous", "numbers", "next", "last"];
  },
  first_last: function() {
    return ["first", "last"];
  },
  first_last_numbers: function() {
    return ["first", "numbers", "last"];
  },
  // For testing and plug-ins to use
  _numbers: _pagingNumbers,
  // Number of number buttons - legacy, use `numbers` option for paging feature
  numbers_length: 7
});
$.extend(true, DataTable.ext.renderer, {
  pagingButton: {
    _: function(settings, buttonType, content, active, disabled) {
      var classes = settings.oClasses.paging;
      var btnClasses = [classes.button];
      var btn;
      if (active) {
        btnClasses.push(classes.active);
      }
      if (disabled) {
        btnClasses.push(classes.disabled);
      }
      if (buttonType === "ellipsis") {
        btn = $('<span class="ellipsis"></span>').html(content)[0];
      } else {
        btn = $("<button>", {
          class: btnClasses.join(" "),
          role: "link",
          type: "button"
        }).html(content);
      }
      return {
        display: btn,
        clicker: btn
      };
    }
  },
  pagingContainer: {
    _: function(settings, buttons) {
      return buttons;
    }
  }
});
var _filterString = function(stripHtml, normalize) {
  return function(str) {
    if (_empty(str) || typeof str !== "string") {
      return str;
    }
    str = str.replace(_re_new_lines, " ");
    if (stripHtml) {
      str = _stripHtml(str);
    }
    {
      str = _normalize(str, false);
    }
    return str;
  };
};
function __mld(dtLib, momentFn, luxonFn, dateFn, arg1) {
  if (__moment) {
    return dtLib[momentFn](arg1);
  } else if (__luxon) {
    return dtLib[luxonFn](arg1);
  }
  return dateFn ? dtLib[dateFn](arg1) : dtLib;
}
var __mlWarning = false;
var __luxon;
var __moment;
function resolveWindowLibs() {
  if (window.luxon && !__luxon) {
    __luxon = window.luxon;
  }
  if (window.moment && !__moment) {
    __moment = window.moment;
  }
}
function __mldObj(d, format, locale) {
  var dt;
  resolveWindowLibs();
  if (__moment) {
    dt = __moment.utc(d, format, locale, true);
    if (!dt.isValid()) {
      return null;
    }
  } else if (__luxon) {
    dt = format && typeof d === "string" ? __luxon.DateTime.fromFormat(d, format) : __luxon.DateTime.fromISO(d);
    if (!dt.isValid) {
      return null;
    }
    dt = dt.setLocale(locale);
  } else if (!format) {
    dt = new Date(d);
  } else {
    if (!__mlWarning) {
      alert("DataTables warning: Formatted date without Moment.js or Luxon - https://datatables.net/tn/17");
    }
    __mlWarning = true;
  }
  return dt;
}
function __mlHelper(localeString) {
  return function(from, to, locale, def) {
    if (arguments.length === 0) {
      locale = "en";
      to = null;
      from = null;
    } else if (arguments.length === 1) {
      locale = "en";
      to = from;
      from = null;
    } else if (arguments.length === 2) {
      locale = to;
      to = from;
      from = null;
    }
    var typeName = "datetime" + (to ? "-" + to : "");
    if (!DataTable.ext.type.order[typeName + "-pre"]) {
      DataTable.type(typeName, {
        detect: function(d) {
          return d === typeName ? typeName : false;
        },
        order: {
          pre: function(d) {
            return d.valueOf();
          }
        },
        className: "dt-right"
      });
    }
    return function(d, type) {
      if (d === null || d === void 0) {
        if (def === "--now") {
          var local = /* @__PURE__ */ new Date();
          d = new Date(Date.UTC(
            local.getFullYear(),
            local.getMonth(),
            local.getDate(),
            local.getHours(),
            local.getMinutes(),
            local.getSeconds()
          ));
        } else {
          d = "";
        }
      }
      if (type === "type") {
        return typeName;
      }
      if (d === "") {
        return type !== "sort" ? "" : __mldObj("0000-01-01 00:00:00", null, locale);
      }
      if (to !== null && from === to && type !== "sort" && type !== "type" && !(d instanceof Date)) {
        return d;
      }
      var dt = __mldObj(d, from, locale);
      if (dt === null) {
        return d;
      }
      if (type === "sort") {
        return dt;
      }
      var formatted = to === null ? __mld(dt, "toDate", "toJSDate", "")[localeString](
        navigator.language,
        { timeZone: "UTC" }
      ) : __mld(dt, "format", "toFormat", "toISOString", to);
      return type === "display" ? _escapeHtml(formatted) : formatted;
    };
  };
}
var __thousands = ",";
var __decimal = ".";
if (window.Intl !== void 0) {
  try {
    var num = new Intl.NumberFormat().formatToParts(100000.1);
    for (var i = 0; i < num.length; i++) {
      if (num[i].type === "group") {
        __thousands = num[i].value;
      } else if (num[i].type === "decimal") {
        __decimal = num[i].value;
      }
    }
  } catch (e) {
  }
}
DataTable.datetime = function(format, locale) {
  var typeName = "datetime-" + format;
  if (!locale) {
    locale = "en";
  }
  if (!DataTable.ext.type.order[typeName]) {
    DataTable.type(typeName, {
      detect: function(d) {
        var dt = __mldObj(d, format, locale);
        return d === "" || dt ? typeName : false;
      },
      order: {
        pre: function(d) {
          return __mldObj(d, format, locale) || 0;
        }
      },
      className: "dt-right"
    });
  }
};
DataTable.render = {
  date: __mlHelper("toLocaleDateString"),
  datetime: __mlHelper("toLocaleString"),
  time: __mlHelper("toLocaleTimeString"),
  number: function(thousands, decimal, precision, prefix, postfix) {
    if (thousands === null || thousands === void 0) {
      thousands = __thousands;
    }
    if (decimal === null || decimal === void 0) {
      decimal = __decimal;
    }
    return {
      display: function(d) {
        if (typeof d !== "number" && typeof d !== "string") {
          return d;
        }
        if (d === "" || d === null) {
          return d;
        }
        var negative = d < 0 ? "-" : "";
        var flo = parseFloat(d);
        var abs = Math.abs(flo);
        if (abs >= 1e11 || abs < 1e-4 && abs !== 0) {
          var exp = flo.toExponential(precision).split(/e\+?/);
          return exp[0] + " x 10<sup>" + exp[1] + "</sup>";
        }
        if (isNaN(flo)) {
          return _escapeHtml(d);
        }
        flo = flo.toFixed(precision);
        d = Math.abs(flo);
        var intPart = parseInt(d, 10);
        var floatPart = precision ? decimal + (d - intPart).toFixed(precision).substring(2) : "";
        if (intPart === 0 && parseFloat(floatPart) === 0) {
          negative = "";
        }
        return negative + (prefix || "") + intPart.toString().replace(
          /\B(?=(\d{3})+(?!\d))/g,
          thousands
        ) + floatPart + (postfix || "");
      }
    };
  },
  text: function() {
    return {
      display: _escapeHtml,
      filter: _escapeHtml
    };
  }
};
var _extTypes = DataTable.ext.type;
DataTable.type = function(name, prop, val) {
  if (!prop) {
    return {
      className: _extTypes.className[name],
      detect: _extTypes.detect.find(function(fn) {
        return fn._name === name;
      }),
      order: {
        pre: _extTypes.order[name + "-pre"],
        asc: _extTypes.order[name + "-asc"],
        desc: _extTypes.order[name + "-desc"]
      },
      render: _extTypes.render[name],
      search: _extTypes.search[name]
    };
  }
  var setProp = function(prop2, propVal) {
    _extTypes[prop2][name] = propVal;
  };
  var setDetect = function(detect) {
    Object.defineProperty(detect, "_name", { value: name });
    var idx = _extTypes.detect.findIndex(function(item) {
      return item._name === name;
    });
    if (idx === -1) {
      _extTypes.detect.unshift(detect);
    } else {
      _extTypes.detect.splice(idx, 1, detect);
    }
  };
  var setOrder = function(obj) {
    _extTypes.order[name + "-pre"] = obj.pre;
    _extTypes.order[name + "-asc"] = obj.asc;
    _extTypes.order[name + "-desc"] = obj.desc;
  };
  if (val === void 0) {
    val = prop;
    prop = null;
  }
  if (prop === "className") {
    setProp("className", val);
  } else if (prop === "detect") {
    setDetect(val);
  } else if (prop === "order") {
    setOrder(val);
  } else if (prop === "render") {
    setProp("render", val);
  } else if (prop === "search") {
    setProp("search", val);
  } else if (!prop) {
    if (val.className) {
      setProp("className", val.className);
    }
    if (val.detect !== void 0) {
      setDetect(val.detect);
    }
    if (val.order) {
      setOrder(val.order);
    }
    if (val.render !== void 0) {
      setProp("render", val.render);
    }
    if (val.search !== void 0) {
      setProp("search", val.search);
    }
  }
};
DataTable.types = function() {
  return _extTypes.detect.map(function(fn) {
    return fn._name;
  });
};
var __diacriticSort = function(a, b) {
  a = a !== null && a !== void 0 ? a.toString().toLowerCase() : "";
  b = b !== null && b !== void 0 ? b.toString().toLowerCase() : "";
  return a.localeCompare(b, navigator.languages[0] || navigator.language, {
    numeric: true,
    ignorePunctuation: true
  });
};
var __diacriticHtmlSort = function(a, b) {
  a = _stripHtml(a);
  b = _stripHtml(b);
  return __diacriticSort(a, b);
};
DataTable.type("string", {
  detect: function() {
    return "string";
  },
  order: {
    pre: function(a) {
      return _empty(a) && typeof a !== "boolean" ? "" : typeof a === "string" ? a.toLowerCase() : !a.toString ? "" : a.toString();
    }
  },
  search: _filterString(false)
});
DataTable.type("string-utf8", {
  detect: {
    allOf: function(d) {
      return true;
    },
    oneOf: function(d) {
      return !_empty(d) && navigator.languages && typeof d === "string" && d.match(/[^\x00-\x7F]/);
    }
  },
  order: {
    asc: __diacriticSort,
    desc: function(a, b) {
      return __diacriticSort(a, b) * -1;
    }
  },
  search: _filterString(false)
});
DataTable.type("html", {
  detect: {
    allOf: function(d) {
      return _empty(d) || typeof d === "string" && d.indexOf("<") !== -1;
    },
    oneOf: function(d) {
      return !_empty(d) && typeof d === "string" && d.indexOf("<") !== -1;
    }
  },
  order: {
    pre: function(a) {
      return _empty(a) ? "" : a.replace ? _stripHtml(a).trim().toLowerCase() : a + "";
    }
  },
  search: _filterString(true)
});
DataTable.type("html-utf8", {
  detect: {
    allOf: function(d) {
      return _empty(d) || typeof d === "string" && d.indexOf("<") !== -1;
    },
    oneOf: function(d) {
      return navigator.languages && !_empty(d) && typeof d === "string" && d.indexOf("<") !== -1 && typeof d === "string" && d.match(/[^\x00-\x7F]/);
    }
  },
  order: {
    asc: __diacriticHtmlSort,
    desc: function(a, b) {
      return __diacriticHtmlSort(a, b) * -1;
    }
  },
  search: _filterString(true)
});
DataTable.type("date", {
  className: "dt-type-date",
  detect: {
    allOf: function(d) {
      if (d && !(d instanceof Date) && !_re_date.test(d)) {
        return null;
      }
      var parsed = Date.parse(d);
      return parsed !== null && !isNaN(parsed) || _empty(d);
    },
    oneOf: function(d) {
      return d instanceof Date || typeof d === "string" && _re_date.test(d);
    }
  },
  order: {
    pre: function(d) {
      var ts = Date.parse(d);
      return isNaN(ts) ? -Infinity : ts;
    }
  }
});
DataTable.type("html-num-fmt", {
  className: "dt-type-numeric",
  detect: {
    allOf: function(d, settings) {
      var decimal = settings.oLanguage.sDecimal;
      return _htmlNumeric(d, decimal, true, false);
    },
    oneOf: function(d, settings) {
      var decimal = settings.oLanguage.sDecimal;
      return _htmlNumeric(d, decimal, true, false);
    }
  },
  order: {
    pre: function(d, s) {
      var dp = s.oLanguage.sDecimal;
      return __numericReplace(d, dp, _re_html, _re_formatted_numeric);
    }
  },
  search: _filterString(true)
});
DataTable.type("html-num", {
  className: "dt-type-numeric",
  detect: {
    allOf: function(d, settings) {
      var decimal = settings.oLanguage.sDecimal;
      return _htmlNumeric(d, decimal, false, true);
    },
    oneOf: function(d, settings) {
      var decimal = settings.oLanguage.sDecimal;
      return _htmlNumeric(d, decimal, false, false);
    }
  },
  order: {
    pre: function(d, s) {
      var dp = s.oLanguage.sDecimal;
      return __numericReplace(d, dp, _re_html);
    }
  },
  search: _filterString(true)
});
DataTable.type("num-fmt", {
  className: "dt-type-numeric",
  detect: {
    allOf: function(d, settings) {
      var decimal = settings.oLanguage.sDecimal;
      return _isNumber(d, decimal, true, true);
    },
    oneOf: function(d, settings) {
      var decimal = settings.oLanguage.sDecimal;
      return _isNumber(d, decimal, true, false);
    }
  },
  order: {
    pre: function(d, s) {
      var dp = s.oLanguage.sDecimal;
      return __numericReplace(d, dp, _re_formatted_numeric);
    }
  }
});
DataTable.type("num", {
  className: "dt-type-numeric",
  detect: {
    allOf: function(d, settings) {
      var decimal = settings.oLanguage.sDecimal;
      return _isNumber(d, decimal, false, true);
    },
    oneOf: function(d, settings) {
      var decimal = settings.oLanguage.sDecimal;
      return _isNumber(d, decimal, false, false);
    }
  },
  order: {
    pre: function(d, s) {
      var dp = s.oLanguage.sDecimal;
      return __numericReplace(d, dp);
    }
  }
});
var __numericReplace = function(d, decimalPlace, re1, re2) {
  if (d !== 0 && (!d || d === "-")) {
    return -Infinity;
  }
  var type = typeof d;
  if (type === "number" || type === "bigint") {
    return d;
  }
  if (decimalPlace) {
    d = _numToDecimal(d, decimalPlace);
  }
  if (d.replace) {
    if (re1) {
      d = d.replace(re1, "");
    }
    if (re2) {
      d = d.replace(re2, "");
    }
  }
  return d * 1;
};
$.extend(true, DataTable.ext.renderer, {
  footer: {
    _: function(settings, cell, classes) {
      cell.addClass(classes.tfoot.cell);
    }
  },
  header: {
    _: function(settings, cell, classes) {
      cell.addClass(classes.thead.cell);
      if (!settings.oFeatures.bSort) {
        cell.addClass(classes.order.none);
      }
      var titleRow = settings.titleRow;
      var headerRows = cell.closest("thead").find("tr");
      var rowIdx = cell.parent().index();
      if (
        // Cells and rows which have the attribute to disable the icons
        cell.attr("data-dt-order") === "disable" || cell.parent().attr("data-dt-order") === "disable" || // titleRow support, for defining a specific row in the header
        titleRow === true && rowIdx !== 0 || titleRow === false && rowIdx !== headerRows.length - 1 || typeof titleRow === "number" && rowIdx !== titleRow
      ) {
        return;
      }
      $(settings.nTable).on("order.dt.DT column-visibility.dt.DT", function(e, ctx, column) {
        if (settings !== ctx) {
          return;
        }
        var sorting = ctx.sortDetails;
        if (!sorting) {
          return;
        }
        var orderedColumns = _pluck(sorting, "col");
        if (e.type === "column-visibility" && !orderedColumns.includes(column)) {
          return;
        }
        var i;
        var orderClasses = classes.order;
        var columns = ctx.api.columns(cell);
        var col = settings.aoColumns[columns.flatten()[0]];
        var orderable = columns.orderable().includes(true);
        var ariaType = "";
        var indexes = columns.indexes();
        var sortDirs = columns.orderable(true).flatten();
        var tabIndex = settings.iTabIndex;
        var canOrder = ctx.orderHandler && orderable;
        cell.removeClass(
          orderClasses.isAsc + " " + orderClasses.isDesc
        ).toggleClass(orderClasses.none, !orderable).toggleClass(orderClasses.canAsc, canOrder && sortDirs.includes("asc")).toggleClass(orderClasses.canDesc, canOrder && sortDirs.includes("desc"));
        var isOrdering = true;
        for (i = 0; i < indexes.length; i++) {
          if (!orderedColumns.includes(indexes[i])) {
            isOrdering = false;
          }
        }
        if (isOrdering) {
          var orderDirs = columns.order();
          cell.addClass(
            orderDirs.includes("asc") ? orderClasses.isAsc : "" + orderDirs.includes("desc") ? orderClasses.isDesc : ""
          );
        }
        var firstVis = -1;
        for (i = 0; i < orderedColumns.length; i++) {
          if (settings.aoColumns[orderedColumns[i]].bVisible) {
            firstVis = orderedColumns[i];
            break;
          }
        }
        if (indexes[0] == firstVis) {
          var firstSort = sorting[0];
          var sortOrder = col.asSorting;
          cell.attr("aria-sort", firstSort.dir === "asc" ? "ascending" : "descending");
          ariaType = !sortOrder[firstSort.index + 1] ? "Remove" : "Reverse";
        } else {
          cell.removeAttr("aria-sort");
        }
        if (orderable) {
          var orderSpan = cell.find(".dt-column-order");
          orderSpan.attr("role", "button").attr(
            "aria-label",
            orderable ? col.ariaTitle + ctx.api.i18n("oAria.orderable" + ariaType) : col.ariaTitle
          );
          if (tabIndex !== -1) {
            orderSpan.attr("tabindex", tabIndex);
          }
        }
      });
    }
  },
  layout: {
    _: function(settings, container, items) {
      var classes = settings.oClasses.layout;
      var row = $("<div/>").attr("id", items.id || null).addClass(items.className || classes.row).appendTo(container);
      DataTable.ext.renderer.layout._forLayoutRow(items, function(key, val) {
        if (key === "id" || key === "className") {
          return;
        }
        var klass = "";
        if (val.table) {
          row.addClass(classes.tableRow);
          klass += classes.tableCell + " ";
        }
        if (key === "start") {
          klass += classes.start;
        } else if (key === "end") {
          klass += classes.end;
        } else {
          klass += classes.full;
        }
        $("<div/>").attr({
          id: val.id || null,
          "class": val.className ? val.className : classes.cell + " " + klass
        }).append(val.contents).appendTo(row);
      });
    },
    // Shared for use by the styling frameworks
    _forLayoutRow: function(items, fn) {
      var layoutEnum = function(x) {
        switch (x) {
          case "":
            return 0;
          case "start":
            return 1;
          case "end":
            return 2;
          default:
            return 3;
        }
      };
      Object.keys(items).sort(function(a, b) {
        return layoutEnum(a) - layoutEnum(b);
      }).forEach(function(key) {
        fn(key, items[key]);
      });
    }
  }
});
DataTable.feature = {};
DataTable.feature.register = function(name, cb, legacy) {
  DataTable.ext.features[name] = cb;
  if (legacy) {
    _ext.feature.push({
      cFeature: legacy,
      fnInit: cb
    });
  }
};
function _divProp(el, prop, val) {
  if (val) {
    el[prop] = val;
  }
}
DataTable.feature.register("div", function(settings, opts) {
  var n = $("<div>")[0];
  if (opts) {
    _divProp(n, "className", opts.className);
    _divProp(n, "id", opts.id);
    _divProp(n, "innerHTML", opts.html);
    _divProp(n, "textContent", opts.text);
  }
  return n;
});
DataTable.feature.register("info", function(settings, opts) {
  if (!settings.oFeatures.bInfo) {
    return null;
  }
  var lang = settings.oLanguage, tid = settings.sTableId, n = $("<div/>", {
    "class": settings.oClasses.info.container
  });
  opts = $.extend({
    callback: lang.fnInfoCallback,
    empty: lang.sInfoEmpty,
    postfix: lang.sInfoPostFix,
    search: lang.sInfoFiltered,
    text: lang.sInfo
  }, opts);
  settings.aoDrawCallback.push(function(s) {
    _fnUpdateInfo(s, opts, n);
  });
  if (!settings._infoEl) {
    n.attr({
      "aria-live": "polite",
      id: tid + "_info",
      role: "status"
    });
    $(settings.nTable).attr("aria-describedby", tid + "_info");
    settings._infoEl = n;
  }
  return n;
}, "i");
function _fnUpdateInfo(settings, opts, node) {
  var start = settings._iDisplayStart + 1, end = settings.fnDisplayEnd(), max = settings.fnRecordsTotal(), total = settings.fnRecordsDisplay(), out = total ? opts.text : opts.empty;
  if (total !== max) {
    out += " " + opts.search;
  }
  out += opts.postfix;
  out = _fnMacros(settings, out);
  if (opts.callback) {
    out = opts.callback.call(
      settings.oInstance,
      settings,
      start,
      end,
      max,
      total,
      out
    );
  }
  node.html(out);
  _fnCallbackFire(settings, null, "info", [settings, node[0], out]);
}
var __searchCounter = 0;
DataTable.feature.register("search", function(settings, opts) {
  if (!settings.oFeatures.bFilter) {
    return null;
  }
  var classes = settings.oClasses.search;
  var tableId = settings.sTableId;
  var language = settings.oLanguage;
  var previousSearch = settings.oPreviousSearch;
  var input = '<input type="search" class="' + classes.input + '"/>';
  opts = $.extend({
    placeholder: language.sSearchPlaceholder,
    processing: false,
    text: language.sSearch
  }, opts);
  if (opts.text.indexOf("_INPUT_") === -1) {
    opts.text += "_INPUT_";
  }
  opts.text = _fnMacros(settings, opts.text);
  var end = opts.text.match(/_INPUT_$/);
  var start = opts.text.match(/^_INPUT_/);
  var removed = opts.text.replace(/_INPUT_/, "");
  var str = "<label>" + opts.text + "</label>";
  if (start) {
    str = "_INPUT_<label>" + removed + "</label>";
  } else if (end) {
    str = "<label>" + removed + "</label>_INPUT_";
  }
  var filter = $("<div>").addClass(classes.container).append(str.replace(/_INPUT_/, input));
  filter.find("label").attr("for", "dt-search-" + __searchCounter);
  filter.find("input").attr("id", "dt-search-" + __searchCounter);
  __searchCounter++;
  var searchFn = function(event) {
    var val = this.value;
    if (previousSearch.return && event.key !== "Enter") {
      return;
    }
    if (val != previousSearch.search) {
      _fnProcessingRun(settings, opts.processing, function() {
        previousSearch.search = val;
        _fnFilterComplete(settings, previousSearch);
        settings._iDisplayStart = 0;
        _fnDraw(settings);
      });
    }
  };
  var searchDelay = settings.searchDelay !== null ? settings.searchDelay : 0;
  var jqFilter = $("input", filter).val(previousSearch.search).attr("placeholder", opts.placeholder).on(
    "keyup.DT search.DT input.DT paste.DT cut.DT",
    searchDelay ? DataTable.util.debounce(searchFn, searchDelay) : searchFn
  ).on("mouseup.DT", function(e) {
    setTimeout(function() {
      searchFn.call(jqFilter[0], e);
    }, 10);
  }).on("keypress.DT", function(e) {
    if (e.keyCode == 13) {
      return false;
    }
  }).attr("aria-controls", tableId);
  $(settings.nTable).on("search.dt.DT", function(ev, s) {
    if (settings === s && jqFilter[0] !== document.activeElement) {
      jqFilter.val(
        typeof previousSearch.search !== "function" ? previousSearch.search : ""
      );
    }
  });
  return filter;
}, "f");
DataTable.feature.register("paging", function(settings, opts) {
  if (!settings.oFeatures.bPaginate) {
    return null;
  }
  opts = $.extend({
    buttons: DataTable.ext.pager.numbers_length,
    type: settings.sPaginationType,
    boundaryNumbers: true,
    firstLast: true,
    previousNext: true,
    numbers: true
  }, opts);
  var host = $("<div/>").addClass(settings.oClasses.paging.container + (opts.type ? " paging_" + opts.type : "")).append(
    $("<nav>").attr("aria-label", "pagination").addClass(settings.oClasses.paging.nav)
  );
  var draw = function() {
    _pagingDraw(settings, host.children(), opts);
  };
  settings.aoDrawCallback.push(draw);
  $(settings.nTable).on("column-sizing.dt.DT", draw);
  return host;
}, "p");
function _pagingDynamic(opts) {
  var out = [];
  if (opts.numbers) {
    out.push("numbers");
  }
  if (opts.previousNext) {
    out.unshift("previous");
    out.push("next");
  }
  if (opts.firstLast) {
    out.unshift("first");
    out.push("last");
  }
  return out;
}
function _pagingDraw(settings, host, opts) {
  if (!settings._bInitComplete) {
    return;
  }
  var plugin = opts.type ? DataTable.ext.pager[opts.type] : _pagingDynamic, aria = settings.oLanguage.oAria.paginate || {}, start = settings._iDisplayStart, len = settings._iDisplayLength, visRecords = settings.fnRecordsDisplay(), all = len === -1, page = all ? 0 : Math.ceil(start / len), pages = all ? 1 : Math.ceil(visRecords / len), buttons = [], buttonEls = [], buttonsNested = plugin(opts).map(function(val) {
    return val === "numbers" ? _pagingNumbers(page, pages, opts.buttons, opts.boundaryNumbers) : val;
  });
  buttons = buttons.concat.apply(buttons, buttonsNested);
  for (var i = 0; i < buttons.length; i++) {
    var button = buttons[i];
    var btnInfo = _pagingButtonInfo(settings, button, page, pages);
    var btn = _fnRenderer(settings, "pagingButton")(
      settings,
      button,
      btnInfo.display,
      btnInfo.active,
      btnInfo.disabled
    );
    var ariaLabel = typeof button === "string" ? aria[button] : aria.number ? aria.number + (button + 1) : null;
    $(btn.clicker).attr({
      "aria-controls": settings.sTableId,
      "aria-disabled": btnInfo.disabled ? "true" : null,
      "aria-current": btnInfo.active ? "page" : null,
      "aria-label": ariaLabel,
      "data-dt-idx": button,
      "tabIndex": btnInfo.disabled ? -1 : settings.iTabIndex && btn.clicker[0].nodeName.toLowerCase() !== "span" ? settings.iTabIndex : null
      // `0` doesn't need a tabIndex since it is the default
    });
    if (typeof button !== "number") {
      $(btn.clicker).addClass(button);
    }
    _fnBindAction(
      btn.clicker,
      { action: button },
      function(e) {
        e.preventDefault();
        _fnPageChange(settings, e.data.action, true);
      }
    );
    buttonEls.push(btn.display);
  }
  var wrapped = _fnRenderer(settings, "pagingContainer")(
    settings,
    buttonEls
  );
  var activeEl = host.find(document.activeElement).data("dt-idx");
  host.empty().append(wrapped);
  if (activeEl !== void 0) {
    host.find("[data-dt-idx=" + activeEl + "]").trigger("focus");
  }
  if (buttonEls.length) {
    var outerHeight = $(buttonEls[0]).outerHeight();
    if (opts.buttons > 1 && // prevent infinite
    outerHeight > 0 && // will be 0 if hidden
    $(host).height() >= outerHeight * 2 - 10) {
      _pagingDraw(settings, host, $.extend({}, opts, { buttons: opts.buttons - 2 }));
    }
  }
}
function _pagingButtonInfo(settings, button, page, pages) {
  var lang = settings.oLanguage.oPaginate;
  var o = {
    display: "",
    active: false,
    disabled: false
  };
  switch (button) {
    case "ellipsis":
      o.display = "&#x2026;";
      break;
    case "first":
      o.display = lang.sFirst;
      if (page === 0) {
        o.disabled = true;
      }
      break;
    case "previous":
      o.display = lang.sPrevious;
      if (page === 0) {
        o.disabled = true;
      }
      break;
    case "next":
      o.display = lang.sNext;
      if (pages === 0 || page === pages - 1) {
        o.disabled = true;
      }
      break;
    case "last":
      o.display = lang.sLast;
      if (pages === 0 || page === pages - 1) {
        o.disabled = true;
      }
      break;
    default:
      if (typeof button === "number") {
        o.display = settings.fnFormatNumber(button + 1);
        if (page === button) {
          o.active = true;
        }
      }
      break;
  }
  return o;
}
function _pagingNumbers(page, pages, buttons, addFirstLast) {
  var numbers = [], half = Math.floor(buttons / 2), before = addFirstLast ? 2 : 1, after = addFirstLast ? 1 : 0;
  if (pages <= buttons) {
    numbers = _range(0, pages);
  } else if (buttons === 1) {
    numbers = [page];
  } else if (buttons === 3) {
    if (page <= 1) {
      numbers = [0, 1, "ellipsis"];
    } else if (page >= pages - 2) {
      numbers = _range(pages - 2, pages);
      numbers.unshift("ellipsis");
    } else {
      numbers = ["ellipsis", page, "ellipsis"];
    }
  } else if (page <= half) {
    numbers = _range(0, buttons - before);
    numbers.push("ellipsis");
    if (addFirstLast) {
      numbers.push(pages - 1);
    }
  } else if (page >= pages - 1 - half) {
    numbers = _range(pages - (buttons - before), pages);
    numbers.unshift("ellipsis");
    if (addFirstLast) {
      numbers.unshift(0);
    }
  } else {
    numbers = _range(page - half + before, page + half - after);
    numbers.push("ellipsis");
    numbers.unshift("ellipsis");
    if (addFirstLast) {
      numbers.push(pages - 1);
      numbers.unshift(0);
    }
  }
  return numbers;
}
var __lengthCounter = 0;
DataTable.feature.register("pageLength", function(settings, opts) {
  var features = settings.oFeatures;
  if (!features.bPaginate || !features.bLengthChange) {
    return null;
  }
  opts = $.extend({
    menu: settings.aLengthMenu,
    text: settings.oLanguage.sLengthMenu
  }, opts);
  var classes = settings.oClasses.length, tableId = settings.sTableId, menu = opts.menu, lengths = [], language = [], i;
  if (Array.isArray(menu[0])) {
    lengths = menu[0];
    language = menu[1];
  } else {
    for (i = 0; i < menu.length; i++) {
      if ($.isPlainObject(menu[i])) {
        lengths.push(menu[i].value);
        language.push(menu[i].label);
      } else {
        lengths.push(menu[i]);
        language.push(menu[i]);
      }
    }
  }
  var end = opts.text.match(/_MENU_$/);
  var start = opts.text.match(/^_MENU_/);
  var removed = opts.text.replace(/_MENU_/, "");
  var str = "<label>" + opts.text + "</label>";
  if (start) {
    str = "_MENU_<label>" + removed + "</label>";
  } else if (end) {
    str = "<label>" + removed + "</label>_MENU_";
  }
  var tmpId = "tmp-" + +/* @__PURE__ */ new Date();
  var div = $("<div/>").addClass(classes.container).append(
    str.replace("_MENU_", '<span id="' + tmpId + '"></span>')
  );
  var textNodes = [];
  Array.prototype.slice.call(div.find("label")[0].childNodes).forEach(function(el) {
    if (el.nodeType === Node.TEXT_NODE) {
      textNodes.push({
        el,
        text: el.textContent
      });
    }
  });
  var updateEntries = function(len) {
    textNodes.forEach(function(node) {
      node.el.textContent = _fnMacros(settings, node.text, len);
    });
  };
  var select = $("<select/>", {
    "aria-controls": tableId,
    "class": classes.select
  });
  for (i = 0; i < lengths.length; i++) {
    var label = settings.api.i18n("lengthLabels." + lengths[i], null);
    if (label === null) {
      label = typeof language[i] === "number" ? settings.fnFormatNumber(language[i]) : language[i];
    }
    select[0][i] = new Option(label, lengths[i]);
  }
  div.find("label").attr("for", "dt-length-" + __lengthCounter);
  select.attr("id", "dt-length-" + __lengthCounter);
  __lengthCounter++;
  div.find("#" + tmpId).replaceWith(select);
  $("select", div).val(settings._iDisplayLength).on("change.DT", function() {
    _fnLengthChange(settings, $(this).val());
    _fnDraw(settings);
  });
  $(settings.nTable).on("length.dt.DT", function(e, s, len) {
    if (settings === s) {
      $("select", div).val(len);
      updateEntries(len);
    }
  });
  updateEntries(settings._iDisplayLength);
  return div;
}, "l");
$.fn.dataTable = DataTable;
DataTable.$ = $;
$.fn.dataTableSettings = DataTable.settings;
$.fn.dataTableExt = DataTable.ext;
$.fn.DataTable = function(opts) {
  return $(this).dataTable(opts).api();
};
$.each(DataTable, function(prop, val) {
  $.fn.DataTable[prop] = val;
});
$$1(document).ready(function() {
  new DataTable("#user-table", {
    columnDefs: [
      // the last two columns are not orderable: admin & inactive checkboxes
      { orderable: false, targets: [-2, -1] }
    ]
  });
  let table = $$1("#user-table");
  table.on("click", ".admin", function(e) {
    if (e.target.id.startsWith("admin")) {
      jitterbug.toggleAdmin(e.target.id);
    }
  });
  table.on("click", ".inactive", function(e) {
    if (e.target.id.startsWith("active")) {
      jitterbug.toggleInactive(e.target.id);
    }
  });
});
