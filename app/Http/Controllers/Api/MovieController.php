<?php

namespace App\Http\Controllers\Api;

use App\Filters\Collections\MoviesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
use App\Http\Resources\UserResource;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class MovieController extends Controller
{
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

    public function show(Movie $movie)
    {
        $movie->load('users')->loadCount('users');

        return (new MovieResource($movie))
            ->additional(['success' => true])
            ->response()
            ->setStatusCode(Http::OK());
    }

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

    public function update(Movie $movie, UpdateMovieRequest $request)
    {
        $credentials = $request->only('title', 'caption', 'image_url', 'rating', 'vote_count', 'released_at');

        if($movie->update($credentials))
            return (new MovieResource($movie))
                ->additional(['success' => true, 'message' => 'Movie is updated.'])
                ->response()
                ->setStatusCode(Http::ACCEPTED());

    }

    public function destroy(Movie $movie)
    {
        if($movie->delete())
            return response()->json([
                'success' => true,
                'message' => 'Movie is deleted'
            ], Http::NO_CONTENT());
    }

    public function follow(Movie $movie, Request $request)
    {
        $user = User::find(auth()->user()->id);

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

    /**
     * @param User $user
     * @param Movie $movie
     * @return int
     */
    protected function unfollow(User $user, Movie $movie): int
    {
        return $user->movies()->detach($movie->id);
    }
}
