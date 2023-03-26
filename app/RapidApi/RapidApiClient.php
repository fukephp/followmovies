<?php

namespace App\RapidApi;

use GuzzleHttp\Middleware;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\RequestInterface;

class RapidApiClient
{
    private $clientResponse;

    public function __construct(mixed $host, mixed $url, array $params)
    {
        $response = $this->httpClient($host, $url, $params);

        $this->clientResponse = $response;
    }

    public function getResponse(): Response
    {
        return $this->clientResponse;
    }

    public function getJson(): array
    {
        return $this->clientResponse->json();
    }

    public function getCollection(): Collection
    {
        return $this->clientResponse->collect();
    }

    protected function httpClient($host, $url, $params): Response
    {
        $response = Http::withMiddleware(
            Middleware::mapRequest(function (RequestInterface $request) use ($host) {
                $request = $request->withHeader('X-RapidAPI-Key', env('RAPIDAPI_KEY'))
                                   ->withHeader('X-RapidAPI-Host', $host);
                return $request;
            })
        )->get($url, $params);

        return $response;
    }
}
