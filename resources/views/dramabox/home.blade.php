@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Drama Terbaru</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse ($dramas as $item)
            <a href="{{ route('drama.detail', $item['bookId']) }}"
               class="bg-zinc-900 rounded-xl overflow-hidden border border-zinc-800 hover:border-red-500 transition">

                <img src="{{ $item['coverWap'] }}"
                     class="w-full h-52 object-cover"
                     alt="{{ $item['bookName'] }}">

                <div class="p-3">
                    <h2 class="font-semibold text-sm line-clamp-2">
                        {{ $item['bookName'] }}
                    </h2>

                    <p class="text-xs text-zinc-400 mt-1">
                        Episode: {{ $item['chapterCount'] ?? '-' }}
                    </p>
                </div>
            </a>
        @empty
            <div class="col-span-2 md:col-span-4 p-6 rounded-xl bg-zinc-900 border border-zinc-800">
                <p class="text-zinc-400">Data kosong / API error bro.</p>
            </div>
        @endforelse
    </div>
@endsection
