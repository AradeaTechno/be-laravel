<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{

    /*
    * ================================ TEST FOR POSTS ENDPOINT ==============================
    */
    public function test_can_create_post(){
        // Create a test user
        $user = \App\Models\User::factory()->create();

        // Generate a Sanctum token for the test user
        $token = $user->createToken('TestToken')->plainTextToken;

        // Set the Authorization header with the Bearer token
        $headers = [
            'Authorization' => "Bearer $token",
        ];

        // Data for the new post
        $data = [
            'user_id' => '1',
            'title' => 'Test Post 23', // Title is detected as unique, so need different title when create a post
            'content' => 'This is a test post content.',
        ];

        // Send the POST request with headers
        $response = $this->withHeaders($headers)->postJson('/api/posts', $data);

        // Assertions
        $response->assertStatus(201)
            ->assertJson([
                'status' => 201,
                'message' => 'Post created',
            ]);

        $this->assertDatabaseHas('posts', $data);
    }

    public function test_can_get_all_post(){
        // Create a test user
        $user = \App\Models\User::factory()->create();

        // Generate a Sanctum token for the test user
        $token = $user->createToken('TestToken')->plainTextToken;

        // Set the Authorization header with the Bearer token
        $headers = [
            'Authorization' => "Bearer $token",
        ];

        // Create some sample posts
        $posts = \App\Models\Post::factory()->count(3)->create(['user_id' => $user->id]);

        // Make a GET request to the posts endpoint with the headers
        $response = $this->withHeaders($headers)->getJson('/api/posts');

        $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'current_page',
                'data' => [
                    '*' => ['id', 'user_id', 'title', 'content', 'created_at', 'updated_at']
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]
        ]);
    }


    /*
    * ================================ TEST FOR USER ENDPOINT ==============================
    */
    public function test_can_create_user()
    {
        $data = [
            'name' => time().' Test User',
            'email' => time().'_test@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'user' => [
                    'name',
                    'email',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function test_can_get_all_user()
    {
        // Create a test user
        $user = \App\Models\User::factory()->create();

        // Generate a Sanctum token for the test user
        $token = $user->createToken('TestToken')->plainTextToken;

        // Set the Authorization header with the Bearer token
        $headers = [
            'Authorization' => "Bearer $token",
        ];

        // Make a GET request to the posts endpoint with the headers
        $response = $this->withHeaders($headers)->getJson('/api/users');

        $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'current_page',
                'data' => [
                    '*' => ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at']
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]
        ]);
    }

    /*
    * ============================= TEST FOR WEATHER ENDPOINT ==============================================
    */
    public function test_can_call_weather()
    {
        // Mock the weather API response
        $mockWeatherData = [
            'location' => ['name' => 'Perth'],
            'current' => ['temp_c' => 23.5, 'condition' => ['text' => 'Sunny']],
        ];

        Http::fake([
            'api.weatherapi.com/*' => Http::response($mockWeatherData, 200),
        ]);

        // Create a test user
        $user = \App\Models\User::factory()->create();

        // Generate a Sanctum token for the test user
        $token = $user->createToken('TestToken')->plainTextToken;

        // Set the Authorization header with the Bearer token
        $headers = [
            'Authorization' => "Bearer $token",
        ];

        // Make a GET request to the weather endpoint
        $response = $this->withHeaders($headers)->getJson('/api/weather');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'location' => ['name'],
                    'current' => [
                        'temp_c',
                        'condition' => ['text'],
                    ],
                ],
            ]);
    }
}
