@extends('layout.master')

@section('content')
    <div id="home-container" class="container-fluid">
        <div class="column col-sm-12 col-md-8 col-6">
            <h1 class="h2">Statistics</h1>
            <h2 class="h3">What did Classify users search?</h2>

            {{--Vue-Component--}}
            <statistics></statistics>
        </div>
    </div>

@endsection
