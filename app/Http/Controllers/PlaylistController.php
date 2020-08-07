<?php

namespace App\Http\Controllers;

class PlaylistController extends Controller
{
    /*
     * triggered: resources/js/components/PlaylistSearch.vue
     *
     * Takes the search-query from input field on the home-page
     * and returns a limited amount of spotify-playlist in a
     * readable format.
     *
     * supports alternativ queries -> Playlist-URL and URI
     */


    public static function searchID($id)
    {
        $url = 'https://api.spotify.com/v1/playlists/' . $id;
        $token = AuthController::key();
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . $token
            )
        );
        $context = stream_context_create($options);
        return json_decode(file_get_contents($url, false, $context));

    }

    public function index()
    {
        /*
         * $input could be the: Name
         * URL like (https://open.spotify.com/playlist/37i9dQZEVXbdqMLCl8GN9P?si=kIi9ZZV2QXiEOr5Ser_54A)
         * URI like (spotify:playlist:37i9dQZEVXbdqMLCl8GN9P)
         */

        $input = request()->input("query");

        //check if the input is an URL or URI, if then $matches[1] contains the ID
        if (preg_match('/playlist[:\/](\w*\d*)/', $input, $matches, PREG_UNMATCHED_AS_NULL) === 1) {

            //it is an URL/URI
            $id = $matches[1];
            $result = self::searchID($id);

            if (empty($result)) {
                return response("no playlist found", 404);
            } else {
                $playlistArray[0] = array(
                    "spotifyID" => $result->id,
                    "name" => $result->name,
                    "owner" => $result->owner->display_name,
                    "mainImageURL" => $result->images[0]->url);
                return response($playlistArray, 200);
            }
        } else {
            //it is an name
            $result = self::searchName($input);

            if (empty($result->playlists->items)) {
                return response("no playlist found", 404);
            } else {

                return response(self::fillPlaylistArray($result->playlists->items), 200);
            }
        }
    }

    public static function searchName($query)
    {
        $url = 'https://api.spotify.com/v1/search?q=' . rawurlencode($query) . '&type=playlist&limit=5';
        $token = AuthController::key();
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . $token
            )
        );
        $context = stream_context_create($options);
        return json_decode(file_get_contents($url, false, $context));
    }

    public static function fillPlaylistArray($playlistItems)
    {
        //fill $playlistArray with only needed data about each playlist
        $playlistArray = [];
        foreach ($playlistItems as $key => $list) {

            $playlistArray[$key] = array(
                "spotifyID" => $list->id,
                "name" => $list->name,
                "owner" => $list->owner->display_name,
                "mainImageURL" => $list->images[0]->url);
        }
        return $playlistArray;
    }
}
