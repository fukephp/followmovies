<?php

namespace App\Console\Commands;

use App\Models\Movie;
use App\RapidApi\Api\MoviesDatabase;
use Illuminate\Console\Command;

class StoreRapidApiMoviesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:store-rapid-api-movies-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store movies in DB featching data from RapidApi (MoviesDatabase API) https://rapidapi.com/SAdrian/api/moviesdatabase/details';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $host = env('RAPIDAPI_MOVIESDB_HOST');
        $url = 'https://' . $host . '/titles';

        $lists = [
            'most_pop_movies',
            'top_boxoffice_200',
            'top_boxoffice_last_weekend_10',
            'top_rated_250',
            'top_rated_english_250',
            'top_rated_lowest_100'
        ];

        $limit = $this->ask('Number of titles per page (default: 10) -> 10 max?', 10);
        $page = $this->ask('Select page number', 1);
        $list = $this->choice('Selected list', $lists, 'top_rated_english_250');

        $searchParams = [
            'titleType' => 'movie',
            'list' => $list,
            'limit' => $limit,
            'page' => $page,
        ];

        $this->info("Using Rapid API MoviesDatabase({$url})");
        $this->info("This command will fetch list of top 200 box office movies.");

        $this->previewTable($searchParams, 'Preview parameters table');

        if($this->confirm('Proceed with fetching movies', true))
        {
            $response = new MoviesDatabase('/titles', $searchParams);

            $responseRecords = $response->getJson();

            $this->insertRecords($responseRecords);

            $this->info("All movies(limit: {$limit}) are stored in DB!");
        }
    }

    protected function insertRecords($responseRecords)
    {
        if(!empty($responseRecords['results'])) {
            foreach($responseRecords['results'] as $key => $result)
            {
                $movieRatings = new MoviesDatabase('/titles' . '/' . $result['id'] . '/ratings');
                $movieRatings = $movieRatings->getJson();
                $resultData = [];

                $resultData['image_url'] = !is_null($result['primaryImage']) ? $result['primaryImage']['url'] : '';
                $resultData['title'] = $result['titleText']['text'];
                $resultData['caption'] = !is_null($result['primaryImage']) ? $result['primaryImage']['caption']['plainText'] : '';
                $resultData['rating'] = !empty($movieRatings['results']) ? $movieRatings['results']['averageRating'] : 0.0;
                $resultData['vote_count'] = !empty($movieRatings['results']) ? $movieRatings['results']['numVotes'] : 0;
                $resultData['released_at'] = $result['releaseDate']['year'] . '-' . $result['releaseDate']['month'] . '-' . $result['releaseDate']['day'];

                try {
                    $movie = Movie::create($resultData);
                    $this->info("Movie {$movie->title} is stored.");
                } catch (\Illuminate\Database\QueryException $exception) {
                    dump($exception->getMessage());
                    $this->error('Movie store is failed move to next record. Error message:'. $exception->getMessage());
                    exit;
                }
            }
        }
    }

    protected function previewTable(array $previewTable, $msg = '')
    {
        if($msg != '')
            $this->info($msg);

        $this->table(
            array_keys($previewTable),
            [$previewTable]
        );
    }


}
