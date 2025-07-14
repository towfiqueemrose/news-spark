@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Your Bookmarks</h1>

    @forelse ($bookmarks as $bookmark)
        <div class="border-b py-4">
            <h3 class="font-bold">{{ $bookmark->news->title }}</h3>
            <form action="/bookmarks/{{ $bookmark->id }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-500 text-sm">Remove</button>
            </form>
        </div>
    @empty
        <p>No bookmarks yet.</p>
    @endforelse

    {{ $bookmarks->links() }}
</div>
@endsection