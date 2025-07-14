<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, News $news)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);
        
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = Auth::id();
        $comment->news_id = $news->id;
        
        if ($request->parent_id) {
            $comment->parent_id = $request->parent_id;
        }
        
        $comment->save();
        
        return back()->with('success', 'Comment added successfully');
    }
    
    public function destroy(Comment $comment)
    {
        // Check if user owns the comment or is admin
        if (Auth::id() !== $comment->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $comment->delete();
        return back()->with('success', 'Comment deleted successfully');
    }
}