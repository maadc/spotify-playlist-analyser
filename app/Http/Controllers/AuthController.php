<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /*
     * triggered: PlaylistController, TrackController
     *
     * Returns an Spotify Access-Token which allows the other API-Requests to happen.
     *
     * There exists only on valid bearer access token at the time. I am doing this because
     * I want to reduce the traffic and the possibility that this application gets blocked due
     * to many API-calls.
     *
     * It is fact that each access token expires after 3600 seconds. It is not clear how much
     * API-calls this application can make in what timespan. To be safe I limited on 60 uses per
     * token.
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
        $key = DB::table("access_tokens")->first();

        if ($key === null) {
            $newKey = json_decode(self::getKey()->content());
            DB::table('access_tokens')->insert(
                [
                    'access_token' => $newKey->access_token,
                    'expires' => now()->addSeconds($newKey->expires_in),
                    'created_at' => now()
                ]
            );
            return $newKey->access_token;

        } elseif ($key->expires > now() && $key->uses < 60) {
            /*
             * access_token is valid and not expired
             */
            DB::table("access_tokens")
                ->where("access_token", $key->access_token)
                ->update(['uses' => $key->uses + 1]);
            return $key->access_token;
        } else {
            return "key not valid";
        }

    }

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

