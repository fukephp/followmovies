<?php

namespace App\Filters\Collections;

use App\Enums\Operator;
use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class MoviesFilter extends ApiFilter
{
    /**
     * @var array $safeParms
     */
    protected $safeParms = [];

    /**
     * @var array $columnMap
     */
    protected $columnMap = [];

    public function __construct()
    {
        $this->safeParms = [
            'title' => Operator::getAll(),
            'caption' => Operator::getAll(),
            'rating' => Operator::getAll([Operator::LIKE]),
            'vote_count' => Operator::getAll([Operator::LIKE]),
            'released_at' => Operator::getAll([Operator::LIKE]),
            'created_at' => Operator::getAll([Operator::LIKE]),
        ];
    }
}
