<?php

namespace Tests\Feature\Controllers\UsersController;

use App\Models\User;

class DeleteTest extends AbstractApiTestCase
{
    public function testDeleteSucceeds(): void
    {
        $user = User::factory()->create();
        $bearerToken = $this->createUserToken();

        $response = $this->deleteJson(\sprintf(self::BASE_URL.'/%s', $user->id), [], [
            'Authorization' => 'Bearer '.$bearerToken
        ]);

        $response->assertOk();
    }

    public function testUserNotFound(): void
    {
        $bearerToken = $this->createUserToken();

        $response = $this->deleteJson(\sprintf(self::BASE_URL.'/%s', 'no-id'), [], [
            'Authorization' => 'Bearer '.$bearerToken
        ]);

        $response->assertNotFound();
    }
}
