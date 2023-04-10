<?php

namespace Tests\Feature\Controllers\PasswordGrantController;

use App\Models\User;
use Database\Seeders\OAuth2ClientSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    /**
     * @const string[]
     */
    private const RESPONSE_STRUCTURE = [
        'access_token',
        'expires_in',
        'refresh_token',
        'token_type',
    ];

    public function testLoginSucceeds(): void
    {
        $this->seed(OAuth2ClientSeeder::class);

        $user  = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'username' => $user->email,
            'password' => 'password'
        ]);

        $payload = $response->json();
        $response->assertOk()
            ->assertJsonStructure(self::RESPONSE_STRUCTURE);
        $this->assertNotNull($payload['access_token']);
        $this->assertNotNull($payload['refresh_token']);
        $this->assertEquals('Bearer' , $payload['token_type']);
    }

    public function testLoginFailed(): void
    {
        $this->seed(OAuth2ClientSeeder::class);

        $response = $this->postJson('/api/login', [
            'username' => 'someUsername',
            'password' => 'somePassword'
        ]);

        $payload = $response->json();
        $response->assertBadRequest();
        $this->assertEquals('invalid_grant', $payload['error']);
        $this->assertNotNull($payload['error_description']);
        $this->assertNotNull($payload['message']);
    }
}
