<?php

namespace Tests\Feature\Controllers\UsersController;

use App\Models\User;

class ListTest extends AbstractApiTestCase
{
    public function testListSucceeds(): void
    {
        $user = User::factory()->create();
        User::factory(10)->create();
        $bearerToken = $this->createUserToken();

        $response = $this->getJson(self::BASE_URL, [
            'Authorization' => 'Bearer '.$bearerToken
        ]);
        $payload = $response->json('data');

        $response->assertSuccessful()
            ->assertJsonStructure(self::LIST_RESPONSE_STRUCTURE);
        $this->assertEquals($user->id, $payload[0]['id']);
        $this->assertEquals($user->email, $payload[0]['email']);
        $this->assertEquals($user->name, $payload[0]['name']);
    }
}
