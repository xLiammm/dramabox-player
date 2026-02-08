<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DramaboxService
{
    public function __construct(
        protected string $baseUrl = ''
    ) {
        $this->baseUrl = rtrim(config('services.dramabox.base_url'), '/');
    }

    public function latest()
    {
        return Http::timeout(15)
            ->get($this->baseUrl . '/latest')
            ->json();
    }

    public function detail(string $bookId)
    {
        return Http::timeout(15)
            ->get($this->baseUrl . '/detail', [
                'bookId' => $bookId,
            ])
            ->json();
    }

    public function allEpisode(string $bookId): array
{
    return $this->get('/dramabox/allEpisode', ['bookId' => $bookId]);
}

    public function chapter(string $chapterId)
    {
        return Http::timeout(15)
            ->get($this->baseUrl . '/chapter', [
                'chapterId' => $chapterId,
            ])
            ->json();
    }
}
