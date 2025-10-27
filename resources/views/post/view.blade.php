{{-- filepath: /home/kirom/project/laravel/InstaApp/resources/views/post/view.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Post Header -->
                    <div class="flex items-center mb-4">
                        <div class="h-10 w-10 rounded-full bg-gray-200 overflow-hidden">
                            <img src="{{ $post->user->avatar ?? asset('images/default-avatar.png') }}" alt="Profile" class="h-full w-full object-cover">
                        </div>
                        <div class="ml-4">
                            <a href="{{ route('user.posts', $post->user->id) }}" class="font-semibold text-gray-900 hover:underline">
                                {{ $post->user->name }}
                            </a>
                            <p class="text-sm text-gray-500">{{ $post->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="flex flex-col md:flex-row md:space-x-6">
                        <!-- Image Section -->
                        <div class="md:w-2/3">
                            <div class="relative rounded-lg overflow-hidden shadow-lg">
                                <img src="{{ asset('storage/' . $post->media->first()->path) }}" 
                                     alt="Post Image" 
                                     class="w-full object-cover">
                            </div>
                        </div>

                        <!-- Interaction Section -->
                        <div class="md:w-1/3 mt-4 md:mt-0">
                            <!-- Caption -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <p class="text-gray-800 text-lg">{{ $post->caption }}</p>
                            </div>

                            <!-- Like Section -->
                            <div class="border-b border-gray-100 pb-4 mb-4">
                                @auth
                                <form action="{{ route('posts.like', $post->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center space-x-2 text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ $post->likes->contains('user_id', auth()->id()) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        <span>{{ $post->likes->count() }} {{ Str::plural('Like', $post->likes->count()) }}</span>
                                    </button>
                                </form>
                                @else
                                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Log in to like this post</a>
                                @endauth
                            </div>

                            <!-- Comments Section -->
                            <div class="space-y-4">
                                <h3 class="font-semibold text-gray-900">Comments</h3>
                                
                                @auth
                                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-4">
                                    @csrf
                                    <div class="flex space-x-2">
                                        <input type="text" name="content" 
                                               class="flex-1 rounded-full border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                               placeholder="Add a comment...">
                                        <button type="submit" class="bg-blue-500 text-white rounded-full px-4 py-2 text-sm hover:bg-blue-600 transition duration-200">
                                            Post
                                        </button>
                                    </div>
                                </form>
                                @endauth

                                <div class="max-h-96 overflow-y-auto space-y-4">
                                    @forelse ($post->comments as $comment)
                                    <div class="flex space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 overflow-hidden">
                                            <img src="{{ $comment->user->avatar ?? asset('images/default-avatar.png') }}" 
                                                 alt="Profile" 
                                                 class="h-full w-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <div class="bg-gray-50 rounded-lg p-3">
                                                <a href="{{ route('user.posts', $comment->user->id) }}" 
                                                   class="font-semibold text-sm text-gray-900 hover:underline">
                                                    {{ $comment->user->name }}
                                                </a>
                                                <p class="text-gray-700">{{ $comment->body }}</p>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    @empty
                                    <p class="text-gray-500 text-center py-4">No comments yet. Be the first to comment!</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="px-6 py-3 bg-gray-50 border-t">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center text-blue-500 hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>