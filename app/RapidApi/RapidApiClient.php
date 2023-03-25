<?php

namespace App\RapidApi;

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\RequestInterface;

class RapidApiClient
{
    public function setupClient()
    {
        $response = Http::withMiddleware(
            Middleware::mapRequest(function (RequestInterface $request) {
                $request = $request->withHeader('X-RapidAPI-Key', env('RAPIDAPI_KEY'))
                                   ->withHeader('X-RapidAPI-Host', env('RAPIDAPI_HOST'));
                return $request;
            })
        )->get('https://moviesdatabase.p.rapidapi.com/titles', [
            'startYear' => 2020,
            'genre' => 'Action',
            'titleType' => 'Movie'
        ]);

        return $response->json();
    }
}
