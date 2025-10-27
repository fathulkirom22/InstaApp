<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\PostMedia;

class PostController extends Controller
{
    /**
     * Tampilkan detail post
     */
    public function view(Request $request, $id)
    {
        $post = Post::with('media', 'user')
            ->findOrFail($id);

        // Cek apakah post bersifat publik atau milik pengguna saat ini
        if (!$post->is_public && (!$request->user() || $request->user()->id != $post->user_id)) {
            abort(403, 'You do not have permission to view this post.');
        }

        return view('post.view', compact('post'));
    }

    /**
     * Simpan post baru dengan media
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'caption' => 'nullable|string|max:2200',
            'images'  => 'required|array|min:1|max:10',
            'images.*' => 'file|image|max:2048',
            'is_public' => 'sometimes|boolean',
        ]);

        DB::beginTransaction();

        try {
            // Buat post baru
            $post = Post::create([
                'user_id' => $request->user()->id,
                'caption' => $validated['caption'] ?? null,
                'is_public' => $validated['is_public'] ?? true,
            ]);

            // Simpan file gambar
            foreach ($validated['images'] as $index => $file) {
                $path = $file->store('posts/' . date('Y/m'), 'public');

                PostMedia::create([
                    'post_id' => $post->id,
                    'type'    => 'image',
                    'path'    => $path,
                    'mime'    => $file->getClientMimeType(),
                    'order'   => $index,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('dashboard')
                ->with('success', 'Post berhasil dibuat!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Gagal membuat post: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Suka atau tidak suka pada post
     */
    public function like(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Cek apakah pengguna sudah menyukai post ini
        $like = $post->likes()->where('user_id', $request->user()->id)->first();

        if ($like) {
            // Jika sudah disukai, batalkan suka
            $like->delete();
            $post->decrement('like_count');
        } else {
            // Jika belum disukai, berikan tanda suka pada post
            $post->likes()->create([
                'user_id' => $request->user()->id,
            ]);
            $post->increment('like_count');
        }

        return redirect()->back()->with('success', 'Your like status has been updated.');
    }
}
