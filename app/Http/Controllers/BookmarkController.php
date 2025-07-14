<?php

namespace App\Http\Controllers;

use App\Models\{Bookmark, News};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Display user's bookmarks
     */
    public function index()
    {
        try {
            $bookmarks = Auth::user()
                ->bookmarks()
                ->with(['news' => function($query) {
                    $query->select('id', 'title', 'slug', 'image');
                }])
                ->latest()
                ->paginate(10);

            return view('bookmarks.index', compact('bookmarks'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load bookmarks');
        }
    }

    /**
     * Store a new bookmark
     */
    public function store(Request $request, News $news)
    {
        try {
            $exists = Auth::user()->bookmarks()
                ->where('news_id', $news->id)
                ->exists();

            if ($exists) {
                return back()->with('info', 'Already bookmarked');
            }

            Auth::user()->bookmarks()->create(['news_id' => $news->id]);

            return back()->with('success', 'Bookmarked successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Bookmarking failed');
        }
    }

    /**
     * Remove a bookmark
     */public function destroy(Bookmark $bookmark)
{
    // Manual authorization check
    if (Auth::user()->id !== $bookmark->user_id) {
        abort(403, 'Unauthorized action.');
    }

    try {
        $bookmark->delete();
        return back()->with('success', 'Bookmark removed');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to remove bookmark');
    }
}
}