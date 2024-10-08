<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchPostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'search' => 'required|string|max:255',
        ]);

        $search = $request->input('search');

        $posts = Post::whereAny(
            [
                'title',
                'body',
            ],
            'LIKE',
            "%$search%"
        )->latest()->paginate(4)->withQueryString();

        $categories = Category::all();

        return view('blog_posts.blog', compact('posts', 'search', 'categories'));
    }
}
