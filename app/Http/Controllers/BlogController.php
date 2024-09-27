<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('blog_posts.blog', compact('posts'));
    }

    public function create()
    {
        return view('blog_posts.create-blog-post');
    }

    public function store(StorePostRequest $request)
    {
        $user = auth()->user();

        $postData = $request->validated();

        // Handle image upload
        $postData['image_path'] = $this->handleImageUpload($request);

        // Save the post with mass assignment
        $user->posts()->create($postData);

        return redirect()->back()->with('status', 'Post created successfully.');
    }

    protected function handleImageUpload($request)
    {
        if ($request->hasFile('image_path')) {
            return $request->file('image_path')->store('images', 'public');
        }

        return null;
    }


    public function show(Post $post)
    {
        return view('blog_posts.single-blog-post', compact('post'));
    }


}
