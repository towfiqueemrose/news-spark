<!-- resources/views/categories/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Main Content -->
        <div class="md:w-2/3">
            <!-- Category Header -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $category->name }}</h1>
                    <span class="ml-4 px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-sm font-semibold rounded-full">
                        {{ $news->count() }} {{ Str::plural('article', $news->count()) }}
                    </span>
                </div>
                @if($category->description)
                    <p class="text-gray-600 dark:text-gray-300">{{ $category->description }}</p>
                @endif
            </div>

            <!-- Popular News in this Category -->
            @if($popularNews->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Popular in {{ $category->name }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($popularNews as $newsItem)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <a href="{{ route('news.show', $newsItem->slug) }}">
                                    <img src="{{ asset( $newsItem->image) }}" alt="{{ $newsItem->title }}" class="w-full h-48 object-cover">
                                    <div class="p-4">
                                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">{{ $newsItem->title }}</h3>
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <span>{{ $newsItem->created_at->diffForHumans() }}</span>
                                            <span class="mx-2">•</span>
                                            <span>{{ $newsItem->view_count }} views</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- All News in this Category -->
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Latest Articles</h2>
            <div class="space-y-6">
                @foreach($news as $newsItem)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="md:flex">
                            <div class="md:w-1/3">
                                <a href="{{ route('news.show', $newsItem->slug) }}">
                                    <img src="{{ asset('storage/' . $newsItem->image) }}" alt="{{ $newsItem->title }}" class="w-full h-full object-cover min-h-48">
                                </a>
                            </div>
                            <div class="p-6 md:w-2/3">
                                <div class="flex items-center mb-2">
                                    <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">{{ $newsItem->created_at->diffForHumans() }}</span>
                                    <span class="mx-2 text-gray-400">•</span>
                                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">{{ $newsItem->view_count }} views</span>
                                </div>
                                <a href="{{ route('news.show', $newsItem->slug) }}">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 hover:text-blue-600 dark:hover:text-blue-400">{{ $newsItem->title }}</h3>
                                </a>
                                <p class="text-gray-600 dark:text-gray-300 mb-4">{{ Str::limit(strip_tags($newsItem->body), 200) }}</p>
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . $newsItem->user->image) }}" alt="{{ $newsItem->user->name }}" class="w-8 h-8 rounded-full mr-2 object-cover">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $newsItem->user->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Sidebar -->
        <div class="md:w-1/3">
            <!-- Categories Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Categories</h3>
                <ul class="space-y-2">
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('categories.show', $cat->slug) }}" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 {{ $category->id === $cat->id ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                <span class="text-gray-700 dark:text-gray-300">{{ $cat->name }}</span>
                                <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full">
                                    {{ $cat->news_count }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Popular News Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Most Popular</h3>
                <div class="space-y-4">
                    @foreach($popularNews as $newsItem)
                        <div class="flex items-start space-x-3">
                            <a href="{{ route('news.show', $newsItem->slug) }}" class="shrink-0">
                                <img src="{{ asset($newsItem->image) }}" alt="{{ $newsItem->title }}" class="w-16 h-16 rounded object-cover">
                            </a>
                            <div>
                                <a href="{{ route('news.show', $newsItem->slug) }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">{{ Str::limit($newsItem->title, 50) }}</a>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $newsItem->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
