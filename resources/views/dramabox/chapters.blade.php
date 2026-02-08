@extends('layouts.app')

@section('content')

@php
    $list = $chapters['data'] ?? $chapters ?? [];
@endphp

<a href="{{ route('book.show', $bookId) }}" class="text-zinc-400 hover:text-white text-sm">
    ← Back to Detail
</a>

<div class="flex items-center justify-between mt-2 mb-6">
    <h1 class="text-2xl font-bold">📺 Episodes</h1>

    <div class="text-sm text-zinc-400">
        Total: {{ count($list) }}
    </div>
</div>

@if(count($list) === 0)
    <div class="bg-red-900/30 border border-red-800 p-5 rounded-2xl">
        Episode kosong / API error bro.
    </div>
@else
    <div class="grid grid-cols-2 md:grid-cols-5 lg:grid-cols-7 gap-3">
        @foreach($list as $ep)
            @php
                $chapterId = $ep['chapterId'] ?? null;
                $chapterNum = $ep['chapterNum'] ?? $ep['episode'] ?? '?';
            @endphp

            <a href="{{ route('book.play', ['bookId' => $bookId, 'chapterId' => $chapterId]) }}"
               class="bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-3 hover:bg-zinc-800 transition text-center">

                <div class="font-bold text-base">
                    EP {{ $chapterNum }}
                </div>

                <div class="text-xs text-zinc-400 mt-1">
                    ▶ Play
                </div>
            </a>
        @endforeach
    </div>
@endif

@endsection
