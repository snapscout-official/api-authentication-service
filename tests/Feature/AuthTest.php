<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

use function PHPSTORM_META\map;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function testLogin(){
        $user = User::factory()->createOne();
        $response = $this->post(
            '/api/login',
            [
                'email' => $user->email,
                'password' => 'password'
            ]
            );
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'token',
                'token_type'
            ]
        ]);
        JWTAuth::setToken($response->json('data.token'))->checkOrFail();
    }
}
