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

    /**
     * @param array|null $except
     * @return array
     */
    public static function getAll(array $except = null): array
    {
        $except = [self::LIKE];
        $operators = [
            self::EQUAL,
            self::LESS_THEN,
            self::LESS_THEN_EQUAL,
            self::GRATER_THAN,
            self::GRATER_THAN_EQUAL,
            self::LIKE
        ];

        if(!is_null($except)) {
            foreach($except as $exc) {
                if (($key = array_search($exc, $operators)) !== false)
                    unset($operators[$key]);
            }
        }

        return $operators;
    }

    /**
     * @return string
     */
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
