      <div id="banner" class="row">
        <div class="col-md-12">
          <div id="logo">{!! Html::image('img/junebug-logo.png', 'Junebug logo', array('width' => 48 , 'height' => 46)) !!} &nbsp;junebug</div>
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
            <ul>
              <li>
                <a class="{{$section==='dashboard' ? 'active' : ''}}" href="#"><i class="fa fa-dashboard fa-fw" aria-hidden="true"></i> Dashboard</a>
              </li>
              <li>
                <a class="{{$section==='items' ? 'active' : ''}}" href="{{route('items.index')}}"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> Audio Visual Items</a>
              </li>
              <li>
                <a class="{{$section==='masters' ? 'active' : ''}}" href="{{route('masters.index')}}"><i class="fa fa-database fa-fw" aria-hidden="true"></i> Preservation Masters</a>
              </li>
              <li>
                <a class="{{$section==='transfers' ? 'active' : ''}}" href="#"><i class="fa fa-exchange fa-fw" aria-hidden="true"></i> Transfers</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="row">
        <div id="alert"></div>
      </div> 
