<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ Vite::image('icon.png') }}">

    <title>@yield('title', $seo_title ?? env('APP_NAME'))</title>
    <!-- Stylesheet -->
    @vite(['resources/css/app.css', 'resources/sass/main.sass', 'resources/js/app.js',])
</head>
<body class="antialiased">

@include('shared.flash')

@include('shared.header')

<main class="py-16 lg:py-20">
    <div class="container">
        @yield('content')
    </div>
</main>

@include('shared.footer')

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
