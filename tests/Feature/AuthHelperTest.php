<?php

namespace Tests\Feature;

use App\Helper\AuthHelper;
use Tests\TestCase;

class AuthHelperTest extends TestCase
{
    public function testGetKeyFunction()
    {
        $authHelper = new AuthHelper();
        $response = $authHelper->getKey();

        self::assertSame(200, $response->getStatusCode());
        self::assertIsString($response->content());
    }
}
