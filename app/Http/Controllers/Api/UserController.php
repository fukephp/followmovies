<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Movie;
use App\ResponseJsonCollection\MainResponseJson;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class UserController extends Controller
{

    public function movies()
    {
        $user = auth()->user();

        return new MainResponseJson(UserResource::collection($user->movies), true, 'List of all followed movies', Http::OK);
    }

    public function followMovie(Movie $movie, Request $request)
    {
        $user = auth()->user();

        if($movie->users()->where('users.id', $user->id)->exists())
        {
            return new MainResponseJson([], false, 'Movie is already followed.', Http::NOT_ACCEPTABLE);
        }

        $movie->users()->attach($user->id);

        return new MainResponseJson(new UserResource($user), true, 'Follow', Http::OK);
    }

    public function unfollowMovie(Movie $movie, Request $request)
    {
        $user = auth()->user();

        $movie->users()->detach($user->id);

        return new MainResponseJson(new UserResource($user), true, 'Unfollow', Http::NO_CONTENT);
    }
}
