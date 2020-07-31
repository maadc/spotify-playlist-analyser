<?php

namespace App\Http\Controllers;

class TrackController extends Controller
{
    public function trackAnalysis()
    {
        $playlistID = request("nachricht");
        $token = AuthController::key()->content();

        $url = 'https://api.spotify.com/v1/playlists/' . rawurlencode($playlistID) . '/tracks';
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . $token
            )
        );
        $context = stream_context_create($options);
        $result = json_decode(file_get_contents($url, false, $context));

        //Array containing all Tracks
        $trackArray = [];

        /*
        * Get all the Tracks of the Playlist
        */
        foreach ($result->items as $track) {

            //figure out if there are more than one artist
            $artists = "";
            foreach ($track->track->artists as $key => $artist) {
                if ($key === 0) {
                    $artists = $artist->name;
                } else {
                    $artists = $artists . ", " . $artist->name;
                }
            }

            /*
            * Get Audiofeatures and also save them in the Array
            */
            $id = $track->track->id;
            $audioFeatures = self::getAudioFeatures($id, $token);
            $trackAudioFeatures =
                [
                    "key" => $audioFeatures->key,
                    "acousticness" => $audioFeatures->acousticness,
                    "danceability" => $audioFeatures->danceability,
                    "energy" => $audioFeatures->energy,
                    "instrumentalness" => $audioFeatures->instrumentalness,
                    "liveness" => $audioFeatures->liveness,
                    "loudness" => $audioFeatures->loudness,
                    "speechiness" => $audioFeatures->speechiness,
                    "valence" => $audioFeatures->valence,
                    "tempo" => $audioFeatures->tempo,
                ];

            /*
             * Save all properties of this track in the trackArray containing all Tracks
             */

            array_push($trackArray, [
                "id" => $track->track->id,
                "name" => $track->track->name,
                "artists" => $artists,
                "duration" => $track->track->duration_ms,
                "popularity" => $track->track->popularity,
                "audioFeatures" => $trackAudioFeatures
            ]);
        }


        return view('playlist', ["trackArray" => json_encode($trackArray)]);
    }

    public static function getAudioFeatures($id, $token)
    {
        $url = 'https://api.spotify.com/v1/audio-features/' . $id;
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . $token
            )
        );
        $context = stream_context_create($options);
        return json_decode(file_get_contents($url, false, $context));
    }
}
