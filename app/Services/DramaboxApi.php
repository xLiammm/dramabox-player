<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DramaboxApi
{
    private string $baseUrl;

    public function __construct()
    {
    $this->baseUrl = rtrim(config('services.dramabox.base_url'), '/');
    }


    private function get(string $endpoint, array $query = []): array
{
    try {
        $res = Http::timeout(15)
            ->withHeaders([
                'Accept' => 'application/json',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120 Safari/537.36',
            ])
            ->get($this->baseUrl . $endpoint, $query);

        if (!$res->successful()) {
            return [];
        }

        $json = $res->json();

        if (!is_array($json)) {
            return [];
        }

        return $json;
    } catch (\Throwable $e) {
        return [];
    }
}



    public function latest(): array
    {
    $data = $this->get('/dramabox/latest');

    // kalau API balikin {data: []}
    if (isset($data['data']) && is_array($data['data'])) {
        return $data['data'];
    }

    return $data;
    }


    public function trending(): array
    {
    $data = $this->get('/dramabox/trending');

    if (isset($data['data']) && is_array($data['data'])) {
        return $data['data'];
    }

    return $data;
    }


    public function search(string $q): array
{
    return $this->get('/dramabox/search', [
        'query' => $q
    ]);
}


    public function detail(string $bookId): array
    {
        return $this->get('/dramabox/detail', ['bookId' => $bookId]);
    }

    public function allEpisode(string $bookId): array
{
    return $this->get('/dramabox/allEpisode', ['bookId' => $bookId]);
}

}
