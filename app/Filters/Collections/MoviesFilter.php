<?php

namespace App\Filters\Collections;

use App\Enums\Operator;
use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class MoviesFilter extends ApiFilter
{
    protected $safeParms = [
        'title' => [
            Operator::EQUAL,
            Operator::GRATER_THAN,
            Operator::LESS_THEN,
            Operator::LESS_THEN_EQUAL,
            Operator::LIKE,
        ],
        'rating' => [
            Operator::EQUAL,
            Operator::GRATER_THAN,
            Operator::LESS_THEN,
            Operator::LESS_THEN_EQUAL,
        ],
        'vote_count' => [
            Operator::EQUAL,
            Operator::GRATER_THAN,
            Operator::LESS_THEN,
            Operator::LESS_THEN_EQUAL,
        ],
        'released_at' => [
            Operator::EQUAL,
            Operator::GRATER_THAN,
            Operator::LESS_THEN,
            Operator::LESS_THEN_EQUAL,
        ],
        'created_at'  => [
            Operator::EQUAL,
            Operator::GRATER_THAN,
            Operator::LESS_THEN,
            Operator::LESS_THEN_EQUAL,
        ]
    ];

    protected $columnMap = [];
}
