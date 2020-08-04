<?php

use Illuminate\Support\Facades\Route;

/*
 *
 * /api/playlist returns a limited amount of playlist-objects. This interface is post for a reason and signed to protect it.
 * A signed URL has an expire time and cant be manipulated. If the URL changes it's simply not valid anymore. Laravel would
 * throw an error. I couldn't use get-request for that reason. The URL get generated in the HomeController - on serverside.
 * But the parameter will be set on client-side in the PlaylistSearch.vue component. I had to add the parameter to the url after
 * it was created. The URL was not valid anymore.
 * With a POST-Request the URL stays the same but has the needed expire time.
 *
 * Documentation on how signed URL works: https://laravel.com/docs/7.x/urls#signed-urls
 *
 */

//Route::get('/auth', 'AuthController@key');

Route::get('/playlist', 'RedirectController@home');
Route::post('/playlist', 'PlaylistController@searchPlaylist')->name("searchPlaylist")->middleware('signed');
