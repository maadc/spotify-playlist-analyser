@extends('layout.master')

@section('content')
    <div id="home-container" class="container-fluid">
        <div class="column col-sm-12 col-md-8 col-6 col-mx-auto">
            <h1 class="text-center">Spotify Playlist Analyser</h1>

            {{--Vue-Component--}}
            <playlist-search></playlist-search>
        </div>
    </div>

@endsection

