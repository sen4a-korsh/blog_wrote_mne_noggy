<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(6);
        $randomPosts = Post::get()->random(4);
        $popularPosts = Post::withCount('likedUsers')->orderBy('liked_users_count', 'DESC')->get()->take(4);
        return view('post.index', compact('posts','randomPosts', 'popularPosts'));
    }

    public function show(Post $post)
    {
        $postDate = Carbon::parse($post->created_at);
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->get()
            ->take(3);
        return view('post.show', compact('post', 'postDate', 'relatedPosts'));
    }

    public function indexCategoryPosts(Category $category)
    {
        $posts = $category->posts()->paginate(6);
        return view('category.post.index', compact('posts', 'category'));
    }

}
