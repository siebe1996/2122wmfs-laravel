@extends('master')
@section('title', 'Blogotopia | '.$idBlogpost[0]->title)
@section('main')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8">
                <article class="blog-post">
                    <h2 class="blog-post-title">{{ $idBlogpost[0]->title }}</h2>
                    <p class="blog-post-meta">{{ $idBlogpost[0]->created_at }} by <a
                            href="{{ url('authors/'.$idBlogpost[0]->author->id) }}">{{ $idBlogpost[0]->author->full_name }}</a></p>
                    <p><img src="{{ asset('storage/'.$idBlogpost[0]->image) }}"
                            class="rounded" alt="{{ $idBlogpost[0]->title }}">
                    </p>
                    <p>{{ $idBlogpost[0]->content }}</p>
                    <h3>Comments</h3>
                    @foreach($commentsIdBlogpost as $commentIdBlogpost)
                    <p><strong>{{ $commentIdBlogpost->author->full_name }}</strong> &bullet; <em>{{ $commentIdBlogpost->created_at }}</em>{{ $commentIdBlogpost->content }}</p>
                    @endforeach
                </article>

            </div>

            @include('sidebar')
        </div>
    </main>
@endsection
