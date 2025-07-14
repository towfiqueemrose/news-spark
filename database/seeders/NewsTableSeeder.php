<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsTableSeeder extends Seeder
{
    public function run()
    {
        // ডিফল্ট ইউজার আইড 1 ধরে নিচ্ছি
        $userId = User::first()->id ?? 1;

        $newsItems = [
            [
                'title' => 'Political Stability Boosts Economy',
                'slug' => Str::slug('Political Stability Boosts Economy'),
                'body' => 'The current political stability has positively impacted the country\'s economic growth...',
                'image' => 'politics-news.jpg',
                'category_id' => Category::where('slug', 'politics')->first()->id,
                'user_id' => $userId,
                'view_count' => 0,
            ],
            [
                'title' => 'Local Team Wins Championship',
                'slug' => Str::slug('Local Team Wins Championship'),
                'body' => 'In an exciting final match, the local team won the national championship with an outstanding performance...',
                'image' => 'sports-news.jpg',
                'category_id' => Category::where('slug', 'sports')->first()->id,
                'user_id' => $userId,
                'view_count' => 0,
            ],
            [
                'title' => 'New AI Technology Released',
                'slug' => Str::slug('New AI Technology Released'),
                'body' => 'A groundbreaking AI technology has been released, promising to revolutionize various industries...',
                'image' => 'technology-news.jpg',
                'category_id' => Category::where('slug', 'technology')->first()->id,
                'user_id' => $userId,
                'view_count' => 0,
            ],
            [
                'title' => 'Upcoming Blockbuster Movies to Watch',
                'slug' => Str::slug('Upcoming Blockbuster Movies to Watch'),
                'body' => 'The entertainment industry is set to release several blockbuster movies this season...',
                'image' => 'entertainment-news.jpg',
                'category_id' => Category::where('slug', 'entertainment')->first()->id,
                'user_id' => $userId,
                'view_count' => 0,
            ],
            [
                'title' => 'Tips for a Healthy Lifestyle',
                'slug' => Str::slug('Tips for a Healthy Lifestyle'),
                'body' => 'Health experts share valuable tips on maintaining a healthy lifestyle amid busy schedules...',
                'image' => 'health-news.jpg',
                'category_id' => Category::where('slug', 'health')->first()->id,
                'user_id' => $userId,
                'view_count' => 0,
            ],
        ];

        foreach ($newsItems as $news) {
            News::create($news);
        }
    }
}
