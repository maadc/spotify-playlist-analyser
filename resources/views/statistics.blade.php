@extends('layout.master')

@section('content')
    <div id="statistics-container" class="container-fluid">
        <div class="column col-md-12 col-xl-10 col-8 col-mx-auto">
            <h1 class="text-center">Statistics</h1>
            <p class="text-center">Which playlist gets analysed the most?</p>

            {{--Vue-Component--}}
            <statistics :list="{{$playlistArray}}" :top="{{$top10Array}}"></statistics>
        </div>
    </div>

@endsection
