<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ Vite::image('icon.png') }}">

    <title>@yield('title', env('APP_NAME'))</title>
    <!-- Stylesheet -->
    @vite(['resources/css/app.css', 'resources/sass/main.sass', 'resources/js/app.js',])
</head>
<body class="antialiased">

@include('shared.flash')

<main class="bg-gradient-to-b from-white to-[#bce0e1] md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-12">
    <div class="container">
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-block" rel="home">
                <img src="{{ Vite::image('logo.png') }}" class="w-[148px] md:w-[242px] h-[36px] md:h-[72px]" alt="CutCode">
            </a>
        </div>

        @yield('content')

    </div>
</main>

</body>
</html>
