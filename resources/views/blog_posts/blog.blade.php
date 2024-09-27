@extends('layout')

@section('main')
<!-- main -->
<main class="container">
    <h2 class="header-title">{{ request()->has('search') ? "Seaarch Results For: $search" : 'All Blog Posts' }}</h2>
    @if (session()->has('status'))
        <p x-data="{show:true}" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            style="color: #fff; width:100%;font-size:18px;font-weight:600;text-align:center;background:#5cb85c;padding:17px 0;margin-bottom:6px;">
            {{ session('status') }}
        </p>
    @endif
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
            <li><a href="">Health</a></li>
            <li><a href="">Entertainment</a></li>
            <li><a href="">Sports</a></li>
            <li><a href="">Nature</a></li>
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
                    <span>Written By {{ $post->user->name }}</span>
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
