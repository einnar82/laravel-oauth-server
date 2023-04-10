<?php

namespace Tests\Feature\Controllers\UsersController;

use App\Models\User;
use Database\Seeders\OAuth2ClientSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
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

    protected function getActingAsClient(array $scopes = ['*']): void
    {
        Passport::actingAsClient(
            Client::factory()->create(),
            $scopes
        );
    }

    protected function getActingAsUser(array $scopes = ['*'], ?User $user = null): void
    {
        Passport::actingAs(
            $user ?? User::factory()->create(),
            $scopes
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->runDatabaseMigrations();
        $this->seed(OAuth2ClientSeeder::class);
    }
}
