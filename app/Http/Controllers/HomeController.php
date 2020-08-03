<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;

/*
 * triggered: on opening the front page
 *
 * This controller returns the home page with an URL as a temporarySignedRoute that points to
 * /api/playlist. This temporary URL is only 5 minutes valide. It's important for protecting the API.
 * How it works: https://laravel.com/docs/7.x/urls#signed-urls
 *
 */

class HomeController extends Controller
{
    public function index(){
        return view("home", ["fetchURL" => URL::temporarySignedRoute('searchPlaylist', now()->addMinutes(5))]);
    }
}
