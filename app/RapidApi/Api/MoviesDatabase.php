<?php

namespace App\RapidApi\Api;

use App\RapidApi\RapidApiClient;

class MoviesDatabase extends RapidApiClient
{
    /**
     * @param string $prefix
     * @param array $optionalParameters
     * @return void
     */
    public function __construct(string $prefix = '/titles', array $optionalParameters = [])
    {
        $host = env('RAPIDAPI_MOVIESDB_HOST');

        $url = 'https://' . $host . $prefix;

        parent::__construct($host, $url, $optionalParameters);
    }
}
