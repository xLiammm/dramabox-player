<?php

namespace App\Http\Controllers;

use App\Services\DramaboxApi;
use Illuminate\Http\Request;

class DramaboxController extends Controller
{
    public function home(DramaboxApi $api)
    {
    $dramas = $api->latest();
    return view('dramabox.home', compact('dramas'));
    }



    public function trending(DramaboxApi $api)
    {
        $dramas = $api->trending();
        return view('dramabox.trending', compact('dramas'));
    }

    public function detail(DramaboxApi $api, string $bookId)
    {
        $drama = $api->detail($bookId);
        return view('dramabox.detail', compact('drama'));
    }

    public function episodes(DramaboxApi $api, string $bookId)
    {
    $episodes = $api->allEpisode($bookId) ?? [];

    // ambil episode dari query param
    $selectedEp = request('ep');

    // default: episode pertama
    if (!$selectedEp && isset($episodes[0])) {
        $selectedEp = $episodes[0]['episode'] ?? 1;
    }

    // cari data episode yang dipilih
    $selectedData = collect($episodes)->firstWhere('episode', (int) $selectedEp);

    return view('dramabox.episodes', compact('episodes', 'bookId', 'selectedEp', 'selectedData'));
    }

    public function search(Request $request, DramaboxApi $api)
    {
    $q = trim($request->query('q', ''));

    $dramas = [];
    if ($q !== '') {
        $dramas = $api->search($q);
    }

    return view('dramabox.search', compact('dramas', 'q'));
    }


}
