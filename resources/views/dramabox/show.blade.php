@extends('layouts.app')

@section('content')

@php
    $book = $detail['data'] ?? $detail ?? null;
@endphp

@if(!$book)
    <div class="bg-red-900/30 border border-red-800 p-5 rounded-2xl">
        Detail drama tidak ditemukan.
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-[260px_1fr] gap-6">

        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden">
            <div class="aspect-[3/4] bg-zinc-800">
                <img src="{{ $book['coverWap'] ?? $book['cover'] ?? '' }}"
                     class="w-full h-full object-cover"
                     alt="{{ $book['bookName'] ?? 'cover' }}"
                     onerror="this.style.display='none'">
            </div>
        </div>

        <div>
            <a href="{{ route('home') }}" class="text-zinc-400 hover:text-white text-sm">
                ← Back
            </a>

            <h1 class="text-2xl font-bold mt-2">
                {{ $book['bookName'] ?? 'Untitled' }}
            </h1>

            <div class="flex flex-wrap gap-2 mt-3">
                @foreach(($book['tags'] ?? []) as $tag)
                    <span class="px-3 py-1 rounded-full bg-zinc-800 text-xs text-zinc-200">
                        {{ $tag }}
                    </s
