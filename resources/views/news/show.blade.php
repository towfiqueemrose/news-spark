<!-- resources/views/news/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container max-w-6xl mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('categories.show', $news->category->slug) }}"
                            class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ $news->category->name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span
                            class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ Str::limit($news->title, 30) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- News Content -->
        <article class="mb-8">
            <!-- Featured Media (Image or Video) -->
            @if ($news->video)
                <div class="relative pt-[56.25%] bg-black rounded-lg overflow-hidden mb-6">
                    <video controls class="absolute top-0 left-0 w-full h-full"
                        poster="{{ $news->image ? asset($news->image) : '' }}">
                        <source src="{{ asset($news->video) }}" type="video/mp4">
                        Your browser does not support the video.
                    </video>
                </div>
            @elseif($news->image)
                <div class="flex justify-center items-center bg-transparent p-4 mb-6">
                    <img src="{{ asset($news->image) }}" alt="{{ $news->title }}"
                        class="w-full max-w-2xl h-auto max-h-[400px] object-cover rounded-lg shadow-sm">
                </div>
            @endif

            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden ">
                <!-- Category and Date -->
                <div class="flex items-center justify-between mb-4">
                    <span
                        class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold rounded-full">
                        {{ $news->category->name }}
                    </span>
                    <span class="text-sm text-gray-600 dark:text-gray-300">
                        {{ $news->created_at->format('F j, Y') }} • {{ $news->created_at->diffForHumans() }}
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $news->title }}</h1>

                <!-- Author and Stats -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <img src="{{ asset('storage/' . $news->user->image) }}" alt="{{ $news->user->name }}"
                            class="w-10 h-10 rounded-full mr-3 object-cover">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $news->user->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $news->user->email }}</p>
                        </div>
                    </div>

                    <!-- Livewire Like and Bookmark Component -->
                    @livewire('like-bookmark', ['news' => $news])
                </div>

                <!-- News Body -->
                <div class="prose max-w-none dark:prose-invert">
                    {!! $news->body !!}
                </div>
            </div>
        </article>

        <!-- Social Sharing -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Share this news on</h3>
            <div class="flex space-x-4">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"
                    class="text-blue-600 hover:text-blue-800">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($news->title) }}"
                    target="_blank" class="text-blue-400 hover:text-blue-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                        </path>
                    </svg>
                </a>
                <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . url()->current()) }}" target="_blank"
                    class="text-green-500 hover:text-green-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-6.29 3.01c1.175-.354 2.134-1.162 2.39-1.363l-.367-.227c-.409-.246-.98-.583-1.286-.764-.272-.15-.47-.223-.67.074-.198.298-.767.966-.94 1.165-.173.198-.347.223-.644.074-.297-.15-1.255-.462-2.39-1.474-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.133-.133.297-.347.446-.521.148-.173.198-.297.297-.496.1-.198.05-.372-.024-.52-.075-.15-.669-1.613-.917-2.207-.242-.579-.486-.5-.668-.51-.173-.008-.372-.01-.57-.01-.2 0-.52.075-.793.373-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.06.027.117.05.175.075l-.158.096c-.083.041-.17.078-.257.11-1.34.453-3.095.705-3.912-.028-.222-.197-1.17-1.074-1.599-1.927-.086-.17.086-.321.297-.321.075 0 .151.018.223.038.506.166 1.136.393 1.33.446.198.05.347.025.446-.075.099-.099.397-.372.545-.52.149-.149.223-.124.397-.074.174.05 1.102.525 1.293.619.19.095.322.143.372.223.05.08.034.173-.016.273-.05.099-.545 1.29-.744 1.756-.198.46-.396.387-.545.322-.148-.064-1.262-.465-1.677-.619-.413-.154-.712-.232-.793-.372-.083-.136-.083-.248-.05-.347.033-.099.174-.16.322-.248.843-.495 1.84-1.237 1.84-1.237s-.198-.149-.545-.397c-.347-.248-.669-.545-.744-.644-.074-.099-.05-.186.025-.285.075-.099.396-.545.545-.744.149-.198.198-.347.297-.545.099-.199.05-.372-.025-.521-.075-.148-.669-1.612-.916-2.206-.242-.579-.487-.501-.669-.511-.173-.008-.371-.01-.57-.01v.001z">
                        </path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
            @livewire('comment-section', ['news' => $news])
        </div>

        <!-- Related News -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Related News</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($relatedNews as $related)
                    <div
                        class="bg-white dark:bg-gray-700 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                        <a href="{{ route('news.show', $related->slug) }}">
                            <img src="{{ asset($related->image) }}" alt="{{ $related->title }}"
                                class="w-full h-40 object-cover">
                            <div class="p-4">
                                <span
                                    class="inline-block px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold rounded-full mb-2">{{ $related->category->name }}</span>
                                <h3 class="text-md font-bold text-gray-800 dark:text-white mb-2">
                                    {{ Str::limit($related->title, 50) }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 text-xs">
                                    {{ $related->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
