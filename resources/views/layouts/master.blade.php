<!DOCTYPE html>
<html lang="en">

<head>
  @include('shared._head', ['title' => $title])
</head>

<body>
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