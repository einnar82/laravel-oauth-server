<?php

namespace App\Http\Controllers\API\Passport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonalAccessClientController extends Controller
{
    public function createToken(Request $request, User $user): JsonResponse
    {
        $response = $user->createToken('Sample Personal Access Token', $request->get('scope') ?? ['*']);
        return response()->json([
            'access_token' => $response->accessToken,
        ]);
    }
}
