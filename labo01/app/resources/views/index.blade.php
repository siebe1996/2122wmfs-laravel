@extends('master')
@section('title', 'Overzicht')
@section('main')
    <div id="main">
        <!-- Event table -->
        <section id="event_table">
            <header class="major">
                <h2>Overzicht concerten</h2>
            </header>
            <form method="get" action="{{ url('concerts') }}">
                <div class="row uniform 50%">
                    <div class="6u 12u$(xsmall)"></div>
                    <div class="3u 12u$(xsmall)">
                        <input type="text" name="search" id="search" value="{{ $term }}" placeholder="Zoekterm" />
                    </div>
                    <div class="3u 12u$(xsmall)">
                        <input type="submit" value="Zoeken" class="special fit small" style="height: 3.4em"/>
                    </div>
                </div>
            </form>
            <div class="table-wrapper">
                @if($concerts)
                    <table>
                        <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Naam en locatie</th>
                            <th>Prijs</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($concerts as $concert)
                            <tr>
                                <td>{{ $concert->start_date }}</td>
                                <td><a href="{{ url('concerts/'.$concert->id) }}">{{ $concert->title }} ({{ $concert->location }})</a><br/>
                                    <form method="post" action="{{ url('concerts/'.$concert->id.'/toggle') }}" style="margin: 0">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{ $concert->id }}" />
                                        <input type="hidden" name="moduleAction" value="switch" />
                                        <input type="submit" value="voeg toe aan favorieten" class="small" style="line-height:0em; height: 2em"/>
                                    </form>
                                </td>
                                <td>{{ $concert->price }} &euro;</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p>no concerts available</p>
                @endif
            </div>
        </section>
    </div>
@endsection
