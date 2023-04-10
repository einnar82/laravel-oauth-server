<?php

namespace Tests\Feature\Controllers\PasswordGrantController;

use App\Models\User;
use Database\Seeders\OAuth2ClientSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function testLogoutSucceeds(): void
    {
        $this->seed(OAuth2ClientSeeder::class);
        $user  = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'username' => $user->email,
            'password' => 'password'
        ]);

        $payload = $response->json();

        $response = $this->putJson('/api/logout',[] , [
            'Authorization' => 'Bearer '. $payload['access_token']
        ]);

        $response->assertSuccessful();
    }

    public function testLogoutFailed(): void
    {
        $response = $this->putJson('/api/logout',[] , [
            'Authorization' => 'Bearer someInvalidToken'
        ]);

        $response->assertUnauthorized();
    }
}
