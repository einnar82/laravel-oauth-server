<?php

namespace Tests\Feature\Controllers\UsersController;

class CreateTest extends AbstractApiTestCase
{
    public function testCreateSucceeds(): void
    {
        $data = [
           'name' => $this->faker->name,
           'email' => $this->faker->safeEmail,
           'password' => 'somePassword'
        ];
        $bearerToken = $this->createUserToken();

        $response = $this->postJson(self::BASE_URL, $data, [
            'Authorization' => 'Bearer '.$bearerToken
        ]);

        $response->assertCreated()
            ->assertJsonStructure(self::RESOURCE_RESPONSE_STRUCTURE);
        $payload = $response->json('data');
        $this->assertEquals($data['email'], $payload['email']);
        $this->assertEquals($data['name'], $payload['name']);
    }
}
