<!--
todo: when the page is longer opened than 5 -> notice the user to reload due security
-->

@extends('layout.master')

@section('content')
    <div id="home-container" class="container-fluid">
        <div class="column col-sm-12 col-md-8 col-6 col-mx-auto">
            <h1 class="text-center">Classify</h1>
            <h2 class="text-center">How danceable are your playlists?</h2>

            {{--Vue-Component--}}
            <playlist-search :url="'{{$fetchURL}}'"></playlist-search>
        </div>
    </div>

@endsection

