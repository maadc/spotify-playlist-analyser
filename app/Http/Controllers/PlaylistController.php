<?php

namespace App\Http\Controllers;

class PlaylistController extends Controller
{
    public function searchPlaylist()
    {
        $query = request()->input("query");
        $url = 'https://api.spotify.com/v1/search?q=' . rawurlencode($query) . '&type=playlist&limit=5';
        $token = AuthController::key()->content();
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . $token
            )
        );
        $context = stream_context_create($options);
        $result = json_decode(file_get_contents($url, false, $context));
        if (is_object($result)) {

            if (empty($result->playlists->items)) {
                return response("no playlist found", 404);
            }

            //Array containing all playlist results
            $playlistArray = [];
            foreach ($result->playlists->items as $key =>$list){

                $playlistArray[$key] = array(
                    "spotifyID" => $list->id,
                    "name" => $list->name,
                    "owner" => $list->owner->display_name,
                    "lastSearches" => date("d/m/y/h/m"),
                    "mainImageURL" => $list->images[0]->url);
            }

            return response($playlistArray, 200);

        } else {
            return response("Loading Playlist error ", 400);
        }
    }
}
