<!-- resources/views/components/home/bangladesh-news.blade.php -->
<div class="mt-8 max-w-7xl mx-auto border-y-4 p-8">
    <h2 class="text-2xl font-bold pb-2 mb-4 text-red-700">Bangladesh</h2>
    <div class="grid grid-cols-3 gap-6">

        <!-- Left Column -->
        <div class="space-y-6">
            @foreach ($bangladeshNews->take(3) as $news)
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-[140px] h-[90px] bg-gray-200 overflow-hidden rounded">
                        <img src="{{ asset($news->image) }}" alt="" class="object-cover w-full h-full">
                    </div>                    
                    <div>
                        <a href="{{ route('news.show', $news->slug) }}" class="font-semibold hover:underline">
                            {{ Str::limit($news->title, 60) }}
                        </a>
                        <div class="text-sm text-gray-500">{{ $news->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Middle Column (Featured) -->
        @php $featured = $bangladeshNews->get(3); @endphp
        @if ($featured)
            <div class="col-span-1">
                <a href="{{ route('news.show', $featured->slug) }}">
                    <div class="relative">
                        <img src="{{ asset($featured->image) }}" alt="{{ $featured->title }}" class="w-full h-56 object-cover rounded">
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    </div>
                    <h3 class="mt-3 text-xl font-bold text-red-600">
                        INMA Global Media Awards 2025
                    </h3>
                    <p class="text-lg font-semibold">
                        {{ Str::limit($featured->title, 60) }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">From the stage came the announcement: First prize goes to Prothom Alo of Bangladesh.</p>
                    <div class="text-xs text-gray-400 mt-1">{{ $featured->created_at->diffForHumans() }}</div>
                </a>
            </div>
        @endif

        <!-- Right Column -->
        <div class="space-y-6">
            @foreach ($bangladeshNews->slice(4) as $news)
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-[140px] h-[90px] bg-gray-200 overflow-hidden rounded">
                        <img src="{{ asset($news->image) }}" alt="" class="object-cover w-full h-full">
                    </div>                    
                    <div>
                        <a href="{{ route('news.show', $news->slug) }}" class="font-semibold hover:underline">
                            {{ Str::limit($news->title, 60) }}
                        </a>
                        <div class="text-sm text-gray-500">{{ $news->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
