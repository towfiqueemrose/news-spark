<div class="container max-w-7xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6">Reader's Choice</h2>
    
    @foreach($mostLikedNews as $index => $news)
    <div class="mb-12">
        <div class="flex flex-col md:flex-row items-center gap-6 {{ $loop->index % 2 == 0 ? '' : 'md:flex-row-reverse' }}">
            <!-- Image Section -->
            <div class="w-full md:w-1/2">
                <img src="{{ $news->image ? asset($news->image) : asset('images/default-news.jpg') }}" 
                alt="{{ $news->title }}" 
                class="w-full h-64 md:h-80 object-cover rounded-lg shadow-md">                     
            </div>
            
            <!-- Content Section -->
            <div class="w-full md:w-1/2">
                <h3 class="font-bold text-xl md:text-2xl mb-3">{{ $news->title }}</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">{!! Str::limit(strip_tags($news->body, '<strong><a>'), 150) !!}</p>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm dark:text-gray-300 text-gray-500">
                        {{ $news->category->name }} • 
                        {{ $news->created_at->diffForHumans() }}
                    </span>
                    <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                        {{ $news->likes_count }} likes
                    </span>
                </div>
                
                <a href="{{ route('news.show', $news->slug) }}" 
                   class="mt-4 inline-block text-blue-600 hover:text-blue-800 font-medium">
                    Details →
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>