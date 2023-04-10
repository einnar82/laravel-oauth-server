<?php

namespace Tests\Feature\Controllers\UsersController;
use App\Models\User;

class ShowTest extends AbstractApiTestCase
{
    public function testShowSucceeds(): void
    {
        $user = User::factory()->create();
        $bearerToken = $this->createUserToken();

        $response = $this->getJson(\sprintf(self::BASE_URL.'/%s', $user->id), [
            'Authorization' => 'Bearer '.$bearerToken
        ]);

        $response->assertOk()
            ->assertJsonStructure(self::RESOURCE_RESPONSE_STRUCTURE);
        $payload = $response->json('data');
        $this->assertEquals($user->email, $payload['email']);
        $this->assertEquals($user->name, $payload['name']);
    }

    public function testUserNotFound(): void
    {
        $bearerToken = $this->createUserToken();

        $response = $this->getJson(\sprintf(self::BASE_URL.'/%s', 'no-id'), [
            'Authorization' => 'Bearer '.$bearerToken
        ]);

        $response->assertNotFound();
    }
}
