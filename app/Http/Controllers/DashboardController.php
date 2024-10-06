<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Artisan;
use App\Events\NewsUpdated;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $news = News::orderBy('published_at', 'desc')->take(10)->get();

        return view('dashboard.index', compact('news'));
    }

    public function fetch(Request $request)
    {
        Artisan::call('fetch:news');

        NewsUpdated::dispatch($request->user());

        return response()->json(['message' => 'Новости обновлены']);
    }

    public function getLatestNews()
    {
        $news = News::orderBy('published_at', 'desc')->take(10)->get();

        return response()->json($news);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            $news = News::orderBy('published_at', 'desc')->take(10)->get();
        } else {
            $news = News::where('title', 'like', "%{$query}%")->latest()->get();
        }

        return response()->json($news);
    }

}
