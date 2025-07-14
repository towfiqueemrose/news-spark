@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4 max-w-6xl">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Sidebar - User Details -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white dark:bg-[#1f2937] rounded-lg shadow-md overflow-hidden">
                    <!-- User Profile Card -->
                    <div class="bg-[#15119c] py-4 px-6 text-white">
                        <h2 class="text-xl font-bold">Profile Information</h2>
                    </div>

                    <div class="p-6">
                        <div class="text-center">
                            <img src="{{ asset(auth()->user()->image ? 'storage/' . auth()->user()->image : 'images/default-avatar.png') }}"
                                alt="Profile Image"
                                class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-blue-100">
                            <h3 class="text-lg font-semibold">{{ auth()->user()->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</p>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Role:</span>
                                <span class="capitalize ml-2 px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    {{ auth()->user()->role }}
                                </span>
                            </div>

                            <div>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Account Created:</span>
                                <span>{{ auth()->user()->created_at->format('d M, Y') }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 space-y-3">
                            <button onclick="openEditModal()"
                                class="w-full  bg-[#15119c] hover:bg-[#191757] focus:ring-[#453fff] text-white py-2 rounded  transition">
                                Edit Profile
                            </button>

                            <button onclick="openDeleteModal()"
                                class="w-full bg-red-100 text-red-800 py-2 rounded hover:bg-red-200 transition">
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Bookmarks -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white dark:bg-[#1f2937] rounded-lg shadow-md overflow-hidden">
                    <div class="bg-[#15119c] py-4 px-6 text-white">
                        <h2 class="text-xl font-bold">Your Bookmarks</h2>
                    </div>

                    <div class="p-6">
                        @if ($bookmarks->count() > 0)
                            <div class="space-y-4">
                                @foreach ($bookmarks as $bookmark)
                                    <div class="border-b pb-4 flex justify-between items-start">
                                        <div>
                                            <a href="{{ route('news.show', $bookmark->news->slug) }}"
                                                class="text-decoration-none">
                                                <h3 class="font-medium">{{ $bookmark->news->title }}</h3>
                                            </a>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $bookmark->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <form action="{{ route('bookmarks.destroy', $bookmark->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                {{ $bookmarks->links() }}
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                                <p class="mt-2">You have no bookmarks</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editModal" class="flex fixed inset-0 bg-black bg-opacity-50 items-center justify-center hidden">
        <div class="bg-white rounded-lg w-full max-w-md mx-4">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-bold dark:text-gray-700">Edit Profile</h3>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="editProfileForm" action="{{ route('profile.edit') }}" method="POST" enctype="multipart/form-data"
                class="p-6">
                @csrf @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" name="name" value="{{ auth()->user()->name }}"
                            class="mt-1 block w-full dark:text-gray-600 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                        <input type="file" id="image" name="image"
                            class="mt-1 block w-full border border-gray-300 dark:text-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                            class="mt-1 block w-full border dark:text-gray-600 border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password
                            (optional)</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                            Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center hidden">
        <div class="bg-white rounded-lg w-full max-w-md mx-4">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-bold">Delete Account</h3>
                <button onclick="closeDeleteModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('profile.destroy') }}" method="POST" class="p-6">
                @csrf @method('DELETE')

                <p class="text-gray-700 mb-4">Are you sure you want to delete your account? This action cannot be undone.
                </p>

                <div>
                    <label for="delete_password" class="block text-sm font-medium text-gray-700">Enter your password to
                        confirm</label>
                    <input type="password" id="delete_password" name="password" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        window.onclick = function(event) {
            if (event.target.id === 'editModal') {
                closeEditModal();
            }
            if (event.target.id === 'deleteModal') {
                closeDeleteModal();
            }
        }
    </script>
@endsection
