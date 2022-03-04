@extends('master')
@section('title', 'Blogotopia | '.$idBlogpost[0]->title)
@section('main')
    <main class="container">
        <div class="row g-5">
            <div class="col-md-8">
                <article class="blog-post">
                    <h2 class="blog-post-title">{{ $idBlogpost[0]->title }}</h2>
                    <p class="blog-post-meta">{{ $idBlogpost[0]->created_at }} by <a
                            href="{{ url('author/'.$idBlogpost[0]->authorId) }}">{{ $idBlogpost[0]->first_name.' '.$idBlogpost[0]->last_name }}</a></p>
                    <p><img src="{{ asset('storage/'.$idBlogpost[0]->image) }}"
                            class="rounded" alt="{{ $idBlogpost[0]->title }}">
                    </p>
                    <p>{{ $idBlogpost[0]->content }}</p>
                    <h3>Comments</h3>
                    @foreach($commentsIdBlogpost as $commentIdBlogpost)
                    <p><strong>{{ $commentIdBlogpost->first_name.' '.$commentIdBlogpost->last_name }}</strong> &bullet; <em>{{ $commentIdBlogpost->created_at }}</em>{{ $commentIdBlogpost->content }}</p>
                    @endforeach
                </article>

            </div>

            @include('sidebar')
        </div>
    </main>
@endsection
