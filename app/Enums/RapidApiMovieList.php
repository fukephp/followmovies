<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum RapidApiMovieList: string
{
    use Values;

    case MOST_POP_MOVIES = 'most_pop_movies';
    case TOP_BOXOFFICE_200 = 'top_boxoffice_200';
    case TOP_BOXOFFICE_LAST_WEEKEND_10 = 'top_boxoffice_last_weekend_10';
    case TOP_REATED_250 = 'top_rated_250';
    case TOP_RATED_ENGLISH_250 = 'top_rated_english_250';
    case TOP_RATED_LOWEST_100 = 'top_rated_lowest_100';
}
