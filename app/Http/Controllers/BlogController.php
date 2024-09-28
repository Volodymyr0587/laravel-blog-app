<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
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
        $categories = Category::all();

        return view('blog_posts.blog', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('blog_posts.create-blog-post', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        $user = auth()->user();

        $postData = $request->validated();

        // Handle image upload
        $postData['image_path'] = $this->handleImageUpload($request);

        // Save the post with mass assignment
        $post = $user->posts()->create($postData);
        // Attach categories to post through pivot table
        $post->categories()->attach($request->category_id);

        return redirect()->back()->with('status', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        // Get all categories associated with the current post
        $categoryIds = $post->categories->pluck('id')->toArray();

        // Fetch all posts that belong to the same categories, excluding the current post
        $relatedPosts = Post::whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        })
            ->where('id', '!=', $post->id) // Exclude the current post
            ->distinct() // Prevent duplicate posts if they belong to multiple shared categories
            ->get();

        return view('blog_posts.single-blog-post', compact('post', 'relatedPosts'));
    }

    public function edit(Post $post)
    {
        Gate::authorize('edit-post', $post);

        $categories = Category::all();

        return view('blog_posts.edit-blog-post', compact('post', 'categories'));
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
        // Sync categories to post through pivot table
        $post->categories()->sync($request->category_id);

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

        $post->categories()->detach();
        $post->delete();

        return redirect()->route('blog.index')->with('status', 'Post deleted successfully.');
    }
}
