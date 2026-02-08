@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Search Drama</h1>

    <form method="GET" action="{{ route('drama.search') }}" class="flex gap-2 mb-6">
        <input
            type="text"
            name="q"
            value="{{ $q }}"
            placeholder="Cari judul drama..."
            class="w-full px-4 py-3 rounded-xl bg-zinc-900 border border-zinc-800 focus:outline-none focus:border-red-500"
        >
        <button
            class="px-5 py-3 rounded-xl bg-red-600 hover:bg-red-500 font-semibold"
        >
            Cari
        </button>
    </form>

    @if ($q === '')
        <div class="p-6 rounded-xl bg-zinc-900 border border-zinc-800">
            <p class="text-zinc-400">Ketik judul drama dulu bro 😄</p>
        </div>
    @elseif (empty($dramas))
        <div class="p-6 rounded-xl bg-zinc-900 border border-zinc-800">
            <p class="text-zinc-400">Gak nemu hasil untuk: <span class="text-white font-semibold">{{ $q }}</span></p>
        </div>
    @else
        <p class="text-zinc-400 mb-4">
            Hasil untuk: <span class="text-white font-semibold">{{ $q }}</span>
        </p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($dramas as $item)
                <a href="{{ route('drama.detail', $item['bookId']) }}"
                   class="bg-zinc-900 rounded-xl overflow-hidden border border-zinc-800 hover:border-red-500 transition">

                    <img src="{{ $item['cover'] ?? 'https://placehold.co/600x800?text=No+Cover' }}"
                                class="w-full h-52 object-cover"
                                alt="{{ $item['bookName'] ?? '' }}">

                    <div class="p-3">
                        <h2 class="font-semibold text-sm line-clamp-2">
                            {{ $item['bookName'] ?? '-' }}
                        </h2>
                        <p class="text-xs text-zinc-400 mt-1">Lihat detail →</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection
