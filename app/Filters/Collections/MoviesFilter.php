<?php

namespace App\Filters\Collections;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class MoviesFilter extends ApiFilter
{
    protected $safeParms = [
        'title' => ['eq', 'gt', 'lt', 'lte'],
        'rating' => ['eq', 'gt', 'lt', 'lte'],
        'vote_count' => ['eq', 'gt', 'lt', 'lte'],
        'released_at' => ['eq', 'gt', 'lt', 'lte'],
        'created_at'  => ['eq', 'gt', 'lt', 'lte']
    ];

    protected $columnMap = [];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
    ];

}
