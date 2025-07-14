<!-- resources/views/home.blade.php -->
@extends('layouts.app')


@section('content')
    <!-- Hero Section -->


    <div class="bg-gray-100 dark:bg-gray-900 py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-center text-gray-800 dark:text-white mb-8">Latest News Updates</h1>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto mb-8">
                <livewire:search-news />
            </div>
        </div>
    </div>

    <!-- Horizontal Categories Navigation -->
    <div class="shadow-md max-w-7xl mx-auto sticky backdrop-blur-sm top-0 z-50 ">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Categories:</h3>
                <div class="flex-1 ml-6">
                    <div class="flex space-x-1 overflow-x-auto scrollbar-hide">
                        @foreach ($categories as $category)
                            <a href="{{ route('categories.show', $category->slug) }}"
                                class="whitespace-nowrap px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 flex-shrink-0">
                                {{ $category->name }}
                                <span
                                    class="ml-2 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold px-2 py-1 rounded-full">
                                    {{ $category->news_count ?? $category->news->count() }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container max-w-7xl mx-auto p-4 grid grid-cols-1 md:grid-cols-4 gap-0 overflow-hidden">
        <!-- Left Sidebar: Video News Section -->
        <div class="hidden md:block space-y-6 border-r p-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Watch Videos</h2>

            @foreach (\App\Models\News::whereNotNull('video')->latest()->take(4)->get() as $news)
                <a href="{{ route('news.show', $news->slug) }}" class="block group space-y-2">
                    <div class="relative">
                        <img src="{{ asset($news->image) }}" alt="{{ $news->title }}"
                            class="w-full h-40 object-cover rounded-md group-hover:opacity-90 transition duration-300">
                        <!-- Video Icon Overlay -->
                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-12 w-12 text-white group-hover:scale-110 transition duration-300"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-md font-semibold text-gray-800 dark:text-white group-hover:text-blue-600 transition">
                        {{ Str::limit($news->title, 50) }}
                    </h3>
                </a>
            @endforeach
        </div>


        <!-- Middle Content: News List (2 columns span) -->
        <div class="md:col-span-2 border-r pt-6 border-x px-4 space-y-1">
            @foreach ($topNews as $news)
                <div class="border-gray-300 dark:border-gray-700 pb-4">
                    <a href="{{ route('news.show', $news->slug) }}"
                        class="block group overflow-hidden shadow hover:shadow-lg transition bg-white dark:bg-gray-800 rounded-md">
                        <img src="{{ asset($news->image) }}" alt="{{ $news->title }}"
                            class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="p-6">
                            <h2
                                class="text-2xl font-extrabold text-gray-900 dark:text-white leading-tight group-hover:text-blue-600">
                                {{ $news->title }}
                            </h2>
                            <div class="mt-2 text-gray-600 prose dark:prose-invert dark:text-gray-400">
                                {!! Str::limit(strip_tags($news->body, '<strong><a>'), 150) !!}
                            </div>
                            <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                                {{ $news->created_at->diffForHumans() }} | {{ $news->category->name }}
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Right Sidebar: Latest News -->
        <div class="space-y-6 p-4">
            <h2
                class="text-xl font-bold text-gray-900 dark:bg-transparent mb-2  dark:text-blue-600">
                Latest News</h2>
                @foreach ($latestNews as $news)
                    <a href="{{ route('news.show', $news->slug) }}"
                        class="block group border-b pb-4 hover:text-blue-600 transition">
                        <h3 class="font-semibold text-md text-gray-700 dark:text-white group-hover:text-blue-600">
                            {{ $news->title }}
                        </h3>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            {{ $news->created_at->diffForHumans() }} | {{ $news->category->name }}
                        </p>
                    </a>
                @endforeach
        </div>
    </div>
    <x-home.bangladesh-news :bangladesh-news="$bangladeshNews" />
    <x-home.most-liked :mostLikedNews="$mostLikedNews" />
@endsection
