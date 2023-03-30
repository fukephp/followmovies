<?php

namespace App\Http\Controllers\Api;

use App\Filters\Collections\MoviesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\ResponseJsonCollection\MainResponseJson;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $filter = new MoviesFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]

        if (empty($queryItems)) {
            return new MovieCollection(Movie::paginate());
        } else {
            $movies = Movie::where($queryItems)->paginate();

            return new MovieCollection($movies->appends($request->query()));

        }
    }

    public function show(Movie $movie)
    {
        return new MovieResource($movie);
    }

    public function store(StoreMovieRequest $request)
    {
        $credentials = $request->only('title', 'caption', 'image_url', 'rating', 'vote_count', 'released_at');

        $movie = Movie::create($credentials);

        if($movie)
            return new MainResponseJson(new MovieResource($movie), 'Movie is created.', true, Http::CREATED);
    }

    public function update(Movie $movie, UpdateMovieRequest $request)
    {
        $credentials = $request->only('title', 'caption', 'image_url', 'rating', 'vote_count', 'released_at');

        if($movie->update($credentials))
            return new MainResponseJson(new MovieResource($movie), 'Movie is updated.', true, Http::ACCEPTED);

    }

    public function destroy(Movie $movie)
    {
        if($movie->delete())
            return new MainResponseJson([], 'Movie is deleted.', true, Http::NO_CONTENT);
    }
}
