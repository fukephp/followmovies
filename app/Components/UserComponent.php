<?php

namespace App\Components;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;

class UserComponent extends BaseComponent
{
    /**
     * Attempt user to login and return token
     * @param \App\Http\Requests\LoginRequest $request
     * @return mixed
     */
    public function login(LoginRequest $request): mixed
    {
        $credentials = $request->only('email', 'password');

        if(!$token = auth()->attempt($credentials)) {
            return false;
        }

        return $token;
    }

    /**
     * Create new user and return auth token
     * @param \App\Http\Requests\RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request): mixed
    {
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        return auth()->login($user);
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Movie $movie
     * @return string
     */
    public function movieAttachOrDetach(User $user, Movie $movie): string
    {
        $message = '';

        if($user->movies()->where('movies.id', $movie->id)->exists())
        {
            $message = 'Unfollow';
            $user->movies()->detach($movie->id);
        } else {
            $message = 'Follow';
            $user->movies()->attach($movie->id);
        }

        return $message;
    }
}
