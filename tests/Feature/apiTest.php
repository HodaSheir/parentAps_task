<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class apiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->json('GET', '/api/v1/users');
        $response
            ->assertStatus(200);
    }
    
    public function testExampleProvider()
    {
        $response = $this->json('GET', '/api/v1/users?provider=DataProviderX');
        $response
            ->assertStatus(200);
    }
    
    public function testExampleStatus()
    {
        $response = $this->json('GET', '/api/v1/users?statusCode=authorised ');
        $response
            ->assertStatus(200);
    }
    
    public function testExampleCurrency()
    {
        $response = $this->json('GET', '/api/v1/users?currency=EUR');
        $response
            ->assertStatus(200);
    }
   
}
