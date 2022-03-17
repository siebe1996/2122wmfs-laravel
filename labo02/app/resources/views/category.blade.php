@extends('master')
@section('title', 'Blogotopia | '.$category)
@section('main')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8">
                <h3 class="pb-4 mb-4 fst-italic border-bottom">
                    {{ ucfirst($category) }}
                </h3>
                @foreach($categoryBlogposts as $categoryBlogpost)
                <article class="blog-post">
                    <h2 class="blog-post-title">{{ $categoryBlogpost->title }}</h2>
                    <p class="blog-post-meta">{{ $categoryBlogpost->created_at }} by <a href="{{ url('authors/'.$categoryBlogpost->author->id) }}">{{ $categoryBlogpost->author->full_name }}</a></p>
                    <p><img src="{{ asset('storage/'.$categoryBlogpost->image) }}" class="rounded"
                            alt="{{ $categoryBlogpost->title }}">
                    </p>
                    <p>{{ $categoryBlogpost->content }}</p>
                    <a href="{{ url('blogposts/'.$categoryBlogpost->id) }}">Read comments &hellip;</a>
                </article>
                @endforeach
            </div>

            @include('sidebar')
        </div>
    </main>
@endsection
