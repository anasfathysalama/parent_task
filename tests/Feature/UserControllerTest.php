<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testGetAllData()
    {
        $response = $this->get('/api/v1/users');
        $response->assertJsonStructure([
            '*' => [
                'id',
                'email',
                'amount',
                'currency',
                'status',
                'created_at',
                'provider'
            ]
        ]);
        $response->assertStatus(200);
    }

    public function testFilterByProvider()
    {
        $response = $this->json('GET', '/api/v1/users?provider=DataProviderX');
        $response->assertJsonFragment([
            'provider' => 'DataProviderX'
        ]);
        $response->assertStatus(200);
    }

    public function testFilterByStatus()
    {
        $response = $this->json('GET', '/api/v1/users?statusCode=decline');
        $response->assertJsonFragment([
            'status' => 'decline'
        ]);
        $response->assertStatus(200);
    }

    public function testFilterByAmountRange()
    {
        $response = $this->json('GET', '/api/v1/users?balanceMin=100&balanceMax=200');
        $response->assertJsonFragment([
            'amount' => 200
        ]);
        $response->assertStatus(200);
    }

    public function testFilterByCurrency()
    {
        $response = $this->json('GET', '/api/v1/users?currency=USD');
        $response->assertJsonFragment([
            'currency' => 'USD'
        ]);
        $response->assertStatus(200);
    }

    public function testFilterByAll()
    {
        $url = "/api/v1/users?provider=DataProviderX&statusCode=authorised&balanceMin=200&balanceMax=400&currency=USD";
        $response = $this->json('GET', $url);
        $response->assertJsonFragment([
            "amount" => 200,
            "currency" => "USD",
            "status" => "authorised",
            "created_at" => "2018-11-30",
            "provider" => "DataProviderX"
        ]);
        $response->assertStatus(200);
    }
}
