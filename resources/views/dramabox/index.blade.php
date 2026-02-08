@extends('layouts.app')

@section('content')

@php
    // API lu return array langsung
    $books = $books ?? [];
@endphp

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">🔥 Latest</h1>

    <a href="https://dramabox.sansekai.my.id/api" target="_blank"
       class="text-sm text-zinc-400 hover:text-white">
        API Docs ↗
    </a>
</div>

@if(count($books) === 0)
    <div class="bg-red-900/30 border border-red-800 p-5 rounded-2xl">
        Data latest kosong / API error bro.
    </div>
@else
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($books as $book)
            <a href="{{ route('book.show', $book['bookId']) }}"
               class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden hover:bg-zinc-800 transition">

                <div class="aspect-[3/4] bg-zinc-800">
                    <img src="{{ $book['coverWap'] ?? '' }}"
                         class="w-full h-full object-cover"
                         alt="{{ $book['bookName'] ?? 'cover' }}"
                         loading="lazy"
                         onerror="this.style.display='none'">
                </div>

                <div class="p-3">
                    <h2 class="font-semibold text-sm leading-snug line-clamp-2">
                        {{ $book['bookName'] ?? 'Untitled' }}
                    </h2>

                    <div class="text-xs text-zinc-400 mt-2">
                        {{ $book['chapterCount'] ?? 0 }} Episode
                    </div>

                    @if(!empty($book['rankVo']['hotCode']))
                        <div class="text-xs text-emerald-400 mt-1">
                            🔥 {{ $book['rankVo']['hotCode'] }}
                        </div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
@endif

@endsection
