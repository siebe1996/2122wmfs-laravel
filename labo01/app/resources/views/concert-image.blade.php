@extends('master')
@section('title', $concert[0]->title)
@section('main')
    <div id="main">
        <!-- Event table -->
        <section id="concert">
            <header class="major">
                <h2>{{$concert[0]->title}}</h2>
            </header>
            <div class="table-wrapper">
                <div class="box alt">

                    <div class="row 50% uniform">
                        <div class="12u$"><span class="image fit"><img src="{{asset($img[0]->path)}}" alt="" /></span></div>
                    </div>
                </div>
                <p><a href="{{ url('concerts/'.$concert[0]->id) }}">Terug naar concert</a></p>
            </div>
        </section>
    </div>
@endsection
