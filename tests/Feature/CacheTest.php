<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_can_cache(){
        Cache::shouldReceive('get')
            ->once()
            ->with('test')
            ->andReturn([1,2,3,4]);
        $response = $this->get(route('cache'));
        $response->assertStatus(200);
        $this->assertTrue(true);
    }

}
