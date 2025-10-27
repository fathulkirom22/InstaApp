<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $post = Post::findOrFail($id);

        $post->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->content,
        ]);

        $post->increment('comment_count');

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
