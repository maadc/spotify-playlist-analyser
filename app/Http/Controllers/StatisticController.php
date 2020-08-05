<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public static function index()
    {
        $lastSearchedPlaylistsArray = [];
        $top10Array = [];

        $lastSearchedPlaylists = DB::table("top-playlists")
            ->orderBy("lastSearched", "desc")
            ->limit(10)
            ->get();

        foreach ($lastSearchedPlaylists as $playlist) {
            array_push($lastSearchedPlaylistsArray, $playlist);
        }

        $top10Playlists = DB::table("top-playlists")
            ->orderBy("counter", "desc")
            ->limit(10)
            ->get();

        foreach ($top10Playlists as $playlist) {
            array_push($top10Array, $playlist);
        }

        return view("statistics", [
            "playlistArray" => json_encode($lastSearchedPlaylistsArray),
            "top10Array" => json_encode($top10Array)]);
    }
}
