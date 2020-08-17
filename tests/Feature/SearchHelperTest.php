<?php

namespace Tests\Feature;

use App\Helper\SearchHelper;
use Tests\TestCase;

class SearchHelperTest extends TestCase
{

    public function testFillPlaylistArray()
    {
        $seachHelper = new SearchHelper;

        $input = [
            (object)array(
                'id' => 'id1',
                'images' =>
                    array(
                        0 =>
                            (object)array(
                                'url' => 'url1'
                            ),
                    ),
                'name' => 'name1',
                'owner' =>
                    (object)array(
                        'display_name' => 'owner1',
                    ),
            ),
            (object)array(
                'id' => 'id2',
                'images' =>
                    array(
                        0 =>
                            (object)array(
                                'url' => 'url2'
                            ),
                    ),
                'name' => 'name2',
                'owner' =>
                    (object)array(
                        'display_name' => 'owner2',
                    ),
            ),
        ];

        $object = $seachHelper->fillPlaylistArray($input);

        $expected = [
            [
                "spotifyID" => "id1",
                "name" => "name1",
                "owner" => "owner1",
                "mainImageURL" => "url1",
            ],
            [
                "spotifyID" => "id2",
                "name" => "name2",
                "owner" => "owner2",
                "mainImageURL" => "url2",
            ]
        ];
        self::assertSame($expected, $object);
    }

    public function testSearchName()
    {
        $object = (new SearchHelper)->searchName('test');
        self::assertNotEmpty($object->playlists);
    }
    public function testSearchID()
    {
        $object = (new SearchHelper)->searchID('7np1gVF9pWxpK9VOm6qxhJ');
        self::assertNotEmpty($object);
    }
    public function testSearchIDNotFound()
    {
        $object = (new SearchHelper)->searchID('7np1xhJ');
        self::assertSame("ID not found", $object);
    }
}
