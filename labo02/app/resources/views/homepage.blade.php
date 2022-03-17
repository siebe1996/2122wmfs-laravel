@extends('master')
@section('title', 'Blogotopia')
@section('main')
    <main class="container">
        @if($featuredBlogposts)
        <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark banner"
             style="background-image: linear-gradient(180deg, rgba(255,255,255,0) 0, rgba(0,0,0,0.35) 0), url({{'storage/'.$featuredBlogposts[0]->image}});">
            <div class="col-md-6 px-0">
                <h1 class="display-4 fst-italic">{{ $featuredBlogposts[0]->title }}</h1>
                <p class="lead my-3">{{ $featuredBlogposts[0]->content }}</p>
                <p class="lead mb-0"><a href="{{ url('blogposts/'.$featuredBlogposts[0]->id) }}" class="text-white fw-bold">Continue reading...</a></p>
            </div>
        </div>

        <div class="row mb-2">
            @for($i = 1; $i < count($featuredBlogposts); $i++)
            <div class="col-md-6">
                <div
                    class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 category-2">{{ $featuredBlogposts[$i]->category->title }}</strong>
                        <h3 class="mb-0">{{ $featuredBlogposts[$i]->title }}</h3>
                        <div class="mb-1 text-muted">{{ $featuredBlogposts[$i]->created_at }}</div>
                        <p class="card-text mb-auto">{{ $featuredBlogposts[$i]->content }}</p>
                        <a href="{{ url('blogposts/'.$featuredBlogposts[$i]->id) }}" class="stretched-link">Continue reading</a>
                    </div>
                    <div class="col-auto d-none d-lg-block img-container">
                        <img src="{{ asset('storage/'.$featuredBlogposts[$i]->image) }}"
                             alt="{{ $featuredBlogposts[$i]->title }}"/>
                    </div>
                </div>
            </div>
            @endfor
        </div>
        @else
        <p>no blogposts available</p>
        @endif
    </main>
@endsection
