@extends('layout')

@section('main')
    <div class="categories-list">
        <h1>Categories List</h1>
        <!-- Status message-->
        <x-flash-messages.status-message />
        {{-- @include('includes.flash-message') --}}
        @foreach ($categories as $category)
            <div class="item">
                <p>{{ $category->name }}</p>
                @can('edit-category', $category)
                    <div>
                        <a href="{{ route('categories.edit', $category) }}">Edit</a>
                    </div>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <input type="submit" value="Delete" onclick="return confirm('Are You sure?');">
                    </form>
                @else
                <div>
                    Category created by {{ $category->user->name }}
                </div>
                @endcan
            </div>
        @endforeach
        <div class="index-categories">
            <a href="{{ route('categories.create') }}">Create category<span>&#8594;</span></a>
        </div>
    </div>
@endsection
