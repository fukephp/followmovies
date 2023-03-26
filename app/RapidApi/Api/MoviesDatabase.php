<?php

namespace App\RapidApi\Api;

use App\RapidApi\RapidApiClient;

class MoviesDatabase extends RapidApiClient
{
    public function __construct($prefix = '/titles', array $optionalParameters = [])
    {
        $host = env('RAPIDAPI_MOVIESDB_HOST');

        $url = 'https://' . $host . $prefix;

        parent::__construct($host, $url, $optionalParameters);
    }
}
