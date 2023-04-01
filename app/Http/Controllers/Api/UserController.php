<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieCollection;
use App\Http\Resources\UserResource;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use JustSteveKing\StatusCode\Http;

class UserController extends Controller
{
    public function favoriteMovies(Request $request)
    {
        $user = auth()
            ->user()
            ->load('movies')
            ->loadCount('movies');

        return (new UserResource(Cache::remember('favorite_movies', now()->addDay(), function () use ($user) {
            return $user;
        })))
            ->additional([
                'success' => true,
                'message' => 'List of all favorite movies'
            ])
            ->response()
            ->setStatusCode(Http::OK());
    }

    /**
     * @param \App\Models\Movie $movie
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(Movie $movie, Request $request)
    {
        Cache::forget('favorite_movies');

        $user = auth()
            ->user()
            ->load('movies')
            ->loadCount('movies');

        if($user->movies()->where('movies.id', $movie->id)->exists())
        {
            $message = 'Unfollow';
            $user->movies()->detach($movie->id);
        } else {
            $message = 'Follow';
            $user->movies()->attach($movie->id);
        }

        return (new UserResource($user))
                ->additional(['success' => true, 'message' => $message])
                ->response()
                ->setStatusCode(Http::OK());
    }
}
