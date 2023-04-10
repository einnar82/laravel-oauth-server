<?php

namespace Tests\Feature\Controllers\UsersController;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UpdateTest extends AbstractApiTestCase
{
    public function testUpdateSucceeds(): void
    {
        $user = User::factory()->create();
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
        ];
        $bearerToken = $this->createUserToken();

        $response = $this->putJson(\sprintf(self::BASE_URL.'/%s', $user->id), $data, [
            'Authorization' => 'Bearer '.$bearerToken
        ]);

        $response->assertOk()
            ->assertJsonStructure(self::RESOURCE_RESPONSE_STRUCTURE);
        $payload = $response->json('data');
        $this->assertEquals($data['email'], $payload['email']);
        $this->assertEquals($data['name'], $payload['name']);
    }

    public function testUserNotFound(): void
    {
        $bearerToken = $this->createUserToken();

        $response = $this->putJson(\sprintf(self::BASE_URL.'/%s', 'no-id'), [], [
            'Authorization' => 'Bearer '.$bearerToken
        ]);

        $response->assertNotFound();
    }

    public function testUpdateIfThrowsValidationException(): void
    {
        $user = User::factory()->create();
        $bearerToken = $this->createUserToken();

        $response = $this->putJson(\sprintf(self::BASE_URL.'/%s', $user->id), [
            'name' => 1
        ], [
            'Authorization' => 'Bearer '.$bearerToken
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
