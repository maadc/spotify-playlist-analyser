<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    /*
     * triggered: PlaylistController, TrackController
     *
     * Returns an Spotify Access-Token which allows the other API-Requests to happen
     *
     * This function causes an weird error sometimes:
     * failed to open stream: HTTP request failed! HTTP/1.0 400 Bad Request
     *
     * Solution (works sometimes):
     * $ git reset --hard
     * $ php artisan optimize
     * $ php artisan config:clear
     */
    public static function key()
    {
        $url = 'https://accounts.spotify.com/api/token';
        $data = array('client_id' => env('SPOTIFY_CLIENTID'), 'client_secret' => env('SPOTIFY_CLIENTSECRET'), 'grant_type' => 'client_credentials');

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { return response("Authorization error ", 400);}

        return response(json_decode($result)->access_token, 200);
    }
}
