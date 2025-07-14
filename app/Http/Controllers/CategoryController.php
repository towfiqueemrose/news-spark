<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        // Get paginated news for this category
        $news = $category->news()
            ->with(['category', 'user'])
            ->latest();
            
        // Get all categories for sidebar
        $categories = Category::withCount('news')
            ->orderBy('name')
            ->get();
            
        // Get popular news (most viewed)
        $popularNews = $category->news()
            ->with(['category', 'user'])
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();
            
        return view('categories.show', compact('category', 'news', 'categories', 'popularNews'));
    }
}