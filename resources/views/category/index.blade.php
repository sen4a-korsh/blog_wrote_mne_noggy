@extends('layouts.main')

@section('content')

<main class="blog ">
    <div class="container" style="margin-bottom: 100px">
        <h1 class="edica-page-title" data-aos="fade-up">Categories</h1>
        <section class="featured-posts-section">
            <ul>
                @foreach($categories as $category)
                    <h3><li><a href="{{ route('category.post.index', $category->id) }}">{{ $category->title }}</a></li></h3>
                @endforeach
            </ul>
        </section>
    </div>
</main>
@endsection
