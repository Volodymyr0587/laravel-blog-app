<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog_posts.blog');
    }

    public function create()
    {
        return view('blog_posts.create-blog-post');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $postData = $request->validate([
            'title' => 'required|string|min:1|max:300',
            'image_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'body' => 'required|string|min:1|max:1000',
        ]);

        if ($request->hasFile('image_path')) {
            $postData['image_path'] = $request->file('image_path')->store('images', 'public');
        }

        $postData['slug'] = Str::slug($postData['title']);

        $post = new Post($postData);
        $post->user()->associate($user);
        $post->save();

        return to_route('blog.index')->with('success', 'Post created successfully.');
    }


    public function show()
    {
        return view('blog_posts.single-blog-post');
    }


}
