@extends('layout.master')

@section('content')
<div id="home-container" class="container-fluid">
    <div class="column col-6 col-mx-auto">
        <h1 class="text-center">Spotify Playlist Analyser</h1>

        <form class="text-center input-group" action="{{route('playlist.analyse')}}" method="POST">
            @csrf
            <input class="form-input" type="text" name="nachricht" placeholder="Playlist">
            <input class="input-group-addon" type="submit" value="Abschicken">
        </form>

    </div>
</div>
@endsection

