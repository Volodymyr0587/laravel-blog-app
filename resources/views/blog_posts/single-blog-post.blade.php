@extends('layout')

@section('main')
<!-- main -->
<main class="container">
    <section class="single-blog-post">
        <h1>{{ $post->title }}</h1>

        <p class="time-and-author">
            {{ $post->created_at->diffForHumans() }}
            <span>Written By <a class="inline-flex items-center rounded-md bg-gray-600 px-2 py-1 text-xs font-medium text-gray-50 ring-1 ring-inset ring-gray-500/10 hover:bg-gray-50 hover:text-gray-600"
                href="{{ route('blog.filterByUser', $post->user) }}">
                {{ $post->user->name }}</a>
            </span>
        </p>

        <div class="single-blog-post-ContentImage" data-aos="fade-left">
            <img src="{{$post->image_path ? asset('storage/' . $post->image_path) : asset('images/pic2.jpg') }}" alt="" />
        </div>

        <div class="max-w-[700px] mx-auto my-4 px-4 lg:px-0 leading-6 overflow-hidden">
            {!! $post->body !!}
        </div>
    </section>
    <div>{{ $relatedPosts->links('pagination::default') }}</div>
    <section class="recommended">
        <p>Related</p>
        @forelse ($relatedPosts as $relatedPost)
        <div class="recommended-cards">
            <a href="{{ route('blog.show', $relatedPost) }}">
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
