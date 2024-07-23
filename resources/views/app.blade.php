<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ url('favicon.ico') }}">
    <title>emergency Market</title>

    @inertiaHead
    @routes()

  @production
  @php
  $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
  @endphp
  <script type="module" src="{{ asset('/build/'.$manifest['resources/js/app.js']['file']) }}"></script>
  <link rel="stylesheet" href="{{ asset('/build/'.$manifest['resources/css/app.css']['file'])}}">
  <link rel="stylesheet" href="{{ asset('/build/'.$manifest['resources/css/fonts.css']['file'])}}">
  @else
  @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/css/fonts.css'])
  @endproduction
</head>

<body class="antialiased">

@inertia
</body>

</html>
