<?php

namespace App\Http\Controllers;

class TrackController extends Controller
{
    /*
     * triggered: when one playlist is chosen to analyse
     *
     * It is a POST-Request containing an playlist-object.
     * Containing: spotifyID, name, owner, lastSearched, mainImageURL
     *
     * Returns an huge array containing every song of the playlist.
     * Prepared to show on playlist.blade.php
     *
     * todo: save playlist in top-playlists.db
     * todo: save track in top-tracks.db
     * todo: duration in Minutes and Seconds
     */

    public function trackAnalysis()
    {
        $playlist = json_decode(request("playlist"));


        $playlistID = $playlist->spotifyID;
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
             * Save all properties of this track in the trackArray containing all Tracks
             */
            array_push($trackArray, [
                "id" => $track->track->id,
                "name" => $track->track->name,
                "artists" => $artists,
                "duration" => $track->track->duration_ms / 1000, //ms -> s
                "popularity" => $track->track->popularity,
                "audioFeatures" => []
            ]);
        }

        /*
         * Get Audiofeatures and also save them in the Array
         */
        //generate the URL with all trackIDs
        $trackIDString = "";
        foreach ($trackArray as $key => $track) {
            if ($key === 0) {
                $trackIDString = $track["id"];
            } else {
                $trackIDString = $trackIDString . "," . $track["id"];
            }
        }

        //get all the Audio-Features at once
        $audioFeatures = self::getAudioFeatures($trackIDString, $token);

        //assign the audio-features to every track
        foreach ($trackArray as $key => $track) {
            $trackAudioFeatures =
                [
                    "key" => $audioFeatures->audio_features[$key]->key,
                    "acousticness" => $audioFeatures->audio_features[$key]->acousticness,
                    "danceability" => $audioFeatures->audio_features[$key]->danceability,
                    "energy" => $audioFeatures->audio_features[$key]->energy,
                    "instrumentalness" => $audioFeatures->audio_features[$key]->instrumentalness,
                    "liveness" => $audioFeatures->audio_features[$key]->liveness,
                    "loudness" => $audioFeatures->audio_features[$key]->loudness,
                    "speechiness" => $audioFeatures->audio_features[$key]->speechiness,
                    "valence" => $audioFeatures->audio_features[$key]->valence,
                    "tempo" => $audioFeatures->audio_features[$key]->tempo,
                ];
            $trackArray[$key]["audioFeatures"] = $trackAudioFeatures;
        }
        return view('playlist', ["trackArray" => json_encode($trackArray), "playlist" => $playlist]);
    }

    public static function getAudioFeatures($trackIDString, $token)
    {
        $url = 'https://api.spotify.com/v1/audio-features/?ids=' . $trackIDString;
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
