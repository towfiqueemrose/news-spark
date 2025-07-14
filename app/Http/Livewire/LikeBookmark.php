<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\News;
use App\Models\Like;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class LikeBookmark extends Component
{
    public $news;
    public $likesCount;
    public $isLiked;
    public $isBookmarked;

    public function mount(News $news)
    {
        $this->news = $news;
        $this->likesCount = $news->likes()->count();
        $this->isLiked = Auth::check() ? $news->isLikedBy(Auth::id()) : false;
        $this->isBookmarked = Auth::check() ? $news->isBookmarkedBy(Auth::id()) : false;
    }

    public function toggleLike()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->isLiked) {
            Like::where('user_id', Auth::id())->where('news_id', $this->news->id)->delete();
            $this->likesCount--;
            $this->isLiked = false;
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'news_id' => $this->news->id
            ]);
            $this->likesCount++;
            $this->isLiked = true;
        }
    }

    public function toggleBookmark()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->isBookmarked) {
            Bookmark::where('user_id', Auth::id())->where('news_id', $this->news->id)->delete();
            $this->isBookmarked = false;
        } else {
            Bookmark::create([
                'user_id' => Auth::id(),
                'news_id' => $this->news->id
            ]);
            $this->isBookmarked = true;
        }
    }

    public function render()
    {
        return view('livewire.like-bookmark');
    }
}