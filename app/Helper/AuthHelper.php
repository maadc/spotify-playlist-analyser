<?php


namespace App\Helper;


class AuthHelper
{
    public static function getKey()
    {
        $url = 'https://accounts.spotify.com/api/token';
        $data = array(
            'client_id' => env('SPOTIFY_CLIENTID'),
            'client_secret' => env('SPOTIFY_CLIENTSECRET'),
            'grant_type' => 'client_credentials');

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return response("Authorization error ", 400);
        }

        return response($result, 200);
    }
}
