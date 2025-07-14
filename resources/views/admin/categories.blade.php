@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Manage Categories</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Create Category Form -->
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 mb-8">
        @csrf
        <div>
            <label class="block mb-1">Category Name</label>
            <input type="text" name="name" required class="w-full border px-3 py-2">
        </div>
        <div>
            <label class="block mb-1">Category Image</label>
            <input type="file" name="image" required class="w-full">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Add Category
        </button>
    </form>

    <!-- Category List -->
    <div class="bg-white rounded shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-100 dark:bg-gray-700 text-left">
                <tr>
                    <th class="p-2 dark:text-gray-300">Name</th>
                    <th class="p-2 dark:text-gray-300">Image</th>
                    <th class="p-2 dark:text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="dark:bg-[#1f2937]">
                @foreach($categories as $category)
                    <tr class="border-b">
                        <td class="p-2">{{ $category->name }}</td>
                        <td class="p-2">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="Image" class="h-10">
                        </td>
                        <td class="p-2">
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if($categories->isEmpty())
                    <tr>
                        <td colspan="3" class="p-2 text-gray-500">No categories yet.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
