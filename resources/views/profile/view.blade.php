<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- User Avatar -->
                <div class="h-16 w-16 rounded-full bg-gray-200 overflow-hidden border-2 border-gray-300">
                    <img src="{{ $user->avatar ?? asset('images/default-avatar.png') }}" 
                         alt="{{ $user->name }}'s avatar"
                         class="h-full w-full object-cover">
                </div>
                <!-- User Info -->
                <div>
                    <h2 class="font-semibold text-xl text-gray-800">@ {{ $user->name }}</h2>
                </div>
            </div>
            <!-- Stats -->
            <div class="hidden sm:flex space-x-8 text-center">
                <div>
                    <span class="block font-bold text-xl">{{ $posts->count() }}</span>
                    <span class="text-gray-600">Posts</span>
                </div>
                <div>
                    <span class="block font-bold text-xl">{{ $user->followers_count ?? 0 }}</span>
                    <span class="text-gray-600">Followers</span>
                </div>
                <div>
                    <span class="block font-bold text-xl">{{ $user->following_count ?? 0 }}</span>
                    <span class="text-gray-600">Following</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <!-- New Post Form -->
            @if ($user && $user->id == auth()->id())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Create New Post</h3>
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
                          class="space-y-6">
                        @csrf
                        <!-- Image Upload -->
                        <div class="space-y-2">
                            <label for="image" class="block text-gray-700 font-medium">Upload Images</label>
                            <div class="relative">
                                <input type="file" name="images[]" id="image" multiple
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                              file:rounded-full file:border-0 file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                       required>
                            </div>
                            <p class="text-sm text-gray-500">You can select multiple images</p>
                        </div>

                        <!-- Caption -->
                        <div class="space-y-2">
                            <label for="caption" class="block text-gray-700 font-medium">Caption</label>
                            <textarea name="caption" id="caption" rows="3"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                      placeholder="Write a caption..."></textarea>
                        </div>

                        <!-- Privacy Toggle -->
                        <div class="flex items-center space-x-3">
                            <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                <input type="hidden" name="is_public" value="0">
                                <input type="checkbox" name="is_public" id="is_public" value="1"
                                       class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <label for="is_public"
                                       class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                            </div>
                            <span class="text-gray-700 font-medium">Make Post Public</span>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Share Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Posts Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse ($posts as $post)
                    <x-cart-post :post="$post"/>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No posts yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new post.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- CSS for toggle switch -->
    <style>
        .toggle-checkbox:checked {
            @apply: right-0 border-blue-600;
            right: 0;
            border-color: #2563eb;
        }
        .toggle-checkbox:checked + .toggle-label {
            @apply: bg-blue-600;
            background-color: #2563eb;
        }
    </style>
</x-app-layout>
