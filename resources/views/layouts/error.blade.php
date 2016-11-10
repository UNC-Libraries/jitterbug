<!DOCTYPE html>
<html lang="en">

<head>
  @include('shared._head', ['title' => $title])
</head>
<body style="min-width: 400px !important;">
  <div class="container">

    <header class="centered" style="margin-top: 7rem; margin-bottom: -1rem">
      {!! Html::image("img/$logo.svg", 'Jitterbug logo', array('width' => 84 , 'height' => 81)) !!}
    </header>

    <section class="centered">
      @yield('panel')
    </section>

    <footer class="centered" style="margin-top: 1.25rem">
      {!! Html::image('img/unc-logo.png', 'UNC logo', array('width' => 153 , 'height' => 34)) !!}
    </footer>

  </div>
  @include('shared._scripts')
</body>

</html>