<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'image',
        'video',
        'category_id',
        'user_id',
        'view_count'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get image URL (Cloudinary URL or default)
    public function getImageUrlAttribute()
    {
        return $this->image ? $this->image : asset('images/placeholder.jpg');
    }

    // Get excerpt
    public function getExcerptAttribute()
    {
        return \Str::limit(strip_tags($this->body), 150);
    }

    public function getVideoUrlAttribute()
    {
        return $this->video ? $this->video : null;
    }

    public function hasVideo()
    {
        return !empty($this->video);
    }

    // Route key name
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Add bookmarks relationship
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // Check if user has liked the news
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    // Check if user has bookmarked the news
    public function isBookmarkedBy($userId)
    {
        return $this->bookmarks()->where('user_id', $userId)->exists();
    }
}
