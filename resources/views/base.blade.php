<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>
        {{-- script --}}
        <script src="{{asset('js/app.js')}}" defer></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}" >
        
    </head>
    <body>
        @yield('nav')
        <div id="app">
            @yield('content')
        </div>
        @yield('script')
    </body>
</html>