<?php

namespace App\Http\Controllers;

use App\Helper\SearchHelper;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /*
     * triggered: resources/js/components/PlaylistSearch.vue
     *
     * Takes the search-query from input field on the home-page
     * and returns a limited amount of spotify-playlist in a
     * readable format.
     *
     * supports alternativ queries -> Playlist-URL and URI
     */

    private $searchHelper;

    public function __construct(SearchHelper $searchHelper)
    {
        $this->searchHelper = $searchHelper;
    }

    public function index(Request $request)
    {

        /*
         * $input could be: URL/URI or name)
         */
        $input = $request->input("query");

        //check if the input is an URL or URI, if then $matches[1] contains the ID
        if (
            preg_match('/playlist[:\/](\w*\d*)/',
                $input,
                $matches,
                PREG_UNMATCHED_AS_NULL) === 1
        ) {

            //it is an URL/URI
            $id = $matches[1];
            $result = $this->searchHelper->searchID($id);

            if (is_string($result)) {
                return response("no playlist found", 404);

            } else {
                // the search after an ID returns max. one playlist.
                $playlistArray[0] = array(
                    "spotifyID" => $result->id,
                    "name" => $result->name,
                    "owner" => $result->owner->display_name,
                    "mainImageURL" => $result->images[0]->url);
                return response($playlistArray, 200);
            }
        } else {
            //it is an name
            $result = $this->searchHelper->searchName($input);

            if (empty($result->playlists->items)) {
                return response("no playlist found", 404);
            } else {
                return response($this->searchHelper->fillPlaylistArray($result->playlists->items), 200);
            }
        }
    }


}
