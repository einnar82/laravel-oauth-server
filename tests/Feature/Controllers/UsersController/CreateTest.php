<?php

namespace Tests\Feature\Controllers\UsersController;

use Symfony\Component\HttpFoundation\Response;

class CreateTest extends AbstractApiTestCase
{
    public function testCreateSucceeds(): void
    {
        $data = [
           'name' => $this->faker->name,
           'email' => $this->faker->safeEmail,
           'password' => 'somePassword',
           'password_confirmation' => 'somePassword'
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

    public function testCreateIfThrowsValidationException(): void
    {
        $bearerToken = $this->createUserToken();

        $response = $this->postJson(self::BASE_URL, [], [
            'Authorization' => 'Bearer '.$bearerToken
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
