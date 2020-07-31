<?php

namespace App\Http\Controllers;

class PlaylistController extends Controller
{
    public function searchPlaylist($query)
    {
        $url = 'https://api.spotify.com/v1/search?q=' . rawurlencode($query) . '&type=playlist&limit=1';
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

            if (empty($result->playlist->items)) {
                return response("no playlist found", 404);
            }

            $playlist = $result->playlists;
            $playlistObject = array("spotifyID" => $playlist->items[0]->id,
                "name" => $playlist->items[0]->name,
                "owner" => $playlist->items[0]->owner->display_name,
                "lastSearches" => date("d/m/y/h/m"),
                "mainImageURL" => $playlist->items[0]->images[0]->url);
            return response($playlistObject, 200);

        } else {
            return response("Loading Playlist error ", 400);
        }
    }
}
