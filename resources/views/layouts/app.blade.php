<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dracin Aceng</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-950 text-zinc-100">

    <nav class="border-b border-zinc-800 bg-zinc-950/80 backdrop-blur sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-xl">
                Dracin<span class="text-red-500">Aceng</span>
            </a>

            <div class="flex gap-4 text-sm">
                <a href="{{ route('home') }}" class="hover:text-red-400">Latest</a>
                <a href="{{ route('trending') }}" class="hover:text-red-400">Trending</a>
                <a href="{{ route('drama.search') }}"class="px-4 py-2 rounded-xl hover:bg-zinc-900 transition">Search</a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-6">
        @yield('content')
    </main>

</body>
</html>
