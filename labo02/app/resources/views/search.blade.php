@extends('master')
@section('title', 'Blogotopia')
@section('main')
    <main class="container">

        <div class="row p-4 m-5 mb-5 bg-light rounded">
            <h1>{{ request('category_id') }}</h1>
            <h3 class="mb-3">Search blogposts</h3>
            <form class="needs-validation" novalidate="" method="get" action="{{ url('blogposts/search') }}">
                <div class="row g-3">


                    <div class="col-12 col-md-6">
                        <label for="term" class="form-label">Search term(s)</label>
                        <input type="text" class="form-control" id="term" placeholder="" name="term"
                               value="{{ request('term') }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="tags" class="form-label">Containg at least 1 of following tags</label>
                        <input type="text" class="form-control" id="tags" placeholder="" name="tags"
                               value="{{ request('tags') }}">
                    </div>


                    <div class="col-12 col-md-6">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" required="" name="category_id">
                            <option value="">any category</option>
                            @foreach($categories as $choseCategory)
                                @if (intval(request('category_id')) === $choseCategory->id)
                                    <option value="{{ $choseCategory->id }}" selected>{{ $choseCategory->title }}</option>
                                @else
                                    <option value="{{ $choseCategory->id }}">{{ $choseCategory->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="author" class="form-label">Author</label>
                        <select class="form-select" id="author" required="" name="author_id">
                            <option value="">any author</option>
                            @foreach($authors as $choseAuthor)
                                @if(intval(request('author_id')) === $choseAuthor->id)
                                    <option value="{{ $choseAuthor->id }}"
                                            selected>{{ $choseAuthor->full_name }}</option>
                                @else
                                    <option
                                        value="{{ $choseAuthor->id }}">{{ $choseAuthor->full_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="after" class="form-label">Blogposts after</label>
                        <input type="datetime-local" class="form-control" id="after" placeholder="" name="after"
                               value="{{ request('after') }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="before" class="form-label">Blogposts before</label>
                        <input type="datetime-local" class="form-control" id="before" placeholder="" name="before"
                               value="{{ request('before') }}">
                    </div>
                </div>


                <hr class="my-4">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="sort" class="form-label">Sort by</label>
                        <select class="form-select" id="sort" required="" name="sort">
                            @foreach($sortArray as $key => $value)
                                @if(request('sort') === $key)
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>


                </div>

                <hr class="my-4">

                <button class="btn btn-primary btn-lg" type="submit">Search</button>
            </form>

        </div>


        <div class="row mb-2">
            <h4 class="mb-4">
                <a id="results"></a>
                Search results
            </h4>
            @foreach($blogposts as $foundBlogpost)
                <div class="col-md-6">
                    <div
                        class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <strong
                                class="d-inline-block mb-2 category-9">{{ $foundBlogpost->category->title }}</strong>
                            <h3 class="mb-0">{{ $foundBlogpost->title }}</h3>
                            <div class="mb-1 text-muted">{{ $foundBlogpost->created_at }}</div>
                            <p class="card-text mb-auto">{{ $foundBlogpost->content }}</p>
                            <a href="{{ url('blogposts/'.$foundBlogpost->id) }}" class="stretched-link">Continue
                                reading</a>
                        </div>
                        <div class="col-auto d-none d-lg-block img-container">
                            <img src="{{ asset('storage/'.$foundBlogpost->image) }}" alt="{{ $foundBlogpost->title }}"/>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $blogposts->links() }}

            <!--<nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled" aria-disabled="true" aria-label="&laquo; Previous">
                        <span class="page-link" aria-hidden="true">Previous</span>
                    </li>
                    <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                    <li class="page-item"><a class="page-link" href="search?term=s&amp;sort=most_recent&amp;page=2#results">2</a></li>
                    <li class="page-item"><a class="page-link"
                                             href="search?term=s&amp;sort=most_recent&amp;page=3#results">3</a></li>
                    <li class="page-item"><a class="page-link"
                                             href="search?term=s&amp;sort=most_recent&amp;page=4#results">4</a></li>
                    <li class="page-item"><a class="page-link"
                                             href="search?term=s&amp;sort=most_recent&amp;page=5#results">5</a></li>
                    <li class="page-item"><a class="page-link"
                                             href="search?term=s&amp;sort=most_recent&amp;page=6#results">6</a></li>


                    <li class="page-item">
                        <a class="page-link" href="search?term=s&amp;sort=most_recent&amp;page=2#results" rel="next"
                           aria-label="Next &raquo;">Next</a>
                    </li>
                </ul>
            </nav>
            -->

        </div>

    </main>
@endsection
