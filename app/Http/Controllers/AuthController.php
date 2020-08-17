<?php

namespace App\Http\Controllers;

use App\Helper\AuthHelper;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /*
     * triggered: SearchController, TrackController
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

    private $authHelper;

    public function __construct(AuthHelper $authHelper)
    {
        $this->authHelper = $authHelper;
    }

    public function key()
    {
        $key = DB::table("access_tokens")->first();
        if ($key === null) {
            /*
             * access_token is nonexistent -> generate a new key
             */
            $newKey = json_decode($this->authHelper->getKey()->content());
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
                ->update(['uses' => $key->uses + 1]);
            return $key->access_token;
        } else {
            /*
             * access_token is expired -> generate a new key
             */
            $newKey = json_decode($this->authHelper->getKey()->content());
            DB::table('access_tokens')
                ->where("access_token", $key->access_token)
                ->update(
                    [
                        'access_token' => $newKey->access_token,
                        'expires' => now()->addSeconds($newKey->expires_in),
                        'uses' => 1,
                        'created_at' => now()
                    ]
                );
            return $newKey->access_token;
        }
    }
}

