@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Daftar Episode</h1>

    @if (empty($episodes))
        <div class="p-6 rounded-xl bg-zinc-900 border border-zinc-800">
            <p class="text-zinc-400">Episode kosong / API error bro.</p>
        </div>
    @else
        @php
            // helper ambil list video quality dari episode
            function getVideoOptions($ep) {
                $cdnDefault = collect($ep['cdnList'] ?? [])->firstWhere('isDefault', 1);
                if (!$cdnDefault) $cdnDefault = ($ep['cdnList'][0] ?? null);

                $list = collect($cdnDefault['videoPathList'] ?? [])
                    ->sortByDesc('quality')
                    ->values()
                    ->all();

                return $list;
            }

            $firstEp = $episodes[0];
            $firstOptions = getVideoOptions($firstEp);

            // cari default
            $firstDefault = collect($firstOptions)->firstWhere('isDefault', 1);

            // fallback ke quality tertinggi
            if (!$firstDefault) {
                $firstDefault = $firstOptions[0] ?? null;
            }

            $firstUrl = $firstDefault['videoPath'] ?? null;
            $firstTitle = $firstEp['chapterName'] ?? 'Episode 1';
        @endphp

        {{-- PLAYER --}}
        <div id="playerBox" class="rounded-2xl overflow-hidden border border-zinc-800 bg-black mb-4">
            @if ($firstUrl)
                <video id="videoPlayer" controls class="w-full h-[420px] bg-black">
                    <source id="videoSource" src="{{ $firstUrl }}" type="video/mp4">
                </video>
            @else
                <div class="p-6 text-zinc-400">
                    Video URL gak ketemu bro 😭
                </div>
            @endif
        </div>

        {{-- INFO PLAYER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
            <div>
                <h2 id="episodeTitle" class="text-lg font-semibold">
                    {{ $firstTitle }}
                </h2>
                <p class="text-sm text-zinc-400">
                    Klik episode di bawah buat ganti video
                </p>
            </div>

            {{-- PILIH QUALITY --}}
            <div class="flex items-center gap-2">
                <span class="text-sm text-zinc-400">Quality:</span>
                <select id="qualitySelect"
                        class="bg-zinc-900 border border-zinc-800 rounded-xl px-3 py-2 text-sm">
                    @foreach($firstOptions as $opt)
                        <option value="{{ $opt['videoPath'] }}">
                            {{ $opt['quality'] }}p
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- LIST EPISODE --}}
        <div class="grid gap-2">
            @foreach($episodes as $ep)
                @php
                    $options = getVideoOptions($ep);
                    $default = collect($options)->firstWhere('isDefault', 1);
                    if (!$default) $default = $options[0] ?? null;

                    $defaultUrl = $default['videoPath'] ?? null;

                    $epName = $ep['chapterName'] ?? ('Episode ' . ($loop->iteration));
                    $epIndex = $loop->index; // 0 based
                @endphp

                <button
                    type="button"
                    data-episode-index="{{ $epIndex }}"
                    data-episode-title="{{ $epName }}"
                    data-episode-options='@json($options)'
                    class="episodeBtn text-left p-4 rounded-xl bg-zinc-900 border border-zinc-800 hover:border-red-500 transition"
                    onclick="selectEpisode(this)"
                >
                    <div class="flex items-center justify-between">
                        <span class="font-semibold">{{ $epName }}</span>
                        <span class="text-xs text-zinc-400">
                            {{ count($options) }} quality
                        </span>
                    </div>
                </button>
            @endforeach
        </div>

        <script>
            const video = document.getElementById('videoPlayer');
            const source = document.getElementById('videoSource');
            const titleEl = document.getElementById('episodeTitle');
            const qualitySelect = document.getElementById('qualitySelect');
            const playerBox = document.getElementById('playerBox');

            let currentEpisodeOptions = [];
            let currentEpisodeIndex = 0;

            function highlightEpisode(index) {
                document.querySelectorAll('.episodeBtn').forEach(btn => {
                    btn.classList.remove('border-red-500');
                    btn.classList.add('border-zinc-800');
                });

                const active = document.querySelector(`.episodeBtn[data-episode-index="${index}"]`);
                if (active) {
                    active.classList.remove('border-zinc-800');
                    active.classList.add('border-red-500');
                }
            }

            function loadQualityOptions(options) {
                currentEpisodeOptions = options || [];

                qualitySelect.innerHTML = '';

                currentEpisodeOptions.forEach(opt => {
                    const o = document.createElement('option');
                    o.value = opt.videoPath;
                    o.textContent = opt.quality + 'p';
                    if (opt.isDefault === 1) o.selected = true;
                    qualitySelect.appendChild(o);
                });

                // kalau ga ada yg default, pilih yang pertama
                if (qualitySelect.options.length > 0 && qualitySelect.selectedIndex === -1) {
                    qualitySelect.selectedIndex = 0;
                }
            }

            function playUrl(url) {
                if (!url) return;

                video.pause();
                source.src = url;
                video.load();
                video.play();

                // scroll biar user langsung ke player (enak di hp)
                playerBox.scrollIntoView({ behavior: "smooth", block: "start" });
            }

            function selectEpisode(btn) {
                const idx = parseInt(btn.dataset.episodeIndex);
                const title = btn.dataset.episodeTitle;
                const options = JSON.parse(btn.dataset.episodeOptions || "[]");

                currentEpisodeIndex = idx;
                titleEl.textContent = title;

                loadQualityOptions(options);
                highlightEpisode(idx);

                // auto play default quality
                const defaultOpt = options.find(o => o.isDefault === 1) || options[0];
                playUrl(defaultOpt?.videoPath);
            }

            // ganti quality tanpa ganti episode
            qualitySelect.addEventListener('change', function() {
                playUrl(this.value);
            });

            // default highlight episode 0
            highlightEpisode(0);

            // set options pertama biar quality dropdown sync
            currentEpisodeOptions = @json($firstOptions);
        </script>
    @endif
@endsection
