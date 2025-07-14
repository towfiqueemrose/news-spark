@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        <div class="space-x-2">
            <a href="{{ route('admin.news.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
               + Create News
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
               + Manage Categories
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-[#2e353f] shadow-md rounded p-4">
        <table class="w-full table-auto">
            <thead >
                <tr class="bg-gray-200 dark:bg-[#ffffff] text-left">
                    <th class="p-2 dark:text-gray-600">Title</th>
                    <th class="p-2 dark:text-gray-600">Category</th>
                    <th class="p-2 dark:text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($newsList as $news)
                    <tr class="border-b">
                        <td class="p-2">
                            <a href="{{ route('news.show', $news->slug) }}" class="text-gray-700 dark:text-gray-300">
                                {{ $news->title }}
                            </a>
                        </td>
                        <td class="p-2">{{ $news->category->name }}</td>
                        <td class="p-2 space-x-2">
                            <a href="{{ route('admin.news.edit', $news->id) }}"
                               class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this news?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-2 text-gray-500">No news found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
