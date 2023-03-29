<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class MovieController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $movies = Movie::all();

        return response()->json([
            'success' => true,
            'message' => 'List of all movies',
            'data' => [
                'movies' => $movies
            ]
        ], Http::OK());
    }

    public function show(Movie $movie)
    {
        if(!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found'
            ], Http::NOT_FOUND());
        }

        return response()->json([
            'success' => true,
            'message' => 'Single movie',
            'data' => [
                'movie' => $movie
            ]
        ], Http::OK());
    }

    public function store(StoreMovieRequest $request)
    {
        $credentials = $request->only('title', 'caption', 'image_url', 'rating', 'vote_count', 'released_at');

        $movie = Movie::create($credentials);

        if($movie)
            return response()->json([
                'success' => true,
                'message' => 'Movie is created',
                'data' => [
                    'movie' => $movie
                ]
            ], Http::CREATED());
    }

    public function update(Movie $movie, UpdateMovieRequest $request)
    {
        $credentials = $request->only('title', 'caption', 'image_url', 'rating', 'vote_count', 'released_at');

        if($movie->update($credentials))
            return response()->json([
                'success' => true,
                'message' => 'Movie is updated.',
                'data' => [
                    'movie' => $movie
                ]
            ], Http::ACCEPTED());

    }

    public function destroy(Movie $movie)
    {
        if($movie->delete())
            return response([
                'success' => true,
                'message' => 'Movie is removed.'
            ], Http::NO_CONTENT());
    }
}
