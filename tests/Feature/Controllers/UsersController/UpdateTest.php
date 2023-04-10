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
        $this->getActingAsUser(['update_user']);

        $response = $this->putJson(\sprintf(self::BASE_URL.'/%s', $user->id), $data);

        $response->assertOk()
            ->assertJsonStructure(self::RESOURCE_RESPONSE_STRUCTURE);
        $payload = $response->json('data');
        $this->assertEquals($data['email'], $payload['email']);
        $this->assertEquals($data['name'], $payload['name']);
    }

    public function testUserNotFound(): void
    {
        $this->getActingAsUser(['update_user']);

        $response = $this->putJson(\sprintf(self::BASE_URL.'/%s', 'no-id'));

        $response->assertNotFound();
    }

    public function testUpdateIfThrowsValidationException(): void
    {
        $user = User::factory()->create();
        $this->getActingAsUser(['update_user']);

        $response = $this->putJson(\sprintf(self::BASE_URL.'/%s', $user->id), [
            'name' => 1
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
