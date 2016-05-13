<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:300' rel='stylesheet' type='text/css'>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >

  <style>
/*        * { border: 1px solid black; }*/

    .banner {
      margin-bottom: 5px;
    }

    #logo {
      color: #4d4d4f;
      font-family: 'Yanone Kaffeesatz', 'YanoneKaffeesatz-Light', sans-serif;
      font-weight: 300;
      font-size: 2.3rem;
/*      margin-left: .75rem;*/
      float: left;
    }

    #support-nav {
      font-size: .9rem;
      margin-left: 360px;
      margin-top: 25px;
      float: right;
    }

    #support-nav ul {
      list-style-type: none;
    }

    #support-nav li {
      float: left;
      padding-left: 15px;
      padding-right: 15px;
      border-right: solid 1px #979797;
    }

    #support-nav li.last {
      padding-right: 0;
      border-right: 0;
    }

    #global-nav {
      border-radius: 4px 4px 0 0;
      background-color: #d8d8d8;
    }

    #global-nav nav ul {
      font-size: .92rem;
      list-style-type: none;
      overflow: hidden;
      margin-bottom: 0;
      padding-left: 0;
    }

    #global-nav nav li {
      float: left;
      margin-bottom: 15px;
      margin-top: 15px;
      margin-right: 16px;
    }

    #global-nav nav li a { 
      display: block;
      color: #707070;
      text-align: center;
      padding: 3px 14px;
      border-radius: 4px;
      text-decoration: none;
      background-color: #e9e9e9;
    }

    #global-nav nav li a.active {
      color: #464646;
      background-color: #fff;
    }

    #global-nav nav li a:hover {
      text-decoration: none;
    }

    #filter-panel {
      background-color: #f0f0f0;
      padding: 0;
    }

    #filter-panel h6 {
      background-color: #e0e0e0;
      padding-left: 15px;
      padding-top: 8px;
      padding-bottom: 8px;
      margin-top: 12px;
      font-weight: bold;
      font-size: .95rem;
    }

    #filter-panel .checkbox {
      margin-bottom: .4rem;
    }

    #filter-panel .checkbox input[type=checkbox] {
      position: relative;
    }

    .filter-list {
      list-style-type: none;
      font-size: .9rem;
      padding-left: 15px;
      padding-right: 15px;
      margin-bottom: .5rem;
    }

    .filter-count {
      font-size: .6rem;
      color: #8c8c8c;
      margin-left: .1rem;
    }

    #data-panel {
      background-color: #fff;
    }

    #data-panel table {
      font-size: .9rem;
      table-layout: fixed;
    }

    #data-panel table th {
      border-top: none;
    }

    #data-panel table td {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    #data-panel .top-controls {
      margin-top: 12px;
      margin-bottom: 60px;
    }

    #data-panel .data-footer .record-count {
      font-size: .9rem;
      font-weight: bold;
      float: left;
    }
    
    #data-panel .pagination {
      margin-top: 0;
      margin-right: 20px;
    }

    #data-panel .pagination .page-link {
      color: #000000;
    }

    #data-panel .pagination li a {
      border: 0;
    }

    #data-panel .pagination li.page-item a:hover{
      color: #000000;
      text-decoration: none;
      background-color: #fff;
    }

    #data-panel .pagination li.page-item.active a {
      color: #000000;
      background-color: #e9e9e9;
      border-radius: .3rem;
    }

    #footer {
      margin-bottom: 5rem;
    }


    /* 
     * #content and #content .panel are hacks
     * to workaround columns not displaying the 
     * same height.
     */
    #content {
      display: table;
    }

    #content .panel {
      float: none;
      display: table-cell;
      vertical-align: top;
    }

    /* Bootsrap overrides */

    .btn-sm {
      padding: 0.25rem 0.75rem;
      font-size: 0.875rem;
      line-height: 1.5;
      border-radius: 0.3rem;
    }

    .btn-secondary {
      color: #464646;
      background-color: #e9e9e9;
      border: none;
    }

    .form-control-sm {
      padding: 0.275rem 0.75rem;
      font-size: 0.875rem;
      line-height: 1.3;
      border-radius: 0.3rem;
    }

    .input-group-addon {
      padding: 0.25rem 0.75rem;
    }

    body {
      background-color: #bfbfbf;
      min-width: 700px;
    }

  </style>
  <title>Junebug</title>
</head>
<body>
  <div class="container" style="min-width: 768px !important;">
    <section id="header">
      <div class="row banner">
        <div class="col-md-12">
          <!-- <div id="logo">{!! Html::image('img/junebug.png', 'Junebug logo', array('width' => 37 , 'height' => 41)) !!} &nbsp;junebug</div> -->
          <!-- <div id="logo">{!! Html::image('img/junebug-cute.png', 'Junebug logo', array('width' => 33 , 'height' => 42)) !!} &nbsp;junebug</div> -->
          <!-- <div id="logo">{!! Html::image('img/junebug-cute-2.png', 'Junebug logo', array('width' => 41 , 'height' => 47)) !!} &nbsp;junebug</div> -->
          <div id="logo">{!! Html::image('img/junebug-cute-4.png', 'Junebug logo', array('width' => 43 , 'height' => 40)) !!} &nbsp;junebug</div>
          <!-- <div id="logo">{!! Html::image('img/junebug-full.png', 'Junebug logo', array('width' => 112 , 'height' => 44)) !!}</div> -->
          <div id="support-nav">
            <ul>
              <li>
                <a href="#">Admin</a>
              </li>
              <li class="last">
                <a href="#">Sign Out</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div id="global-nav" class="col-md-12">
          <nav>
            <ul class="">
              <li class="">
                <a class="" href="#">Dashboard</a>
              </li>
              <li class="">
                <a class="active" href="#">Audio Visual Items</a>
              </li>
              <li class="">
                <a class="" href="#">Preservation Masters</a>
              </li>
              <li class="">
                <a class="" href="#">Transfers</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </section>
    <section id="content">
      <div class="row">
        <div id="filter-panel" class="col-md-3 panel">
          <h6>Type</h6>
          <ul id="type-filters" class="filter-list">
            <li class="">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="0">
                  Any <span class="filter-count">(103,182)</span>
                </label>

              </div>
            </li>
            <li class="">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="1">
                  Audio <span class="filter-count">(80,574)</span>
                </label>
              </div>
            </li>
            <li class="">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="2">
                  Video <span class="filter-count">(20,110)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="3">
                  Film <span class="filter-count">(2,498)</span>
                </label>
              </div>
            </li>
          </ul>

          <h6>Collection</h6>
          <ul id="collection-filters" class="filter-list" style="height: 260px; overflow-y: scroll; overflow-x: hidden;">
            <li class="">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="0">
                  Any <span class="filter-count">(94,568)</span>
                </label>
              </div>
            </li>
            <li class="">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="1">
                  Alderman, Tony <span class="filter-count">(110)</span>
                </label>
              </div>
            </li>
            <li class="">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="2">
                  Alvic, Phillis <span class="filter-count">(33)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="3">
                  Arduini, Mark <span class="filter-count">(2)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="4">
                  Artley, Malvin <span class="filter-count">(18)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="5">
                  Association for the Preservation of the Eno River Valley <span class="filter-count">(1,126)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="6">
                  Babel, Edward <span class="filter-count">(9)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="7">
                  Barber, Sam <span class="filter-count">(41)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="8">
                  Bartis, Peter <span class="filter-count">(9)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="9">
                  Bartis, Stephanie <span class="filter-count">(488)</span>
                </label>
              </div>
            </li>
          </ul>

          <h6>Format</h6>
          <ul id="format-filters" class="filter-list" style="height: 250px; overflow-y: scroll; overflow-x: hidden;">
            <li class="">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="0">
                  Any <span class="filter-count">(90,589)</span>
                </label>
              </div>
            </li>
            <li class="">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="1">
                  1” Open Reel Audio <span class="filter-count">(110)</span>
                </label>
              </div>
            </li>
            <li class="">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="2">
                  1” Open Reel Video <span class="filter-count">(15)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="3">
                  1/2” Open Reel Audio <span class="filter-count">(341)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="4">
                  1/2” Open Reel Video <span class="filter-count">(43)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="5">
                  1/4” Open Reel Audio <span class="filter-count">(15,652)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="6">
                  16mm <span class="filter-count">(82)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="7">
                  2” Open Reel Audio <span class="filter-count">(29)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="8">
                  2” Quadruplex <span class="filter-count">(2)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="9">
                  Betacam <span class="filter-count">(45)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="10">
                  Audiocassette <span class="filter-count">(15,665)</span>
                </label>
              </div>
            </li>
            <li>
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="11">
                  Microcassette <span class="filter-count">(2,973)</span>
                </label>
              </div>
            </li>
          </ul>

        </div>
        <div id="data-panel" class="col-md-9 panel">
          <div class="top-controls">
            <div style="float: left;">
              <a class="btn btn-sm btn-secondary" style="margin-right: 5px;" href="#" role="button"><i class="fa fa-plus" aria-hidden="true"></i> New</a>
              <a class="btn btn-sm btn-secondary" href="#" role="button"><i class="fa fa-upload" aria-hidden="true"></i> Export</a>
            </div>
            <div style="float: right; width: 275px;">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                <input id="search" class="form-control form-control-sm" type="text" placeholder="Search">
              </div>
            </div>
          </div>
          <table id="data" class="table table-sm table-hover">
            <thead>
              <tr>
                <th width="12%">Call Number</th>
                <th width="20%">Title</th>
                <th width="30%">Container Note</th>
                <th width="15%">Collection</th>
                <th width="16%">Format</th>
                <th width="7%">Type</th>
              </tr>
            </thead>
            <tbody>
              <tr role="button">
                <td>FS-1102</td>
                <td title="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</td>
                <td title="Oral History Interview:  Theresa Conley">Oral History Interview:  Theresa Conley</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button" onclick="alert('It works'); return true;">
                <td>FS-1103</td>
                <td></td>
                <td title="Oral History Interview:  William [Bill] Ford">Oral History Interview:  William [Bill] Ford</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button">
                <td>FS-1104</td>
                <td></td>
                <td title="Oral History Interview:  William [Bill] Ford">Oral History Interview:  William [Bill] Ford</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button">
                <td>FS-1105</td>
                <td></td>
                <td title="Oral History Interview:  Mae and J.G. Fortner">Oral History Interview:  Mae and J.G. Fortner</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button">
                <td>FS-1106</td>
                <td></td>
                <td title="Oral History Interview:  Mae and J.G. Fortner">Oral History Interview:  Mae and J.G. Fortner</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button">
                <td>FS-1107</td>
                <td></td>
                <td title="Oral History Interview:  Alice Green">Oral History Interview:  Alice Green</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button">
                <td>FS-1108</td>
                <td></td>
                <td title="Oral History Interview:  Alice Green">Oral History Interview:  Alice Green</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button">
                <td>FS-1109</td>
                <td></td>
                <td title="Oral History Interview:  Sally Keslar">Oral History Interview:  Sally Keslar</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button">
                <td>FS-1110</td>
                <td></td>
                <td title="Oral History Interview:  Sally Keslar">Oral History Interview:  Sally Keslar</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button">
                <td>FS-1111</td>
                <td></td>
                <td title="Oral History Interview:  Susan Leveille">Oral History Interview:  Susan Leveille</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button">
                <td>FS-1112</td>
                <td></td>
                <td title="Oral History Interview:  Susan Leveille">Oral History Interview:  Susan Leveille</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button">
                <td>FS-1113</td>
                <td></td>
                <td title="Oral History Interview:  Douglas and Carolyn Young">Oral History Interview:  Douglas and Carolyn Young</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button">
                <td>FS-1114</td>
                <td></td>
                <td title="Oral History Interview:  Douglas and Carolyn Young">Oral History Interview:  Douglas and Carolyn Young</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr> 
              <tr role="button">
                <td>FS-1115</td>
                <td></td>
                <td title="Oral History Interview:  Jessie McKinney">Oral History Interview:  Jessie McKinney</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr> 
              <tr role="button">
                <td>FS-1116</td>
                <td></td>
                <td title="Oral History Interview:  Jessie McKinney">Oral History Interview:  Jessie McKinney</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr> 
              <tr role="button">
                <td>FS-1117</td>
                <td></td>
                <td title="Oral History Interview:  Jessie McKinney">Oral History Interview:  Jessie McKinney</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>
              <tr role="button">
                <td>FS-1118</td>
                <td></td>
                <td title="Oral History Interview:  Betty Morgan">Oral History Interview:  Betty Morgan</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr> 
              <tr role="button">
                <td>FS-1119</td>
                <td></td>
                <td title="Oral History Interview:  Ralph Morgan">Oral History Interview:  Ralph Morgan</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr> 
              <tr role="button">
                <td>FS-1120</td>
                <td></td>
                <td title="Oral History Interview:  Ralph Morgan">Oral History Interview:  Ralph Morgan</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr> 
              <tr role="button">
                <td>FS-1121</td>
                <td></td>
                <td title="Oral History Interview:  Flossie Perisho">Oral History Interview:  Flossie Perisho</td>
                <td>Alvic, Phillis</td>
                <td>Audiocassette</td>
                <td>Audio</td>
              </tr>                           
            </tbody>
          </table>
          <div class="data-footer">
            <div class="record-count">
              33 records
            </div>
            <div style="float: right;">
              <nav>
                <ul class="pagination pagination-sm">
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>
<!--     <section id="content-overlay" style="background-color: white">
      <row>
              <div class="col-md-12">
                Testing
              </div>
      </row>
    </section> -->

    <section id="footer">
        <div class="col-md-12">
          <div style="float: left; margin-top: 1rem;">{!! Html::image('img/unc-logo.png', 'UNC logo', array('width' => 153 , 'height' => 34)) !!}</div>
          <div style="float: right; margin-top: 1rem;">{!! Html::image('img/mellon-logo.png', 'Andrew W. Mellon Foundation logo', array('width' => 78 , 'height' => 36)) !!}
          </div>
        </div>
    </section>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
</body>
</html>