@extends('layout')

@section('head')
{{-- CKEditor style --}}
<style>
    .ck-editor__editable_inline {
        min-height: 300px;
    }
</style>
@endsection

@section('main')
<main class="container" style="background-color: #fff;">
    <section id="contact-us">
        <h1 style="padding-top: 50px;">Edit Post: {{ $post->title }}</h1>
        <!-- Status message-->
        <x-flash-messages.status-message />
        <!-- Contact Form -->
        <div class="contact-form">
            <form action="{{ route('blog.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Title -->
                <label for="title"><span>Title</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" />
                @error('title')
                    <p style="color: red; margin-bottom: 25px;">{{ $message }}</p>
                @enderror

                <!-- Image -->
                <label for="image_path"><span>Image</span></label>
                <input type="file" id="image_path" name="image_path" />
                @error('image_path')
                    <p style="color: red; margin-bottom: 25px;">{{ $message }}</p>
                @enderror

                <!-- Categories Dropdown -->
                <label for="categories">Choose a category</label>
                <select name="category_id[]" id="categories" multiple>
                    <option selected disabled>Select Category</option>
                    @foreach ($categories as $category)
                    <option required value="{{ $category->id }}"
                        @if(in_array($category->id, $post->categories->pluck('id')->toArray())) selected @endif>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p style="color: red; margin-bottom: 25px;">{{ $message }}</p>
                @enderror

                <!-- Body-->
                <label for="body"><span>Body</span></label>
                <textarea id="editor" name="body">{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <p style="color: red; margin-top: 25px;">{{ $message }}</p>
                @enderror

                <!-- Button -->
                <input type="submit" value="Submit" />
            </form>
        </div>

    </section>
</main>
@endsection
