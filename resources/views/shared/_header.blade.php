      <div id="banner" class="row">
        <div class="col-md-12">
          <div id="support-nav">
            <ul>
              @if (\Auth::user()->isAdmin())
              <li>
                <a href="{{route('admin.index')}}">Admin</a>
              </li>
              @endif
              <li class="last">
                <a href="/logout">Sign Out</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div id="global-nav" class="col-md-12">
          <div id="logo">{{ html()->img(asset('img/jitterbug-logo.svg'), 'Jitterbug logo')->attribute('width', 56)->attribute('height', 54) }}</div>
          <nav>
            <ul>
              <li>
                <a class="{{$section==='dashboard' ? 'active' : ''}}" href="{{route('dashboard.index')}}"><i class="fa fa-dashboard fa-fw" aria-hidden="true"></i> Dashboard</a>
              </li>
              <li>
                <a class="{{$section==='items' ? 'active' : ''}}" href="{{route('items.index')}}"><i class="fa fa-headphones fa-fw" aria-hidden="true"></i> Audio Visual Items</a>
              </li>
              <li>
                <a class="{{$section==='instances' ? 'active' : ''}}" href="{{route('instances.index')}}"><i class="fa fa-database fa-fw" aria-hidden="true"></i> Preservation Instances</a>
              </li>
              <li>
                <a class="{{$section==='transfers' ? 'active' : ''}}" href="{{route('transfers.index')}}"><i class="fa fa-exchange fa-fw" aria-hidden="true"></i> Transfers</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="row">
        <div id="alert"></div>
      </div> 
