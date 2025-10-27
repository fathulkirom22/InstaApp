<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::where('is_public', true)
            ->with('media', 'user')
            ->latest()
            ->get();

        return view('index', compact('posts'));
    }
}
