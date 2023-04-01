<?php

namespace App\Http\Controllers\Api;

use App\Filters\Collections\MoviesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class MovieController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\MovieCollection
     */
    public function index(Request $request)
    {
        $filter = new MoviesFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator', 'value']]

        $query = Movie::query();

        $query->with('users');
        $query->withCount('users');

        if (empty($queryItems)) {
            return new MovieCollection($query->paginate());
        } else {
            $movies = $query->where($queryItems)->paginate();
            return new MovieCollection($movies->appends($request->query()));
        }
    }

    /**
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Movie $movie)
    {
        $movie->load('users')->loadCount('users');

        return (new MovieResource($movie))
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(Http::OK());
    }

    /**
     * @param \App\Http\Requests\StoreMovieRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function store(StoreMovieRequest $request)
    {
        $credentials = $request->only('title', 'caption', 'image_url', 'rating', 'vote_count', 'released_at');

        $movie = Movie::create($credentials);

        if($movie)
            return (new MovieResource($movie))
                ->additional(['success' => true, 'message' => 'Movie is created.'])
                ->response()
                ->setStatusCode(Http::CREATED());
    }

    /**
     * @param \App\Models\Movie $movie
     * @param \App\Http\Requests\UpdateMovieRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function update(Movie $movie, UpdateMovieRequest $request)
    {
        $credentials = $request->only('title', 'caption', 'image_url', 'rating', 'vote_count', 'released_at');

        if($movie->update($credentials))
            return (new MovieResource($movie))
                ->additional(['success' => true, 'message' => 'Movie is updated.'])
                ->response()
                ->setStatusCode(Http::ACCEPTED());

    }

    /**
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function destroy(Movie $movie)
    {
        if($movie->delete())
            return response()->json([
                'success' => true,
                'message' => 'Movie is deleted'
            ], Http::NO_CONTENT());
    }
}
