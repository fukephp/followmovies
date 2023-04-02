<?php

namespace App\Enums;

enum Operator: string
{
    case EQUAL = 'eq';
    case LESS_THEN = 'lt';
    case LESS_THEN_EQUAL = 'lte';
    case GRATER_THAN = 'gt';
    case GRATER_THAN_EQUAL = 'gte';
    case LIKE = 'like';

    public function toSymbol(): string
    {
        return match($this) {
            self::EQUAL => '=',
            self::LESS_THEN => '<',
            self::LESS_THEN_EQUAL => '<=',
            self::GRATER_THAN => '>',
            self::GRATER_THAN_EQUAL => '>=',
            self::LIKE => 'like',
            default => '='
        };
    }
}
