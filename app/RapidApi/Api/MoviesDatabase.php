<?php

namespace App\RapidApi\Api;

use App\RapidApi\RapidApiClient;

class MoviesDatabase extends RapidApiClient
{
    public function __construct(array $optionalParameters = [])
    {
        $host = env('RAPIDAPI_MOVIESDB_HOST');

        $url = 'https://' . $host . '/titles';

        parent::__construct($host, $url, $optionalParameters);
    }

    public function resultCollection(): array
    {
        $response = $this->getResponse()->collect();
        $result = [];

        if(!empty($response)) {
            foreach($response['results'] as $key => $data) {
                $result[$key]['image'] = $data['primaryImage']['url'];
                $result[$key]['title'] = $data['titleText']['text'];
            }
        }

        return $result;
    }
}
