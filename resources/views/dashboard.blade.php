<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 rounded mb-6" role="alert">
                <div class="p-6 text-green-700">
                    {{ session('success') }}
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 rounded mb-6" role="alert">
                <div class="p-6 text-gray-900">
                    <ul class="list-disc list-inside text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- Form Upload Image -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Upload Image:</label>
                            <input type="file" name="images[]" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required multiple>
                        </div>
                        <div class="mb-4">
                            <label for="caption" class="block text-gray-700 text-sm font-bold mb-2">Caption:</label>
                            <textarea name="caption" id="caption" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        </div>
                        <div class="mb-4">
                            <input type="hidden" name="is_public" value="0">
                            <input type="checkbox" name="is_public" id="is_public" value="1" class="mr-2 leading-tight">
                            <label for="is_public" class="text-gray-700 text-sm font-bold">Make Post Public</label>
                        </div>
                        <div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Form Upload Image -->

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-6">
                @foreach ($posts as $post)
                    <div class="rounded overflow-hidden shadow-sm bg-white">
                        <a href="#" class="block group">
                            <div class="relative" style="padding-top:100%;"> {{-- square container --}}
                                {{-- public / private badge --}}
                                <div class="absolute top-2 right-2 bg-white bg-opacity-80 text-xs rounded-full px-2 py-1 flex items-center space-x-1 shadow z-50">
                                    @if ($post->is_public)
                                        <span title="Public" class="text-green-600">🌐</span>
                                        <span class="sr-only">Public</span>
                                    @else
                                        <span title="Private" class="text-gray-600">🔒</span>
                                        <span class="sr-only">Private</span>
                                    @endif
                                </div>

                                @if ($post->media->first())
                                    <img src="{{ asset('storage/' . $post->media->first()->path) }}"
                                         alt="Post image"
                                         class="absolute inset-0 w-full h-full object-cover" />
                                @else
                                    <div class="absolute inset-0 bg-gray-100 flex items-center justify-center text-gray-400">
                                        No image
                                    </div>
                                @endif

                                {{-- overlay with caption on hover --}}
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition duration-200 flex items-end">
                                    <div class="w-full p-3 opacity-0 group-hover:opacity-100 transition duration-200 text-white">
                                        <p class="text-sm leading-tight line-clamp-2">
                                            {{ $post->caption }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <div class="px-3 py-2 flex items-center justify-between text-sm text-gray-600">
                            <div>{{ $post->created_at->diffForHumans() }}</div>
                            <div class="flex items-center space-x-3 text-gray-500">
                                <span title="likes">❤</span>
                                <span title="comments">💬</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
