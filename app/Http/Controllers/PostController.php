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
     * Tampilkan daftar post pengguna saat ini
     */
    public function index(Request $request)
    {
        $posts = Post::with('media')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('dashboard', compact('posts'));
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
}
