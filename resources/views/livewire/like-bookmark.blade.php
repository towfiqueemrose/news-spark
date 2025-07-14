<div class="flex items-center space-x-4">
    <!-- Like Button -->
    <button wire:click="toggleLike" class="flex items-center space-x-1 {{ $isLiked ? 'text-red-500 dark:text-red-400' : 'text-gray-500 dark:text-gray-400' }} hover:text-red-500 dark:hover:text-red-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ $isLiked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        <span>{{ $likesCount }}</span>
    </button>
    
    <!-- Bookmark Button -->
    <button wire:click="toggleBookmark" class="flex items-center space-x-1 {{ $isBookmarked ? 'text-blue-500 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }} hover:text-blue-500 dark:hover:text-blue-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
        </svg>
    </button>
</div>