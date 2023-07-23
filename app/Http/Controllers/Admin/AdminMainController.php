<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class AdminMainController extends Controller
{
    public function index()
    {
        $countData = [];
        $countData['usersCount'] = User::count();
        $countData['postsCount'] = Post::count();
        $countData['categoriesCount'] = Category::count();
        $countData['tagsCount'] = Tag::count();

        return view('admin.main.index', compact('countData'));
    }
}
