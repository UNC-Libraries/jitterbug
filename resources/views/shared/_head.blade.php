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
      background-color: #FFF;
    }

    #data-panel .pagination li a {
      border: 0;
      text-decoration: none;
    }

    #data-panel .pagination li.page-item a:hover{
      color: #000000;
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
  <title>Junebug | {{ $title }}</title>