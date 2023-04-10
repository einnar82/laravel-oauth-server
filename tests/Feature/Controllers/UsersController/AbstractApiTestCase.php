<?php

namespace Tests\Feature\Controllers\UsersController;

use App\Models\User;
use Database\Seeders\OAuth2ClientSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

abstract class AbstractApiTestCase extends TestCase
{
    use DatabaseMigrations, RefreshDatabase, WithFaker;

    protected const BASE_URL = '/api/users';

    protected const LIST_RESPONSE_STRUCTURE = [
        'data',
        'links' => [
            "first",
            "last",
            "prev",
            "next",
        ],
        "meta" => [
            "current_page",
            "from",
            "path",
            "per_page",
            "to"
          ]
    ];

    protected const RESOURCE_RESPONSE_STRUCTURE = [
        'data' => [
            'created_at',
            'id',
            'email',
            'name',
            'updated_at'
        ]
    ];

    protected function createUserToken(string $scopes = '*'): string
    {
        $user  = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'username' => $user->email,
            'password' => 'password',
            'scope' => $scopes
        ]);

        $payload = $response->json();

        return $payload['access_token'];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(OAuth2ClientSeeder::class);
    }
}
