<?php

namespace App\Http\Controllers;

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

    public function show()
    {
        return view('blog_posts.single-blog-post');
    }


}
