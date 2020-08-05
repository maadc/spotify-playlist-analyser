@extends('layout.master')

@section('content')
    <div id="statistics-container" class="container-fluid">
        <h1 class="text-center">Statistics</h1>
        <p class="text-center">Which playlist gets analysed the most?</p>

        {{--Vue-Component--}}
        <statistics :list="{{$playlistArray}}" :top="{{$top10Array}}"></statistics>
    </div>

@endsection
