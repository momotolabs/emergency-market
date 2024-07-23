<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    @production
    @php
    $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    @endphp
    <link rel="stylesheet" href="{{ asset('/build/'.$manifest['resources/css/app.css']['file'])}}">
    <link rel="stylesheet" href="{{ asset('/build/'.$manifest['resources/css/fonts.css']['file'])}}">
    @else
    @vite(['resources/css/app.css', 'resources/css/fonts.css'])
    @endproduction
    <style>
      .error-bg {
        background: rgb(30,64,175);
        background: radial-gradient(circle, rgba(30,64,175,1) 0%, rgba(10,44,92,1) 57%, rgba(10,29,69,1) 100%);
      }
    </style>
</head>

<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0 flex-col error-bg">
      <img src="/custom-error-page.svg" alt="error page" class="left-0 top-0 w-[40%] h-1/2 mx-auto">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center pt-8 sm:justify-start sm:pt-0 mt-10">
                <div class="px-4 text-lg text-white font-medium border-r border-gray-400 tracking-wider">
                    @yield('code')
                </div>

                <div class="ml-4 text-lg text-white uppercase tracking-wider">
                    @yield('message')
                </div>
            </div>
            <div class="flex items-center justify-center">
                @yield('button')
            </div>
        </div>
</body>

</html>
