<!-- resources/views/livewire/search-news.blade.php -->
<div>
    <div class="relative">
        <input 
            type="text" 
            wire:model.live="query" 
            placeholder="Search for news..." 
            class="w-full px-4 py-3 rounded-full border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white"
        >
        
        @if(!empty($query))
            <div class="absolute z-[60] w-full mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 max-h-60 overflow-y-auto">
                @if(count($results) > 0)
                    @foreach($results as $result)
                        <a 
                            href="{{ route('news.show', $result->slug) }}" 
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-800 dark:text-white border-b border-gray-100 dark:border-gray-700 last:border-b-0"
                        >
                            {{ $result->title }}
                        </a>
                    @endforeach
                @else
                    <div class="px-4 py-2 text-gray-500 dark:text-gray-400">No results found</div>
                @endif
            </div>
        @endif
    </div>
</div>