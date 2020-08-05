<!--
todo: when the page is longer opened than 5 -> notice the user to reload due security
-->

@extends('layout.master')

@section('content')
    <div id="home-container" class="container">
            <h1 class="text-center">Classify</h1>
            <p class="text-center">How danceable are your playlists?</p>

            {{--Vue-Component--}}
            <playlist-search :url="'{{$fetchURL}}'"></playlist-search>
    </div>

@endsection

