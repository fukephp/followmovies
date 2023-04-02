<?php

namespace App\Http\Controllers\Api;

use App\Components\UserComponent;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class AuthController extends Controller
{
    /**
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $token = app(UserComponent::class)->login($request);

        if(!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect email/password'
            ], Http::UNAUTHORIZED());
        }

        return $this->respondWithToken($token, Http::OK());
    }

    /**
     * @param \App\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $token = app(UserComponent::class)->register($request);

        return $this->respondWithToken($token, Http::OK());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout(true);

        return response()->json([
            'success' => true,
            'message' => 'User is succesfully logout.',
        ], Http::OK());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function userDetalis(): JsonResponse
    {
        $user = auth()->user();

        return (new UserResource($user))
            ->additional([
                'message' => 'Authenticated User Details.',
                'success' => true,
            ])
            ->response()
            ->setStatusCode(Http::OK());
    }

    /**
     * Get the token array structure.
     * @param string $token
     * @param mixed $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $status): JsonResponse
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], $status);
    }
}
