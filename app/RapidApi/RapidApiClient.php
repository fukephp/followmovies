<?php

namespace App\RapidApi;

use GuzzleHttp\Middleware;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\RequestInterface;

class RapidApiClient
{
    /**
     * @var \Illuminate\Http\Client\Response $clientResponse;
     */
    private \Illuminate\Http\Client\Response $clientResponse;

    /**
     * @param string $host
     * @param string $url
     * @param array $params
     * @return void
     */
    public function __construct(string $host, string $url, array $params)
    {
        $response = $this->httpClient($host, $url, $params);

        $this->clientResponse = $response;
    }

    /**
     * @return \Illuminate\Http\Client\Response
     */
    public function getResponse(): Response
    {
        return $this->clientResponse;
    }

    /**
     * @return array
     */
    public function getJson(): array
    {
        return $this->clientResponse->json();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCollection(): Collection
    {
        return $this->clientResponse->collect();
    }

    /**
     * @param string $host
     * @param string $url
     * @param array $params
     * @return \Illuminate\Http\Client\Response
     */
    protected function httpClient(string $host, string $url, array $params): Response
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
