@extends('layouts.app')

@section('content')
    @if (empty($drama))
        <div class="p-6 rounded-xl bg-zinc-900 border border-zinc-800">
            <p class="text-zinc-400">Detail drama kosong / API error bro.</p>
        </div>
    @else
        <div class="grid md:grid-cols-3 gap-6">

            <div>
                <img src="{{ $drama['coverWap'] ?? 'https://placehold.co/600x800?text=No+Cover' }}"
                     class="rounded-2xl border border-zinc-800 w-full object-cover"
                     alt="{{ $drama['bookName'] ?? '' }}">
            </div>

            <div class="md:col-span-2">
                <h1 class="text-3xl font-bold">
                    {{ $drama['bookName'] ?? 'Detail Drama' }}
                </h1>

                <p class="text-zinc-400 mt-3 leading-relaxed">
                    {{ $drama['introduction'] ?? '-' }}
                </p>

                <div class="flex flex-wrap gap-2 mt-4">
                    @forelse(($drama['tags'] ?? []) as $tag)
                        <span class="text-xs px-3 py-1 rounded-full bg-zinc-900 border border-zinc-800">
                            {{ $tag }}
                        </span>
                    @empty
                        <span class="text-xs px-3 py-1 rounded-full bg-zinc-900 border border-zinc-800 text-zinc-400">
                            No tags
                        </span>
                    @endforelse
                </div>

                <div class="mt-6">
                    <a href="{{ route('drama.episodes', $drama['bookId']) }}"
                       class="inline-block px-5 py-3 rounded-xl bg-red-600 hover:bg-red-500 font-semibold">
                        Lihat Episode
                    </a>
                </div>
            </div>

        </div>
    @endif
@endsection
