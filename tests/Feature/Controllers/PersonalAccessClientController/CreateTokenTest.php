<?php

namespace Tests\Feature\Controllers\PersonalAccessClientController;

use App\Models\User;
use Database\Seeders\OAuth2ClientSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTokenTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function testCreateTokenSucceeds(): void
    {
        $this->seed(OAuth2ClientSeeder::class);
        $user = User::factory()->create();

        $response = $this->postJson(\sprintf('/api/personal-access-token/%s/create',$user->id));

        $payload = $response->json();
        $response->assertSuccessful();
        $this->assertNotNull($payload['access_token']);
    }

    public function testCreateTokenFailed(): void
    {
        $this->seed(OAuth2ClientSeeder::class);

        $response = $this->postJson(\sprintf('/api/personal-access-token/%s/create', 'no-id'));

        $response->assertNotFound();
    }
}
