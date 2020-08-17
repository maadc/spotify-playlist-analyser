<?php

namespace App\Http\Controllers;

use App\Helper\AuthHelper;
use Illuminate\Support\Facades\DB;

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
     * todo: duration in Minutes and Seconds
     * todo: more than 100 songs
     */

    public function trackAnalysis()
    {
        $playlist = json_decode(request("playlist"));
        $token = (new AuthController(new AuthHelper))->key();

        // Store the playlist data in the statistics db
        self::safePlaylistStatistic($playlist);

        //Array containing all Tracks
        $trackArray = [];

        /*
        * Get all the Tracks of the Playlist
        */
        foreach (self::getTracks($playlist->spotifyID, $token)->items as $track) {

            //figure out if there are more than one artist for this track
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
                "url" => $track->track->external_urls->spotify,
                "audioFeatures" => []
            ]);
        }

        /*
         * Get Audiofeatures and also save them in the Array
         */
        //generate the needed URL with all trackIDs for the next API call
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
            if ($audioFeatures->audio_features[$key] === null) {
                $trackArray[$key]["audioFeatures"] = [];
            } else {
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
        }
        return view('playlist',
            ["trackArray" => json_encode($trackArray), "playlist" => $playlist]);
    }

    public static function safePlaylistStatistic($playlist)
    {
        $existingStatistic = DB::table("top-playlists")
            ->where("spotifyID", $playlist->spotifyID)
            ->first();

        if ($existingStatistic === null) {
            DB::table("top-playlists")->insert([
                "spotifyID" => $playlist->spotifyID,
                "name" => $playlist->name,
                "owner" => $playlist->owner,
                "lastSearched" => now(),
                "mainImageURL" => $playlist->mainImageURL
            ]);
        } else {
            DB::table("top-playlists")
                ->where("spotifyID", $playlist->spotifyID)
                ->update([
                    "lastSearched" => now(),
                    "counter" => $existingStatistic->counter + 1

                ]);
        }


    }

    public static function getTracks($playlistID, $token)
    {
        $url = 'https://api.spotify.com/v1/playlists/' . rawurlencode($playlistID) . '/tracks';
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . $token
            )
        );
        $context = stream_context_create($options);
        return json_decode(file_get_contents($url, false, $context));
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
