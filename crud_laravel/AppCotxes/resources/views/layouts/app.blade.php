<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'AppCotxes'))</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">
    <nav class="h-14 flex items-center content-column border-b border-hairline">
        <a href="{{ route('cotxes.index') }}" class="font-display text-body-sm-strong text-ink no-underline">
            Cotxes
        </a>
    </nav>

    <main class="flex-1 content-column pt-8 pb-12">
        @if (session('success'))
            <p class="flash-message">{{ session('success') }}</p>
        @endif

        @yield('content')
    </main>

    <footer class="content-column py-4 border-t border-hairline text-caption-sm text-body text-center">
        &copy; {{ date('Y') }} AppCotxes
    </footer>
</body>
</html>
