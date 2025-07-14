<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Support\Facades\Auth;

class CommentSection extends Component
{
    public $news;
    public $body = '';
    public $parentId = null;

    protected $rules = [
        'body' => 'required|string|max:1000',
    ];

    public function mount(News $news)
    {
        $this->news = $news->load('comments.user', 'comments.replies.user');
    }

    public function postComment()
    {
        $this->validate();

        $comment = new Comment([
            'body' => $this->body,
            'user_id' => Auth::id(),
            'parent_id' => $this->parentId,
        ]);

        $this->news->comments()->save($comment);

        $this->body = '';
        $this->parentId = null;

        $this->news = $this->news->fresh('comments.user', 'comments.replies.user');
    }

    public function setReply($commentId)
    {
        $this->parentId = $commentId;
    }

    public function cancelReply()
    {
        $this->parentId = null;
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if (Auth::id() === $comment->user_id || Auth::user()->isAdmin()) {
            $comment->delete();
            $this->news = $this->news->fresh('comments.user', 'comments.replies.user');
        }
    }

    public function render()
    {
        return view('livewire.comment-section');
    }
}
