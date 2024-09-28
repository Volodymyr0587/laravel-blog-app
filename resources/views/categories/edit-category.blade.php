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
        <h1 style="padding-top: 50px;">Edit Category: {{ $category->name }}</h1>
        <!-- Status message-->
        @if (session()->has('status'))
        <p x-data="{show:true}" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            style="color: #fff; width:100%;font-size:18px;font-weight:600;text-align:center;background:#5cb85c;padding:17px 0;margin-bottom:6px;">
            {{ session('status') }}
        </p>
        @endif
        <!-- Contact Form -->
        <div class="contact-form">
            <form action="{{ route('categories.update', $category) }}" method="POST" >
                @csrf
                @method('PUT')
                <!-- Name -->
                <label for="name"><span>Name</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" />
                @error('name')
                    <p style="color: red; margin-bottom: 25px;">{{ $message }}</p>
                @enderror
                <!-- Button -->
                <input type="submit" value="Submit" />
            </form>
        </div>
        <div class="create-categories">
            <a href="{{ route('categories.index') }}">Categories list <span>&#8594;</span></a>
        </div>

    </section>
</main>
@endsection
