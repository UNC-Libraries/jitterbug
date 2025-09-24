<!DOCTYPE html>
<html lang="en">

<head>
  @include('shared._head', ['title' => $title])
</head>
{{-- $controller and $action are injected in the AppServiceProvider 
and are used to route JavaScript in app.js --}}
<body data-controller="{{$controller}}" data-action="{{$action}}" style="min-width: 400px !important;">
  <div class="container">

    <header class="centered" style="margin-top: 7rem; margin-bottom: -1rem">
      {{ html()->img(asset('img/jitterbug-logo.svg'), 'Jitterbug logo')->attribute('width', 84)->attribute('height', 81) }}
    </header>

    <section class="centered">
      @yield('panel')
    </section>

    <footer class="centered" style="margin-top: 1.25rem">
      {{ html()->img(asset('img/unc-logo.png'), 'UNC logo')->attribute('width', 153)->attribute('height', 34) }}
    </footer>

  </div>
</body>

</html>