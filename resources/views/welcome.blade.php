@extends('layout')

<!-- header -->
@section('header')
<!-- header -->
<header class="header" style=" background-image: url({{asset('images/laptop-on-the-table.jpg')}});">
    <div class="header-text">
        <h1>Awesome Blog</h1>
        <h4>Dashboard of verified news...</h4>
    </div>
    <div class="overlay"></div>
</header>
@endsection

@section('main')
<!-- main -->
<main class="container">
    <h2 class="header-title">Latest Blog Posts</h2>
    <section class="cards-blog latest-blog">
        @forelse ($posts as $post)
        <div class="card-blog-content">
            <img src="{{$post->image_path ? asset('storage/' . $post->image_path) : asset('images/pic2.jpg') }}" alt="" />
            <p>
                {{ $post->created_at->diffForHumans() }}
                <span style="float: right">Written By {{ $post->user->name }}</span>
            </p>
            <h4 style="font-weight: bolder">
                <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
            </h4>
        </div>
        @empty
        <div class="card-blog-content">
            <h4 style="font-weight: bolder">No post yet.</h4>
        </div>
        @endforelse
    </section>
</main>
@endsection
