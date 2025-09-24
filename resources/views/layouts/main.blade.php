<!DOCTYPE html>
<html lang="en">

<head>
  @include('shared._head', ['title' => $title])
</head>
{{-- $controller and $action are injected in the AppServiceProvider 
and are used to route JavaScript in app.js --}}
<body data-controller="{{$controller}}" data-action="{{$action}}">
  <div class="container" style="min-width: 768px !important;">

    <header id="header">
      @include('shared._header')
    </header>

    <section id="content">
      @yield('content')
    </section>

    <footer id="footer">
      @include('shared._footer')
    </footer>

  </div>
  @include('shared._scripts')
</body>

</html>