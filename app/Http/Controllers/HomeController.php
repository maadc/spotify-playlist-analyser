<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function index(){
        return view("home", ["fetchURL" => URL::temporarySignedRoute('searchPlaylist', now()->addMinutes(5))]);
    }
}
