<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLogin(){
        $user = User::factory()->createOne();
        $response = $this->post(
            '/api/v1/login',
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
