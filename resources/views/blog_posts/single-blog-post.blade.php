@extends('layout')

@section('main')
<!-- main -->
<main class="container">
    <section class="single-blog-post">
        <h1>{{ $post->title }}</h1>

        <p class="time-and-author">
            {{ $post->created_at->diffForHumans() }}
            <span>Written By {{ $post->user->name }}</span>
        </p>

        <div class="single-blog-post-ContentImage" data-aos="fade-left">
            <img src="{{$post->image_path ? asset('storage/' . $post->image_path) : asset('images/pic2.jpg') }}" alt="" />
        </div>

        <div class="about-text">
            {!! $post->body !!}
        </div>
    </section>
    <section class="recommended">
        <p>Related</p>
        @forelse ($relatedPosts as $relatedPost)
        <div class="recommended-cards">
            <a href="">
                <div class="recommended-card">
                    <img src="{{$relatedPost->image_path ? asset('storage/' . $relatedPost->image_path) : asset('images/pic2.jpg') }}" alt="" />
                    <h4>
                        {{ $relatedPost->title }}
                    </h4>
                </div>
            </a>
        </div>
        @empty
            No Related Posts Found
        @endforelse

    </section>
</main>
@endsection
