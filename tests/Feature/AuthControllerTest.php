<?php

namespace Tests\Feature;

use App\accessToken;
use App\Helper\AuthHelper;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenNoAccessTokenIsInDB()
    {
        $mockResult = '{"access_token":"test","expires_in":3600}';
        $mock = Mockery::mock(AuthHelper::class);
        $mock->shouldReceive('getKey')
            ->andReturn(response($mockResult,200));

        $authController = new AuthController($mock);
        $result = $authController->key();

        self::assertIsString($result);
        self::assertDatabaseHas('access_tokens', [
            'access_token' => "test",
            'expires' => now()->addSeconds(3600)
        ]);
    }

    public function testKeyIsNotExpiredByTime(){
        $token = accessToken::create([
            'access_token' => 'test',
            'expires' =>  now()->addSeconds(20),
            'created_at' => now()
        ]);
        $token->save();

        $authController = new AuthController(new AuthHelper);
        $result = $authController->key();

        self::assertDatabaseHas('access_tokens', [
            'access_token' => "test",
            'expires' => now()->addSeconds(20),
            'created_at' => now(),
            'uses' => 2
        ]);
        self::assertSame($result, 'test');
    }

    public function testKeyIsExpiredByUses(){
        $token = accessToken::create([
            'access_token' => 'test',
            'expires' =>  now()->addSeconds(20),
            'created_at' => now(),
            'uses' => 60
        ]);
        $token->save();

        $mockResult = '{"access_token":"testNEW","expires_in":3600}';
        $mock = Mockery::mock(AuthHelper::class);
        $mock->shouldReceive('getKey')
            ->andReturn(response($mockResult,200));

        $authController = new AuthController($mock);
        $result = $authController->key();

        self::assertDatabaseHas('access_tokens', [
            'access_token' => "testNEW",
            'expires' => now()->addSeconds(3600),
            'uses' => 1
        ]);
        self::assertSame('testNEW', $result);
    }

    public function testKeyIsExpiredByTime(){
        $token = accessToken::create([
            'access_token' => 'test',
            'expires' =>  now()->addSeconds(-3600),
            'created_at' => now(),
            'uses' => 1
        ]);
        $token->save();

        $mockResult = '{"access_token":"testNEW","expires_in":3600}';
        $mock = Mockery::mock(AuthHelper::class);
        $mock->shouldReceive('getKey')
            ->andReturn(response($mockResult,200));

        $authController = new AuthController($mock);
        $result = $authController->key();

        self::assertDatabaseHas('access_tokens', [
            'access_token' => "testNEW",
            'expires' => now()->addSeconds(3600),
            'uses' => 1
        ]);
        self::assertSame('testNEW', $result);
    }
}
