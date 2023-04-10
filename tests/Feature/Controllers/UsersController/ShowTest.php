<?php

namespace Tests\Feature\Controllers\UsersController;
use App\Models\User;

class ShowTest extends AbstractApiTestCase
{
    public function testShowSucceeds(): void
    {
        $user = User::factory()->create();
        $this->getActingAsClient(['show_user']);

        $response = $this->getJson(\sprintf(self::BASE_URL.'/%s', $user->id));

        $response->assertOk()
            ->assertJsonStructure(self::RESOURCE_RESPONSE_STRUCTURE);
        $payload = $response->json('data');
        $this->assertEquals($user->email, $payload['email']);
        $this->assertEquals($user->name, $payload['name']);
    }

    public function testUserNotFound(): void
    {
        $this->getActingAsClient(['show_user']);

        $response = $this->getJson(\sprintf(self::BASE_URL.'/%s', 'no-id'));

        $response->assertNotFound();
    }
}
