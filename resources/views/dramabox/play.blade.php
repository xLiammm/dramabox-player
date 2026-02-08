@extends('layouts.app')

@section('content')

@php
    $data = $play['data'] ?? [];

    $chapterNum = $data['chapterNum'] ?? null;
    $chapterTitle = $data['chapterTitle'] ?? null;

    $videoInfo = $data['chapterVideoInfo'][0] ?? null;
    $paths = $videoInfo['videoPathList'] ?? [];

    $picked = collect($paths)->firstWhere('isDefault', 1);
    $videoUrl = $picked['videoPath'] ?? ($paths[0]['videoPath'] ?? null);

    $prev = $data['preChapterId'] ?? null;
    $next = $data['nextChapterId'] ?? null;
@endphp

<div class="flex items-center justify-between gap-3 flex-wrap mb-4">
    <a href="{{ route('book.chapters', $bookId) }}"
       class="text-zinc-400 hover:text-white text-sm">
        ← Back to Episodes
    </a>

    <div class="text-sm text-zinc-400">
        Book: <span class="text-zinc-200">{{ $bookId }}</span>
    </div>
</div>

<h1 class="text-xl font-bold mb-4">
    ▶ Episode {{ $chapterNum ?? '?' }}
    @if($chapterTitle)
        — {{ $chapterTitle }}
    @endif
</h1>

@if(!$videoUrl)
    <div class="bg-red-900/30 border border-red-800 p-5 rounded-2xl">
        Video URL tidak ditemukan bro.
        <pre class="text-xs mt-3 bg-black/50 p-3 rounded-xl overflow-auto max-h-96">{{ json_encode($play, JSON_PRETTY_PRINT) }}</pre>
    </div>
@else
    <div class="bg-black rounded-2xl overflow-hidden border border-zinc-800">
        <video controls autoplay playsinline class="w-full h-auto">
            <source src="{{ $videoUrl }}" type="video/mp4">
        </video>
    </div>

    {{-- Quality selector --}}
    <div class="mt-5 bg-zinc-900 border border-zinc-800 rounded-2xl p-4">
        <h2 class="font-semibold mb-3">Quality</h2>

        <div class="flex flex-wrap gap-2">
            @foreach($paths as $p)
                <a href="{{ route('book.play', ['bookId' => $bookId, 'chapterId' => $chapterId]) }}?q={{ $p['quality'] }}"
                   class="px-4 py-2 rounded-xl text-sm border border-zinc-700 hover:bg-zinc-800">
                    {{ $p['quality'] }}p
                    @if(($p['isDefault'] ?? 0) == 1) ⭐ @endif
                </a>
            @endforeach
        </div>

        <div class="text-xs text-zinc-400 mt-4 break-all">
            Source: {{ $videoUrl }}
        </div>
    </div>

    {{-- Next / Prev --}}
    <div class="mt-6 flex gap-3 flex-wrap">
        @if($prev)
            <a href="{{ route('book.play', ['bookId' => $bookId, 'chapterId' => $prev]) }}"
               class="bg-zinc-800 hover:bg-zinc-700 px-5 py-3 rounded-xl font-semibold">
                ⬅ Prev
            </a>
        @endif

        @if($next)
            <a href="{{ route('book.play', ['bookId' => $bookId, 'chapterId' => $next]) }}"
               class="bg-blue-600 hover:bg-blue-700 px-5 py-3 rounded-xl font-semibold">
                Next ➡
            </a>
        @endif
    </div>
@endif

@endsection
