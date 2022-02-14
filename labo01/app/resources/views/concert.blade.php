@extends('master')
@section('title', $concert[0]->title)
@section('main')
    <div id="main">
        <!-- Event table -->
        <section id="concert">
            <header class="major">
                <h2>{{ $concert[0]->title }}</h2>
            </header>
            <div class="table-wrapper">
                <table>
                    <tbody>
                    <tr>
                        <th>Datum</th>
                        <td>{{ $concert[0]->start_date }}</td>
                    </tr>
                    <tr>
                        <th>Locatie</th>
                        <td>{{ $concert[0]->location }}</td>
                    </tr>
                    <tr>
                        <th>Prijs</th>
                        <td>
                            {{ $concert[0]->price }} &euro;
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="box alt">
                    <div class="row 50% uniform">
                        <div class="4u"><a href="{{ url('concerts/'.$concert[0]->id.'/images/'.(($concert[0]->id - 1) * 2 + 1)) }}"
                                           class="image fit thumb"><img
                                    src="{{ asset($images[0] -> path) }}" alt=""/></a></div>
                        <div class="4u"><a href="{{ url('concerts/'.$concert[0]->id.'/images/'.(($concert[0]->id - 1) * 2 + 2)) }}"
                                           class="image fit thumb"><img
                                    src="{{ asset($images[1] -> path) }}" alt=""/></a></div>
                    </div>
                </div>
                <p><a href="{{ url('concerts') }}">Terug naar overzicht</a></p>
            </div>
        </section>
    </div>
@endsection

