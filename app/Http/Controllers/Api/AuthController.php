<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if(!$token = auth()->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect email/password'
            ], Http::UNAUTHORIZED());
        }

        return $this->respondWithToken($token, Http::OK());
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token, Http::OK());
    }

    public function logout()
    {
        auth()->logout(true);

        return response()->json([
            'success' => true,
            'message' => 'User is succesfully logout.',
        ], Http::NO_CONTENT());
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function authenticatedUserDetails()
    {
        return response()->json([
            'success' => true,
            'message' => 'Authenticated User Details.',
            'data' => [
                'user' => auth()->user(),
            ],
        ], Http::OK());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $status)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], $status);
    }
}
