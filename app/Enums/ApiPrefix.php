<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum ApiPrefix: string
{
    use Values, InvokableCases;

    case AUTH_API_PREFIX = '/api/auth';
    case MOVIE_API_PREFIX = '/api/movies';
    case USER_API_PREFIX = '/api/users';
}
