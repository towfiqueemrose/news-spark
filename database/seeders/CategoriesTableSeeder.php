<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Politics', 'slug' => 'politics', 'image' => 'politics.jpg'],
            ['name' => 'Sports', 'slug' => 'sports', 'image' => 'sports.jpg'],
            ['name' => 'Technology', 'slug' => 'technology', 'image' => 'technology.jpg'],
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'image' => 'entertainment.jpg'],
            ['name' => 'Health', 'slug' => 'health', 'image' => 'health.jpg'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
