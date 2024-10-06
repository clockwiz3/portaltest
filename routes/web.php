<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ControlPanelController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Models\News;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/search', function (Request $request) {
        $query = $request->input('query');
        $news = News::where('title', 'LIKE', "%{$query}%")->get();

        return response()->json($news);
    })->name('dashboard.search');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/control-panel', [ControlPanelController::class, 'index'])->name('control-panel.index');
    Route::post('/fetch-news', [DashboardController::class, 'fetch'])->name('news.fetch');
    Route::get('/latest-news', [DashboardController::class, 'getLatestNews'])->name('news.latest');
    Route::post('/search-news', [DashboardController::class, 'search'])->name('news.search');
});

Route::get('/verify', [VerificationController::class, 'index'])->name('verification.index');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verification.verify');

require __DIR__ . '/auth.php';