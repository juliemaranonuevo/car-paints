<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Car Paint | @yield('page_title')</title>
    @include('layouts.header') 
</head>
<body>
    <div class="container mb-5">
        @include('layouts.navbar') 
        @yield('content')
    </div>

    @include('layouts.footer') 
    @yield('script')
</body>
</html>
