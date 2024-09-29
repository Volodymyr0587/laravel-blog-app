@extends('layout')

@section('main')
<!-- main -->
<main class="container">

    <h2 class="header-title">
        {{ request()->has('search') ? "Search Results For: $search" :
           (request()->routeIs('blog.filterByCategory') ? "Posts in Category: " . optional(request()->route('category'))->name :
           (request()->routeIs('blog.filterByUser') ? "Posts by User: " . optional(request()->route('user'))->name :
           "All Blog Posts"))}}
    </h2>

    <!-- Status message-->
    <x-flash-messages.status-message />

    <div class="searchbar">
        <form action="{{ route('blog.search') }}">
            @csrf
            <input type="text" placeholder="Search..." name="search" value="{{ old('search') }}" />

            <button type="submit">
                <i class="fa fa-search"></i>
            </button>

        </form>
    </div>
    <div class="categories">
        <ul>
            <li><a class="inline-flex items-center rounded-md bg-gray-600 px-2 py-1 text-md font-medium text-gray-50 ring-1 ring-inset ring-gray-500/10 hover:bg-gray-50 hover:text-gray-600" href="{{ route('blog.index') }}">All</a></li>
            @forelse ($categories as $category)
                <li><a class="inline-flex items-center rounded-md bg-gray-600 px-2 py-1 text-md font-medium text-gray-50 ring-1 ring-inset ring-gray-500/10 hover:bg-gray-50 hover:text-gray-600" href="{{ route('blog.filterByCategory', $category) }}">{{ $category->name }}</a></li>
            @empty
                <li><a href="">No categories yet</a></li>
            @endforelse

        </ul>
    </div>
    <section class="cards-blog latest-blog">
        @forelse ($posts as $post)
            <div class="card-blog-content">
                @auth
                @can('edit-post', $post)
                <div class="post-buttons">
                    <a href="{{ route('blog.edit', $post) }}">Edit</a>
                    <form action="{{ route('blog.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" onclick="return confirm('Are You sure?');"/>
                    </form>
                </div>
                @endcan
                @endauth
                <img src="{{$post->image_path ? asset('storage/' . $post->image_path) : asset('images/pic2.jpg') }}" alt="" />
                <p>
                    {{ $post->created_at->diffForHumans() }}
                    <span>Written By <a class="inline-flex items-center rounded-md bg-gray-600 px-2 py-1 text-xs font-medium text-gray-50 ring-1 ring-inset ring-gray-500/10 hover:bg-gray-50 hover:text-gray-600"
                        href="{{ route('blog.filterByUser', $post->user) }}">
                        {{ $post->user->name }}</a>
                    </span>
                </p>
                <h4 style="font-weight: bolder">
                    <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
                </h4>
            </div>
        @empty
        <h4 style="font-weight: bolder">
            <p>{{ __("No Posts Found.") }}</p>
        </h4>
        @endforelse
    </section>
    <!-- pagination -->
    {{-- <div class="pagination" id="pagination">
        <a href="">&laquo;</a>
        <a class="active" href="">1</a>
        <a href="">2</a>
        <a href="">3</a>
        <a href="">4</a>
        <a href="">5</a>
        <a href="">&raquo;</a>
    </div> --}}
    {{ $posts->links('pagination::default') }}
    <br>
</main>
@endsection
