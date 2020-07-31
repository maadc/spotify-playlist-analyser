<h1> Here is your Playlist! </h1>

<div>
    @foreach (json_decode($trackArray) as $track)
        <p>
        <ul>
            <li>Name: {{$track->name}}</li>
            <li>Artist: {{$track->artists}}</li>
            <li>Popularity: {{$track->popularity}}</li>
            <li>BPM: {{$track->audioFeatures->tempo}}</li>
            <li>Danceability: {{$track->audioFeatures->danceability}}</li>
            <li>Energy: {{$track->audioFeatures->energy}}</li>
        </ul>
        </p>

    @endforeach
</div>
