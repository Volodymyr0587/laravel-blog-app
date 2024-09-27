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
        @if (session()->has('status'))
        <p x-data="{show:true}" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            style="color: #fff; width:100%;font-size:18px;font-weight:600;text-align:center;background:#5cb85c;padding:17px 0;margin-bottom:6px;">
            {{ session('status') }}
        </p>
        @endif
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
