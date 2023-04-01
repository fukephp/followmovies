<?php

namespace App\Components;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MovieComponent extends BaseComponent
{
    /**
     * @param \App\Http\Requests\StoreMovieRequest $request
     * @return \App\Models\Movie
     */
    public function create(StoreMovieRequest $request): Movie
    {
        $credentials = $request->only('title', 'caption', 'image_url', 'rating', 'vote_count', 'released_at');

        return Movie::create($credentials);
    }

    /**
     * @param \App\Models\Movie
     * @param \App\Http\Requests\UpdateMovieRequest $request
     * @return bool
     */
    public function update(Movie $movie, UpdateMovieRequest $request): bool
    {
        $credentials = $request->only('title', 'caption', 'image_url', 'rating', 'vote_count', 'released_at');

        return $movie->update($credentials);
    }
}
