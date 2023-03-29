<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\ResponseJsonCollection\MainResponseJson;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class MovieController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $movies = Movie::all();

        return new MainResponseJson(MovieResource::collection($movies), true, 'List of all movies', Http::OK);
    }

    public function show(Movie $movie)
    {
        return new MainResponseJson(new MovieResource($movie), true, 'Single movie.', Http::OK);
    }

    public function store(StoreMovieRequest $request)
    {
        $credentials = $request->only('title', 'caption', 'image_url', 'rating', 'vote_count', 'released_at');

        $movie = Movie::create($credentials);

        if($movie)
            return new MainResponseJson(new MovieResource($movie), true, 'Movie is created.', Http::CREATED);
    }

    public function update(Movie $movie, UpdateMovieRequest $request)
    {
        $credentials = $request->only('title', 'caption', 'image_url', 'rating', 'vote_count', 'released_at');

        if($movie->update($credentials))
            return new MainResponseJson(new MovieResource($movie), true, 'Movie is updated.', Http::ACCEPTED);

    }

    public function destroy(Movie $movie)
    {
        if($movie->delete())
            return new MainResponseJson([], true, 'Movie is deleted.', Http::NO_CONTENT);
    }
}
