<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>@yield('title')</title>



    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{asset('img/icons/apple-touch-icon.png')}}" sizes="180x180">
    <link rel="icon" href="{{asset('img/icons/favicon-32x32.png')}}" sizes="32x32" type="image/png">
    <link rel="icon" href="{{asset('img/icons/favicon-16x16.png')}}" sizes="16x16" type="image/png">
    <link rel="mask-icon" href="{{asset('img/icons/safari-pinned-tab.svg')}}" color="#7952b3">
    <link rel="icon" href="{{asset('img/icons/favicon.ico')}}">
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{asset('css/blog.css')}}" rel="stylesheet">
</head>
<body id="top">

<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <a class="link-secondary" href="{{ url('blogposts/add') }}">Add a blogpost</a>
            </div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark" href="{{ url('/') }}">Blogotopia</a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <a class="link-secondary" href="{{ url('blogposts/search') }}" aria-label="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"/><path d="M21 21l-5.2-5.2"/></svg>
                </a>
                <a class="btn btn-sm btn-outline-secondary" href="#">Sign up</a>
            </div>
        </div>
    </header>

    <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
            @isset($categories)
            @foreach($categories as $navCategory)
            <a class="p-2 link-secondary" href="{{ url('categories/'.$navCategory->title) }}">{{ $navCategory->title }}</a>
            @endforeach
            @endisset
        </nav>
    </div>
</div>

@section('main')
@show

<footer class="blog-footer">
    <p>&copy; Web &amp; Mobile Full-stack @ <a href="https://www.odisee.be">odisee</a> | 2022 | template by <a href="https://twitter.com/mdo">@mdo</a>.</p>
    <p>
        <a href="#top">Back to top</a>
    </p>
</footer>



</body>
</html>
