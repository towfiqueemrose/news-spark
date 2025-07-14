@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Create News</h1>
   
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
    
    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
       
        <input
            type="text"
            name="title"
            placeholder="Title"
            value="{{ old('title') }}"
            class="w-full border px-3 py-2 dark:bg-gray-800 dark:text-white rounded"
            required>
            
        <input
            type="text"
            name="slug"
            placeholder="Slug"
            value="{{ old('slug') }}"
            class="w-full border px-3 py-2 dark:bg-gray-800 dark:text-white rounded"
            required>
            
        <textarea
            name="body"
            placeholder="Body"
            class="w-full border px-3 py-2 dark:bg-gray-800 dark:text-white rounded"
            rows="5"
            required>{{ old('body') }}</textarea>
            
        {{-- Image --}}
        <div>
            <label class="block mb-1 text-gray-700 dark:text-gray-300">Image</label>
            <input
                type="file"
                name="image"
                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                class="w-full border px-3 py-2 rounded"
                required>
            <small class="text-gray-500">Supported formats: JPEG, PNG, JPG, GIF, WebP (Max: 2MB)</small>
        </div>
        
        {{-- Video --}}
        <div>
            <label class="block mb-1 text-gray-700 dark:text-gray-300">Video (Optional)</label>
            <input
                type="file"
                name="video"
                accept="video/mp4,video/quicktime,video/x-msvideo,video/x-flv,video/x-matroska"
                class="w-full border px-3 py-2 rounded">
            <small class="text-gray-500">Optional formats: MP4, MOV, AVI, FLV, MKV (Max: 100MB)</small>
        </div>
        
        {{-- Category --}}
        <select name="category_id" class="w-full border px-3 py-2 dark:bg-gray-800 dark:text-white rounded" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        
        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Publish
        </button>
    </form>
</div>

<script>
// Auto generate slug from title
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