@props(['post'])

<div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
    <a href="{{ route('posts.view', $post->id) }}" class="block group">
        <div class="relative" style="padding-top:100%;"> {{-- square container --}}
            {{-- Status Badge --}}
            <div class="absolute top-3 right-3 backdrop-blur-md bg-white/70 rounded-full px-3 py-1.5 flex items-center space-x-1.5 shadow-sm z-50 transition-transform duration-300 transform hover:scale-105">
                @if ($post->is_public)
                    <span title="Public" class="text-green-600 text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                        <span class="ml-1">Public</span>
                    </span>
                @else
                    <span title="Private" class="text-gray-700 text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="ml-1">Private</span>
                    </span>
                @endif
            </div>

            {{-- Post Image --}}
            <div class="absolute inset-0 bg-gray-100">
                @if ($post->media->first())
                    <img src="{{ asset('storage/' . $post->media->first()->path) }}"
                         alt="Post by {{ $post->user->name }}"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Hover Overlay with Caption --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="absolute bottom-0 w-full p-4">
                    <p class="text-white text-sm font-medium leading-snug line-clamp-3">
                        {{ $post->caption }}
                    </p>
                </div>
            </div>
        </div>
    </a>

    {{-- Post Footer --}}
    <div class="px-4 py-3 flex items-center justify-between border-t border-gray-100">
        <div class="text-sm text-gray-500 flex items-center space-x-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ $post->created_at->diffForHumans() }}</span>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-1 text-rose-500" title="{{ $post->like_count }} likes">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <span class="text-sm font-medium">{{ $post->like_count }}</span>
            </div>
            
            <div class="flex items-center space-x-1 text-blue-500" title="{{ $post->comment_count }} comments">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <span class="text-sm font-medium">{{ $post->comment_count }}</span>
            </div>
        </div>
    </div>
</div>