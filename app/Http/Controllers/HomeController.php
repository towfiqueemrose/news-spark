<?php

// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = News::with(['category', 'user'])
            ->latest()
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        $topNews = News::with(['category', 'user'])
            ->orderBy('view_count', 'desc')
            ->take(2)
            ->get();

            $mostLikedNews = Cache::remember('most_liked_news', 600, function () {
                return News::with(['category'])
                    ->withCount('likes')
                    ->orderBy('likes_count', 'desc')
                    ->take(2)
                    ->get();
            });

        $categories = Category::withCount('news')
            ->has('news')
            ->with(['news' => function ($query) {
                $query->latest()->take(1);
            }])
            ->take(7)
            ->get();

            $bangladeshNews = Cache::remember('bangladesh_news', 600, function () {
                return News::with('category')
                    ->whereHas('category', function ($query) {
                        $query->where('name', 'Bangladesh');
                    })
                    ->latest()
                    ->take(7)
                    ->get();
            });

        return view('home', compact('latestNews', 'topNews', 'categories', 'mostLikedNews', 'bangladeshNews'));
    }
}
