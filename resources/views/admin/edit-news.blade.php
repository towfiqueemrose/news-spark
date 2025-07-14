@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Edit News</h1>
   
    {{-- Error Messages --}}
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
       
        <input
            type="text"
            name="title"
            placeholder="Title"
            value="{{ old('title', $news->title) }}"
            class="w-full border px-3 py-2 dark:bg-[#2e353f] dark:text-gray-300 rounded"
            required>
            
        <input
            type="text"
            name="slug"
            placeholder="Slug"
            value="{{ old('slug', $news->slug) }}"
            class="w-full border px-3 py-2 dark:bg-[#2e353f] dark:text-gray-300 rounded"
            required>
            
        <textarea
            name="body"
            placeholder="Body"
            class="w-full border px-3 py-2 dark:bg-[#2e353f] dark:text-gray-300 rounded"
            rows="5"
            required>{{ old('body', $news->body) }}</textarea>
            
        {{-- Image Upload --}}
        <div>
            <label class="block mb-1 text-gray-700 dark:text-gray-300">Image</label>
            {{-- Current Image --}}
            @if($news->image)
                <div class="mb-2">
                    <img src="{{ $news->image }}" alt="Current Image" class="w-20 h-20 object-cover rounded">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Current Image</p>
                </div>
            @endif
           
            <input
                type="file"
                name="image"
                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                class="w-full border px-3 py-2 rounded">
            <small class="text-gray-500">Leave empty to keep current image. Supported formats: JPEG, PNG, JPG, GIF, WebP (Max: 2MB)</small>
        </div>
        
        {{-- Video Upload --}}
        <div>
            <label class="block mb-1 text-gray-700 dark:text-gray-300">Video (Optional)</label>
            {{-- Current Video --}}
            @if($news->video)
                <div class="mb-2">
                    <video controls class="w-full max-w-xs h-32 rounded">
                        <source src="{{ $news->video }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Current Video</p>
                </div>
            @endif
           
            <input
                type="file"
                name="video"
                accept="video/mp4,video/quicktime,video/x-msvideo,video/x-flv,video/x-matroska"
                class="w-full border px-3 py-2 rounded">
            <small class="text-gray-500">Leave empty to keep current video. Supported formats: MP4, MOV, AVI, FLV, MKV (Max: 100MB)</small>
        </div>
        
        {{-- Category --}}
        <select name="category_id" class="w-full border px-3 py-2 dark:bg-[#2e353f] dark:text-gray-300 rounded" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        
        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
// Auto generate slug from title (optional for edit)
document.querySelector('input[name="title"]').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase()
        .replace(/[^\w\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single
        .trim('-'); // Remove leading/trailing hyphens
   
    document.querySelector('input[name="slug"]').value = slug;
});
</script>
@endsection