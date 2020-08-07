@extends('layout.master')

<!--
todo: share button with signed URL
todo: notification when file in playlist is local
-->

@section('content')
    <div id="playlist-container" class="container">
            <h1 class="h3"> {{$playlist->name}}</h1>
        <p>by {{$playlist->owner}}</p>

        <playlist :playlist="{{$trackArray}}"></playlist>
    </div>
@endsection
