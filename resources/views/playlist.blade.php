@extends('layout.master')

@section('content')
    <div id="playlist-container">
        <div class="container">
            <h1> {{$playlist->name}} by {{$playlist->owner}} </h1>
        </div>
        <div class="table-container">
            <table class="track-list">
                <thead>
                <tr>
                    <th>Name and Artist</th>
                    <th>Duration</th>
                    <th>Popularity</th>
                    <th>BPM</th>
                    <th>Key</th>
                    <th>Danceable</th>
                    <th>Energy</th>
                </tr>
                </thead>
                <tbody>
                @foreach (json_decode($trackArray) as $track)
                    <tr class="active track">
                        <td>
                            <b>
                                {{$track->name}}
                            </b>
                            <br>
                            {{$track->artists}}
                        </td>
                        <td>{{$track->duration}}</td>
                        <td>{{$track->popularity}}</td>
                        <td>{{$track->audioFeatures->tempo}}</td>
                        <td>{{$track->audioFeatures->key}}</td>
                        <td>{{$track->audioFeatures->danceability}}</td>
                        <td>{{$track->audioFeatures->energy}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
