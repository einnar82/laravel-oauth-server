<?php

namespace Tests\Feature\Controllers\UsersController;

use App\Models\User;

class DeleteTest extends AbstractApiTestCase
{
    public function testDeleteSucceeds(): void
    {
        $user = User::factory()->create();
        $this->getActingAsUser(['delete_user']);

        $response = $this->deleteJson(\sprintf(self::BASE_URL.'/%s', $user->id));

        $response->assertOk();
    }

    public function testUserNotFound(): void
    {
        $this->getActingAsUser(['delete_user']);

        $response = $this->deleteJson(\sprintf(self::BASE_URL.'/%s', 'no-id'));

        $response->assertNotFound();
    }
}
