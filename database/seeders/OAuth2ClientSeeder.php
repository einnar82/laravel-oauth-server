<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OAuth2ClientSeeder extends Seeder
{
    /**
     * @const string
     */
    private const OAUTH_CLIENTS_TABLE = 'oauth_clients';

    /**
     * @const string[]
     */
    private const SELECTED_ENVIRONMENTS = ['local', 'testing'];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (\in_array(\config('app.env'), self::SELECTED_ENVIRONMENTS)) {
            DB::table(self::OAUTH_CLIENTS_TABLE)->truncate();
            DB::table('oauth_clients')->insert([
                [
                    'id' => '98e2e6a4-49ba-4e38-86fd-e68c6d2b38a9',
                    'user_id' => null,
                    'name' => 'Laravel Personal Access Client',
                    'secret' => 'pq13PBp9n8Ffatl8JCPuphJW6w6rCsLk81Ca22Lq',
                    'provider' => null,
                    'redirect' => 'http://localhost',
                    'personal_access_client' => 1,
                    'password_client' => 0,
                    'revoked' => 0,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ],
                [
                    'id' => '98e2e6a6-24a6-4cae-8a98-bab99de9b4bc',
                    'user_id' => null,
                    'name' => 'Laravel Password Grant Client',
                    'secret' => 'DLkq13i3IihVAanNe1BCgQG0avXljcDSYfwGnCes',
                    'provider' => 'users',
                    'redirect' => 'http://localhost',
                    'personal_access_client' => 0,
                    'password_client' => 1,
                    'revoked' => 0,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ],
                [
                    'id' => '98e2eaa2-bc34-4687-819d-cf7e5d6438fa',
                    'user_id' => null,
                    'name' => 'Laravel ClientCredentials Grant Client',
                    'secret' => 'jZskEWSflrjdF4tz14h4g5HkyceLWfQdApArCoDh',
                    'provider' => null,
                    'redirect' => '',
                    'personal_access_client' => 0,
                    'password_client' => 0,
                    'revoked' => 0,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ]
            ]);
        }
    }
}
