<div>
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Comment ({{ $news->comments->count() }})</h3>

    @auth
        <form wire:submit.prevent="postComment" class="mb-8">
            <textarea wire:model.defer="body" rows="3"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white"
                placeholder="{{ $parentId ? 'Replying...' : 'Write your comment...' }}"></textarea>
            @error('body')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <div class="mt-2 flex space-x-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    {{ $parentId ? 'Reply' : 'Comment' }}
                </button>
                @if ($parentId)
                    <button type="button" wire:click="cancelReply"
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                @endif
            </div>
        </form>
    @else
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 rounded text-blue-800 dark:text-blue-200">
            Please <a href="{{ route('login') }}" class="font-medium hover:underline">Login</a> to comment
        </div>
    @endauth

    <div class="space-y-6">
        @foreach ($news->comments->where('parent_id', null) as $comment)
            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                <div class="flex items-start space-x-4">
                    <img src="{{ asset('storage/' . $comment->user->image) }}"
                        class="w-10 h-10 rounded-full object-cover">
                    <div class="flex-1">
                        <div class="flex justify-between mb-1">
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</h4>
                                <span
                                    class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            @if (Auth::check() && (Auth::id() === $comment->user_id || Auth::user()->isAdmin()))
                                <button wire:click="deleteComment({{ $comment->id }})"
                                    class="text-red-500 text-sm hover:underline">Delete</button>
                            @endif
                        </div>
                        <p class="text-gray-700 dark:text-gray-300">{{ $comment->body }}</p>

                        @auth
                            <button wire:click="setReply({{ $comment->id }})"
                                class="mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">Reply</button>
                        @endauth

                        @foreach ($comment->replies as $reply)
                            <div class="mt-4 pl-6 border-l-2 border-gray-200 dark:border-gray-700">
                                <div class="flex items-start space-x-3">
                                    <img src="{{ asset('storage/' . $reply->user->image) }}"
                                        class="w-8 h-8 rounded-full object-cover">
                                    <div class="flex-1">
                                        <div class="flex justify-between mb-1">
                                            <div>
                                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                    {{ $reply->user->name }}</h4>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            @if (Auth::check() && (Auth::id() === $reply->user_id || Auth::user()->isAdmin()))
                                                <button wire:click="deleteComment({{ $reply->id }})"
                                                    class="text-red-500 text-xs hover:underline">Delete</button>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $reply->body }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
