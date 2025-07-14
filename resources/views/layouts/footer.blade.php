<!-- resources/views/layouts/footer.blade.php -->
<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">News Portal</h3>
                <p class="text-gray-400">Bringing you the latest news from around the world.</p>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">Categories</h4>
                <ul class="space-y-2">
                    {{-- @foreach(\App\Models\Category::take(5)->get() as $category)
                        <li><a href="{{ route('categories.show', $category->slug) }}" class="text-gray-400 hover:text-white">{{ $category->name }}</a></li>
                    @endforeach --}}
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Home</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">About Us</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">Subscribe</h4>
                <p class="text-gray-400 mb-4">Get the latest news delivered to your inbox.</p>
                <form class="flex">
                    <input type="email" placeholder="Your email" class="px-4 py-2 rounded-l text-gray-800 w-full">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-r">Subscribe</button>
                </form>
            </div>
        </div>
        
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} News Portal. All rights reserved.</p>
        </div>
    </div>
</footer>