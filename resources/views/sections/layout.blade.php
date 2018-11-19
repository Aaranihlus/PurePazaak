<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Pure Pazaak</title>

  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

</head>
<body>

  <div class="container-fluid p-0" id="app">
    <profile></profile>
    @yield('content')
  </div>

  <script src="{{ mix('/js/app.js') }}"></script>

</body>
</html>
