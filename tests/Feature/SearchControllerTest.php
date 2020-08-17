<?php

namespace Tests\Feature;

use App\Helper\SearchHelper;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    private $mockRequest;
    private $mockSearchHelper;
    private $searchController;

    /**
     * @before
     */
    public function setupMocks()
    {
        $this->mockRequest = Mockery::mock(Request::class);


        $this->mockSearchHelper = Mockery::mock(SearchHelper::class);
        $this->mockSearchHelper
            ->shouldReceive('fillPlaylistArray')
            ->andReturn("filledPlaylistArray");

        $this->searchController = new SearchController($this->mockSearchHelper);
    }

    public function testWithPlaylistNameFound()
    {
        $searchNameReturn = (object)[
            "playlists" => (object)[
                "items" => [
                    ["test"],
                    ["test"]
                ]
            ]
        ];

        $this->mockSearchHelper
            ->shouldReceive('searchName')
            ->andReturn($searchNameReturn);

        $this->mockRequest
            ->shouldReceive('input')
            ->andReturn('testPlaylistName');

        $object = $this->searchController->index($this->mockRequest);

        self::assertSame(200, $object->getStatusCode());
        self::assertSame("filledPlaylistArray", $object->content());
    }

    public function testWithPlaylistNameNotFound()
    {
        $searchNameReturn = (object)[
            "playlists" => (object)[
                "items" => []
            ]
        ];

        $this->mockSearchHelper
            ->shouldReceive('searchName')
            ->andReturn($searchNameReturn);

        $this->mockRequest
            ->shouldReceive('input')
            ->andReturn('testPlaylistNameNotFound');
        $object = $this->searchController->index($this->mockRequest);

        self::assertSame(404, $object->getStatusCode());
        self::assertSame("no playlist found", $object->content());
    }

    /*
    * Test if the function can extract the ID of the playlistLink
    */
    public function testWithPlaylistURI()
    {
        $this->mockRequest
            ->shouldReceive('input')
            ->andReturn('spotify:playlist:5F0AZDt29jRBR1PktMX5PV');

        $idObject = (object)[
            "id" => "id1",
            "name" => "name1",
            "owner" => (object)[
                "display_name" => "test"
            ],
            "images" => [
                0 => (object)[
                    "url" => "url1"
                ]
            ]
        ];

        $this->mockSearchHelper
            ->shouldReceive('searchID')
            ->with("5F0AZDt29jRBR1PktMX5PV")
            ->andReturn($idObject);

        $object = $this->searchController->index($this->mockRequest);

        self::assertSame(200, $object->getStatusCode());
        self::assertSame(
            '[{"spotifyID":"id1","name":"name1","owner":"test","mainImageURL":"url1"}]'
            , $object->content());
    }

    /*
     * Test if the function can extract the ID of the playlistLink
     */
    public function testWithPlaylistURL()
    {
        $this->mockRequest
            ->shouldReceive('input')
            ->andReturn('https://open.spotify.com/playlist/5F0AZDt29jRBR1PktMX5PV?si=nv5ASNRSQS6fBSOaR3X3sg');

        $idObject = (object)[
            "id" => "id1",
            "name" => "name1",
            "owner" => (object)[
                "display_name" => "test"
            ],
            "images" => [
                0 => (object)[
                    "url" => "url1"
                ]
            ]
        ];

        $this->mockSearchHelper
            ->shouldReceive('searchID')
            ->with("5F0AZDt29jRBR1PktMX5PV")
            ->andReturn($idObject);

        $object = $this->searchController->index($this->mockRequest);

        self::assertSame(200, $object->getStatusCode());
        self::assertSame('[{"spotifyID":"id1","name":"name1","owner":"test","mainImageURL":"url1"}]', $object->content());
    }

    public function testWithWrongID()
    {
        $this->mockRequest
            ->shouldReceive('input')
            ->andReturn('https://open.spotify.com/playlist/5F0AZDt29jRBRX5PV?si=nv5ASNRSQS6fBSOaR3X3sg');


        $this->mockSearchHelper
            ->shouldReceive('searchID')
            ->with("5F0AZDt29jRBRX5PV")
            ->andReturn('ID not found');

        $object = $this->searchController->index($this->mockRequest);

        self::assertSame(404, $object->getStatusCode());
        self::assertSame("no playlist found", $object->content());
    }
}
