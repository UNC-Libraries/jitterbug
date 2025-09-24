  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <link href='https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:300' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,400italic,600italic' rel='stylesheet' type='text/css'>

  <script src="{{ asset('js/charts.loader.min.js') }}"></script>
  @vite(['resources/assets/sass/app.scss', 'resources/assets/js/app.js'])

  <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16" />

  <title>Jitterbug | {{ $title }}</title>
