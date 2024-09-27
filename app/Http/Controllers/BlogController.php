<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(4);
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

    public function show(Post $post)
    {
        return view('blog_posts.single-blog-post', compact('post'));
    }

    public function edit(Post $post)
    {
        Gate::authorize('edit-post', $post);

        return view('blog_posts.edit-blog-post', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        Gate::authorize('edit-post', $post);

        $postData = $request->validated();

        // Handle image upload and remove old image if necessary
        if ($request->hasFile('image_path')) {
            $this->deleteOldImage($post); // Delete old image method
            $postData['image_path'] = $this->handleImageUpload($request);
        }

        // Save the post with mass assignment
        $post->update($postData);

        return redirect()->back()->with('status', 'Post updated successfully.');
    }

    protected function handleImageUpload($request)
    {
        if ($request->hasFile('image_path')) {
            return $request->file('image_path')->store('images', 'public');
        }

        return null;
    }

    protected function deleteOldImage(Post $post)
    {
        // Check if old image exists and it's not null
        if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
            // Delete old image
            Storage::disk('public')->delete($post->image_path);
        }
    }

    public function destroy(Post $post)
    {
        Gate::authorize('edit-post', $post);

        $post->delete();

        return redirect()->route('blog.index')->with('status', 'Post deleted successfully.');
    }
}
