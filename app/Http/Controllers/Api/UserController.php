<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class UserController extends Controller
{
    public function followingMovies(Request $request)
    {
        $user = auth()->user();

        return (new MovieCollection($user->movies))
            ->additional([
                'success' => true,
                'message' => 'List of all following movies'
            ])
            ->response()
            ->setStatusCode(Http::OK());
    }
}
