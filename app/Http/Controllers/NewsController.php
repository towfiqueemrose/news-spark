<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    public function show(News $news)
{
    $news->increment('view_count');
    
    $news->load(['category', 'user', 'comments.user', 'comments.replies.user']);
    
    $relatedNews = News::where('category_id', $news->category_id)
        ->where('id', '!=', $news->id)
        ->latest()
        ->take(3)
        ->get();
        
    return view('news.show', compact('news', 'relatedNews'));
}
}