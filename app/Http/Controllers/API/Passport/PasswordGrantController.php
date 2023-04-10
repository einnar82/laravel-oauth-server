<?php

namespace App\Http\Controllers\API\Passport;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Symfony\Component\HttpFoundation\Response;

class PasswordGrantController extends Controller
{
    public function __construct(
        private RefreshTokenRepository $refreshTokenRepository,
        private TokenRepository $tokenRepository
    ) {
    }

    public function login(Request $request): Response
    {
        $httpRequest = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => config('passport.password_grant_client.id'),
            'client_secret' => config('passport.password_grant_client.secret'),
            'username' => $request->username,
            'password' => $request->password,
            'scope' => $request->scope ?? '*',
        ]);

        return app()->handle($httpRequest);
    }

    public function logout(): JsonResponse
    {
        $bearerToken = request()->bearerToken();
        $tokenId = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText('empty', 'empty'))
            ->parser()
            ->parse($bearerToken)
            ->claims()
            ->get('jti');

        $this->tokenRepository->revokeAccessToken($tokenId);
        $this->refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

        return response()->json(['message' => 'ok']);
    }
}
