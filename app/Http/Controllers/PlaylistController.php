<?php

namespace App\Http\Controllers;

use App\playlist;
use App\Http\Controllers;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function searchPlaylist($query){
        $url = 'https://api.spotify.com/v1/search?q='. $query . '&type=playlist&limit=1';
//        $data = array('q' => $query, 'type' => 'playlist', 'limit' => '1');

        $token = AuthController::key()->content();
        $options = array(
            'http' => array(
                'method'  => 'GET',
                'header' => 'Authorization: Bearer ' . $token
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { return response("Loading Playlist error ", 400);}

        return response($result, 200);
    }
}
