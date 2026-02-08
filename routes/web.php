<?php

use App\Http\Controllers\DramaboxController;
use Illuminate\Support\Facades\Route;

Route::get("/", [DramaboxController::class, "index"])->name("home");

Route::get("/book/{bookId}", [DramaboxController::class, "show"])->name("book.show");

Route::get("/book/{bookId}/chapters", [DramaboxController::class, "chapters"])->name("book.chapters");

Route::get("/book/{bookId}/play/{chapterId}", [DramaboxController::class, "play"])->name("book.play");

Route::get('/', [DramaboxController::class, 'home'])->name('home');
Route::get('/trending', [DramaboxController::class, 'trending'])->name('trending');

Route::get('/drama/{bookId}', [DramaboxController::class, 'detail'])->name('drama.detail');
Route::get('/drama/{bookId}/episodes', [DramaboxController::class, 'episodes'])->name('drama.episodes');

Route::get('/search', [DramaboxController::class, 'search'])->name('drama.search');

Route::get('/debug-config', function () {
    return [
        'env' => env('DRAMABOX_API'),
        'config' => config('services.dramabox.base_url'),
    ];
});

Route::get('/debug-api', function () {
    $baseUrl = config('services.dramabox.base_url');

    $response = Http::get($baseUrl . '/dramabox/latest');

    return [
        'base_url' => $baseUrl,
        'url_hit' => $baseUrl . '/dramabox/latest',
        'status' => $response->status(),
        'json' => $response->json(),
        'raw' => $response->body(),
    ];
});