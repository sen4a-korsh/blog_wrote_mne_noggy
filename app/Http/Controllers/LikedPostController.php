<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikedPostController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->likedPosts;
        return view('personal.liked-post.index', compact('posts'));
    }

    public function store(Post $post)
    {
        auth()->user()->likedPosts()->toggle($post->id);
        return redirect()->back();
    }

    public function destroy(Post $post)
    {
        auth()->user()->likedPosts()->detach($post->id);
        return redirect()->route('personal.liked-post.index');
    }
}
