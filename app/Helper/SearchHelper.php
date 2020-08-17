<?php


namespace App\Helper;

use App\Http\Controllers\AuthController;

class SearchHelper
{

    public function fillPlaylistArray($playlistItems)
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

    public function searchName($query)
    {
        $url = 'https://api.spotify.com/v1/search?q='
            . rawurlencode($query)
            . '&type=playlist&limit=5';
        $token = (new AuthController(new AuthHelper))->key();
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . $token
            )
        );
        $context = stream_context_create($options);
        return json_decode(file_get_contents($url, false, $context));
    }

    public function searchID($id)
    {
        $url = 'https://api.spotify.com/v1/playlists/' . $id;
        $token = (new AuthController(new AuthHelper))->key();
        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . $token
            )
        );
        $context = stream_context_create($options);

        if(self::get_http_response_code($url, $context) != "200"){
            return "ID not found";
        }
        return json_decode(file_get_contents($url, false, $context));
    }

    public static function get_http_response_code($url, $context) {
        $headers = get_headers($url, null, $context);
        return substr($headers[0], 9, 3);
    }


}
